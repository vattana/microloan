<script type="text/javascript">
	function focusit() {			
		document.getElementById("lid").focus();
		}
	window.onload = focusit;
	///////////////////////
</script>
<!-- suggestion cif -->
	<script type="text/javascript">
				var nameArray = null;
	</script>
	 <script type="text/javascript">
            function doSuggestionBox(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
                // determine whether to display suggestion box or not
                if (input == "") {
                    document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                } else {
                    document.getElementById('divSuggestions').style.visibility = 'visible'; // shows the suggestion box
                    doSuggestions(text);
                }
            }
			function doTotalAmount(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
				if (input == "")
				{
					//alert(document.getElementById("total_amt_hiden").value);
					var input1 = document.getElementById("total_amt_hiden").value;
					document.getElementById("total_amt").value = input1;
					document.getElementById("remain").value = 0; 
					return;
				}
				if (parseFloat(input)<=parseFloat(document.getElementById("total_amt_hiden").value)){
					document.getElementById("total_amt").value = (document.getElementById("total_amt_hiden").value-input).toFixed(2);
					document.getElementById("remain").value = 0; 

				}
			    else if (parseFloat(input)>parseFloat(document.getElementById("total_amt_hiden").value)){
					document.getElementById("remain").value = (input - document.getElementById("total_amt_hiden").value).toFixed(2); 
					document.getElementById("total_amt").value = 0;
		
					
				} 	
				

            }
			function doTotalPenalty(text) { // function that takes the text box's inputted text as an argument
                var input = text; // store inputed text as variable for later manipulation
				if (input == "")
				{
					//alert(document.getElementById("total_amt_hiden").value);
					var input1 = document.getElementById("repay_penalty_hiden").value;
					document.getElementById("repay_penalty").value = input1;
					document.getElementById("repay_penalty_remain").value = 0; 
					return;
				}
				if (parseInt(input)<=parseInt(document.getElementById("repay_penalty_hiden").value)){
					document.getElementById("repay_penalty").value = (document.getElementById("repay_penalty_hiden").value-input).toFixed(2);
					document.getElementById("repay_penalty_remain").value = 0; 

				}
			    else if (parseInt(input)>parseInt(document.getElementById("repay_penalty_hiden").value)){
					/*document.getElementById("repay_penalty_remain").value = (input - document.getElementById("repay_penalty_hiden").value).toFixed(2); 
					document.getElementById("repay_penalty").value = 0;*/
					alert("you can't input penalty > total penalty.");
						
						document.getElementById("g_pn").focus();
				} 	
				

            }
            function outClick() {
                document.getElementById('divSuggestions').style.visibility = 'hidden';
            }
            function doSelection(text) {
                var selection = text;
                document.getElementById('divSuggestions').style.visibility = 'hidden'; // hides the suggestion box
                document.getElementById("lid").value = selection;
            }
            function changeBG(obj) {
                element = document.getElementById(obj);
                oldColor = element.style.backgroundColor;
                if (oldColor == "white" || oldColor == "") {
                    element.style.background = "blue";
                    element.style.color = "white";
                    element.style.cursor = "pointer";
                } else {
                    element.style.background = "white";
                    element.style.color = "#333333";
                    element.style.cursor = "pointer";
                }
            }
            function doSuggestions(text) {
                var input = text;
                var inputLength = input.toString().length;
                var code = "";
                var counter = 0;
                while(counter < this.nameArray.length) {
                    var x = this.nameArray[counter]; // avoids retyping this code a bunch of times
                    if(x.substr(0, inputLength).toLowerCase() == input.toLowerCase()) {
                        code += "<div id='" + x + "'onmouseover='changeBG(this.id);' onMouseOut='changeBG(this.id);' onclick='doSelection(this.innerHTML)'>" + x + "</div>";
                    }
                    counter += 1;
                }
                if(code == "") {
                    outClick();
                }
                document.getElementById('divSuggestions').innerHTML = code;
                document.getElementById('divSuggestions').style.overflow='auto';
            }
        </script>
<style type="text/css">
            <!--
            div.suggestions {
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                border: 1px solid #999999;
                text-align: left;
				z-index:0;
            }
            -->
</style>
<!-- end suggestion cif -->
<?php
		$query = "SELECT * FROM saving_process ORDER BY id ASC";
			$result = mysql_query($query);
			$counter = 0;
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['sid']) . " ';");
					$counter += 1;
				}
			}
			echo("</script>");
?>
<?php
		//---------------------------transaction-------------------------//
		include('pages/module.php');
		$user = $_SESSION['usr'];
					///check branch no------------
					$br_ip = $_SERVER['REMOTE_ADDR'];
					$br_sql="Select * from br_ip_mgr where set_ip ='$br_ip'";
					$result_br=mysql_query($br_sql) or die (mysql_error());
						while($row = mysql_fetch_array($result_br))
								{
									$get_ip=$row['set_ip'];
									$get_br=$row['br_no'];	 
								}
					//end check branch no------
					//check max id
				//////////////////
				$query_maxid = "SELECT max(max_id) as code FROM invoice"; 
					$result_maxid = mysql_query($query_maxid) or die(mysql_error());
					// Print out result
					while($row = mysql_fetch_array($result_maxid)){
						$max = $row['code'];
						$convert = intval($max);
						$max += 1;
						if (strlen($max)==1){ 
							$max='0000'.$max;
						}
						else if((strlen($max)==2)){
							$max='000'.$max;
						}
						else if((strlen($max)==3)){
							$max='00'.$max;
						}
						else if((strlen($max)==4)){
							$max='0'.$max;
						}
						else {
							$max = $max ;
						}
					}
					///end check max id-----	
		//---check display----------------
	  	if(isset($_POST['display'])){
			$lid = $_POST['lid'];
			$dis_repay_date=date('Y-m-d',strtotime($_POST['repay_date']));
			
			$mydate=date('d-m-Y',strtotime($dis_repay_date));
			//display loan info
			$display_info="SELECT * FROM saving_process WHERE sid='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$reg_id = $row['regis_id'];
						$cid = $row['cid'];
						$l_currency=$row['cur'];
						$reg_date = $row['reg_date'];
					}
			//display approval info
			$display_appinfo="SELECT * FROM customer_app WHERE cid='$cid' and register_date='$reg_date'";
			$result_appinfo=mysql_query($display_appinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_appinfo)){
						$rate = $row['approval_rate'];
					}
			//-----start show currency
			$display_reginfo="SELECT * FROM register WHERE cif='$cid'";
			$result_reginfo=mysql_query($display_reginfo) or die (mysql_error());
			$check_dis=mysql_num_rows($result_reginfo);
				while($row=mysql_fetch_array($result_reginfo)){
						$kh_borrower=$row['kh_borrower'];
						
						$dis=$row['dis'];
					}
				//////end register-------------//
				/////Get today penalty
				$due_amt=0;
			$query_pn=" select sum(w.amount) amt from witdraw w where w.ld='$lid'";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				if($l_currency=='USD'){
					$due_amt1=round($row['amt'],3);
				}
				else{
					$due_amt1=roundkhr($row['amt'],$round_khr);
				}
			}
			
			$query_pn=" select sum(a.inter) amt from accrued_sinter a where a.ld='$lid'";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				if($l_currency=='USD'){
					$due_amt2=round($row['amt'],3);
				}
				else{
					$due_amt2=roundkhr($row['amt'],$round_khr);
				}
			}
			
			$due_amt1=$due_amt1-$due_amt2;
			
			if ($due_amt1<0){
				$interest= -($due_amt1);
				$due_amt1=0;
				$penalty=0;
				
			}
			else{
				$interest=0;
				$penalty=0;	
			}
							
			$query_pn=" select sum(d.amount) amt from deposit d where d.ld='$lid'";
			$result_pn=mysql_query($query_pn);
			echo mysql_error();
			while($row = mysql_fetch_array($result_pn))
			{
				if($l_currency=='USD'){
					$due_amt=round($row['amt']-$due_amt1,3);
				}
				else{
					$due_amt=roundkhr($row['amt']-$due_amt1,$round_khr);
				}
				
			}
				
				$min_no='saving';
				/////////////
				if($min_no==''){
					echo"<script>alert('There is no this record in System! Please Check again!');</script>";	
					echo"<script>window.location.href='index.php?pages=deposit_form';</script>";
					exit();
					}
				///check dis
			}///isset displaay
			
	//--check ld
	//---end diplay
	//---------start disbursement----------------//
		if(isset($_POST['withdrawal_bt'])){
			$lid = trim($_POST['lid']);
			$myreg_id=$_POST['reg_id'];
			$amt=$_POST['amt'];
			$mycur=$_POST['cur'];
			$interest=$_POST['interest'];
			$kh_borrower=$_POST['cust_name'];
			$due_amt=$_POST['due_amt'];
			$repay_date=date('Y-m-d',strtotime($_POST['repay_date']));
			//display loan info
			$display_info="SELECT * FROM saving_process WHERE sid='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
					$cid = $row['cid'];	
				}
			//Get Rounding
			$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$round_khr=$row['setting'];
				}
			//Get Penalty rate	
			/*$round_khinfo="SELECT setting FROM loan_config WHERE property='psaving'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$penaltyrate=$row['setting'];
				}*/
			// Verify this loan is fix or not
			$query_isfix=" select isfix,frate,nrate,penalty from deposit d where d.ld='$lid'";
			$result_isfix=mysql_query($query_isfix);
			echo mysql_error();
			while($row = mysql_fetch_array($result_isfix))
			{
				$isfix=$row['isfix'];	
				$frate = $row['frate'];
				$nrate = $row['nrate'];
				$prate = $row['penalty'];
			}
			
			if($isfix==0){
				$insert_saving="insert into witdraw(ld,cid,amount,date,user,cur,status) values('$lid','$cid','$amt','$repay_date','$user','$mycur','n')";
				mysql_query($insert_saving) or die (mysql_error());	
			}
			else{
				/*$query_pn=" select setting from loan_config d where d.property='Nsaving'";
					$result_pn=mysql_query($query_pn);
					echo mysql_error();
					while($row = mysql_fetch_array($result_pn))
					{
						$rate =$row['setting'];
					}*/
				if($mycur=='USD'){
					$penalty=round(($due_amt*$prate)/100,3);
					$query_int="select amount,id from accrued_sinter d where d.ld='$lid'";
					$result_int=mysql_query($query_int);
					echo mysql_error();
					$int=0;
					while($row = mysql_fetch_array($result_int))
					{
						$amount=$row['amount'];
						$id=$row['$id'];
						$inter=$row[$inter];
						$rate = $nrate/365;
						$inte = ($amount*$rate)/100;
						$int=$int+($inter-$inte);
						$update_int="update accrued_sinter set inter='$inte',$isfix='$isfix' where id='$id'";
				mysql_query($update_int) or die (mysql_error());	
					}
				}
				else if($mycur=='THB'){
					$penalty=intval(($due_amt*$prate)/100,3);
					$query_int="select amount,id from accrued_sinter d where d.ld='$lid'";
					$result_int=mysql_query($query_int);
					echo mysql_error();
					$int=0;
					while($row = mysql_fetch_array($result_int))
					{
						$amount=$row['amount'];
						$id=$row['$id'];
						$inter=$row[$inter];
						$rate = $nrate/365;
						$inte = ($amount*$rate)/100;
						$int=$int+($inter-$inte);
						$update_int="update accrued_sinter set inter='$inte',$isfix='$isfix' where id='$id'";
				mysql_query($update_int) or die (mysql_error());	
					}
				}
				else{
					$penalty=roundkhr(($due_amt*$prate)/100,$round_khr);
					$query_int="select amount,id,inter from accrued_sinter d where d.ld='$lid'";
					$result_int=mysql_query($query_int);
					echo mysql_error();
					$int=0;
					while($row = mysql_fetch_array($result_int))
					{
						$amount=$row['amount'];
						$id=$row['$id'];
						$inter=$row[$inter];
						$rate = $nrate/365;
						$inte = ($amount*$rate)/100;
						$int=$int+($inter-$inte);
						$update_int="update accrued_sinter set inter='$inte',$isfix='$isfix' where id='$id'";
				mysql_query($update_int) or die (mysql_error());	
					}
				}
				
				$update_int="update deposit set isfix='$isfix' where ld='$lid'";
				mysql_query($update_int) or die (mysql_error());
				
				$insert_saving="insert into witdraw(ld,cid,amount,date,user,cur,status) values('$lid','$cid','$amt','$repay_date','$user','$mycur','n')";
				mysql_query($insert_saving) or die (mysql_error());
				
				$insert_saving="insert into witdraw(ld,cid,amount,date,user,cur,status) values('$lid','$cid','$penalty','$repay_date','$user','$mycur','p')";
				mysql_query($insert_saving) or die (mysql_error());	
				echo "<script>alert('Penalty=$penalty,Interest=$int,Total Amount=$amt-$int-$penalty')</script>";
				echo "<script>alert('Succesful')</script>";
				echo"<script>window.location.href='index.php?pages=witdraw_form&catch=repay';</script>";
			}
			
			
		}
		if(isset($_POST['withdrawal'])){//start schedule 
			$lid = trim($_POST['lid']);
			$myreg_id=$_POST['reg_id'];
			$amt=$_POST['amt'];
			$mycur=$_POST['cur'];
			$interest=$_POST['interest'];
			$kh_borrower=$_POST['cust_name'];
			$repay_date=date('Y-m-d',strtotime($_POST['repay_date']));
			//display loan info
			$display_info="SELECT * FROM saving_process WHERE sid='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
					$cid = $row['cid'];	
					$mygl=$row['glcode'];
				}
					
					
			$query_isfix=" select isfix from deposit d where d.ld='$lid'";
			$result_isfix=mysql_query($query_isfix);
			echo mysql_error();
			while($row = mysql_fetch_array($result_isfix))
			{
				$isfix=$row['isfix'];
				
			}
			
			/*/Account
			$display_reginfo="SELECT * FROM glp_acc WHERE glcode='$mygl' and  `desc`='Principal'";
		$result_reginfo=mysql_query($display_reginfo) or die (mysql_error());
			$i=0;
			while($row=mysql_fetch_array($result_reginfo)){
					$code=$row['credit'];
					$code1=$row['debit'];
					if ($i==0){
					$insert_user=mysql_query("
					INSERT INTO `account` (
							`c_code` ,
							`c_cur` ,
							`c_credit` ,
							`c_debit` ,
							`a_id` ,
							`a_notran` ,
							`a_date`,
							`c_des`,
							`issave`,
							`branch`
							)
							VALUES (
						'$code', '$mycur', '$amt', '0', null, '', '$repay_date','$lid','1','$get_br');
					") or die(mysql_error);
						$i++;
					}
					else{
						$insert_user=mysql_query("
					INSERT INTO `account` (
							`c_code` ,
							`c_cur` ,
							`c_credit` ,
							`c_debit` ,
							`a_id` ,
							`a_notran` ,
							`a_date`,
							`c_des`,
							`issave`,
							`branch`
							)
							VALUES (
						'$code1', '$mycur', '0', '$amt', null, '', '$repay_date','$lid','1','$get_br');
					") or die(mysql_error);
					}
			}*/
			
			if($isfix==0){
			//Saving
				$insert_saving="insert into witdraw(ld,cid,amount,date,user,cur,status) values('$lid','$cid','$amt','$repay_date','$user','$mycur','n')";
				mysql_query($insert_saving) or die (mysql_error());
			}
			else{
				
				if($amt>$interest){
					echo "<script>alert('This saving is fix deposit, so amount can not bigger than interest, but you can change from fix deposit to normal just click withdrawal early.')</script>";
					echo"<script>window.location.href='index.php?pages=witdraw_form';</script>";
					exit;	
				}	
			}
				//insert invoice
			   // $amount = $_POST['g_amt'];

					/* ('id' ,'reg_id' ,'lc' ,'paid_date' ,'sch_date' ,'invioce_no','prn_paid' ,'int_paid' ,'pn_paid','int_dis','payoff_pnpaid','total' ,'cashier' ,'pay_type','pay_status','reciev_at','max_id','res_co','cur')
							,'$myreg_id', '$lid', '$repay_date', '$sch_date', '$max','$prn_pain_total','$int_pain_total','$pn_pain_total','$int_dis_total','0', '$amount', '$user', 'gm', '$get_br', '$max', '$myco', '$mycur');*/
			/*	$invoice_exc="INSERT INTO invoice(id,reg_id,lc,paid_date,sch_date,invioce_no,prn_paid,int_paid,pn_paid,int_dis,payoff_pnpaid,total,cashier,pay_type,pay_status,reciev_at,max_id,res_co,cur) VALUES (null,'$myreg_id', '$lid', '$repay_date', '$sch_date', '$max','$prn_pain_total','$int_pain_total','$penalty','$int_dis_total','0', '$amount', '$user','$dis_type', 'gm', '$get_br', '$max', '$myco', '$mycur');";
					
					$invoice_sms = mysql_query($invoice_exc) or die(mysql_error());
	
			//---------------end update schedule--------------------------
			/*echo"
				<script> 
					alert('$myreg_id');
				</script>";*/
			echo"<script>window.location.href='index.php?pages=witdraw_form';</script>";
		}//end isset schedule
		
	//------------end repay transaction---------------// 
	?>
<!-- start content-outer -->
<h3 class="tit">Easy Witdraw Form :</h3>
		<!-- start id-form -->
        <form name="ind_loan" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%" 
        onclick="document.getElementById('divSuggestions').style.visibility='hidden'" class="nostyle">
         <tr>
		<th valign="top">LID :</th>
		<td>	
            <input type="hidden" name="reg_id" value="<?php echo $reg_id; ?>" />
            <input type="hidden" name="co" value="<?php echo $co; ?>" />
             <input type="hidden" name="cur" value="<?php echo $l_currency; ?>" />
            <input type="text" class="input-text" name="lid" id="lid" autocomplete="off" 
            onKeyPress="return handleEnter(this, event);" value="<?php echo $lid; ?>" onKeyUp="doSuggestionBox(this.value);"/>
            <input type="submit" name="display" value="+"/>
		</td>
        <th>&nbsp;</th>
        <td>&nbsp;</td>
        </tr>
        <tr>
		<th valign="top">&nbsp;</th>
		<td>	
				<div class="suggestions" id="divSuggestions" style="visibility: hidden; width: 13%;
						 	margin-top:-4px; background-color: #FFFFFF;float:right; color: #666666; 
                            height: 100px; padding-left: 5px;position:absolute;">
                </div>
		</td>
  <td></td>
		</tr> 
        <tr>
		<th valign="top">Interest</th>
		<td>	
			         <input type="text" class="input-text" name="interest" id="interest" value="<?php echo $interest; ?>" 
            readonly="readonly" onkeypress="return handleEnter(this, event);" autocomplete="off"/>	
		</td>
 		 	<td>

                <input type="hidden" class="input-text" name="penalty" id="penalty" value="<?php echo $penalty; ?>" 
            readonly="readonly" onkeypress="return handleEnter(this, event);" autocomplete="off"/>
            </td>
		</tr> 

		<tr>
			<th valign="top">Customer Name :</th>
			<td><input type="text" class="input-text" name="cust_name" id="cust_name" value="<?php echo $kh_borrower; ?>" 
            onblur="doDate(this,'em_Date');" readonly="readonly" onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
            <th valign="top">Withdrawal Date :</th>
			<td>
            <input type="text" class="input-text" name="repay_date" id="repay_date" 
            value="<?php if(!empty($mydate)){
												echo $mydate;
											}
											 else{
											 	echo date('d-m-Y'); 
											 } ?>" 
            onblur="doDate(this,'em_Date');" autocomplete="off" readonly="readonly"/></td>
		</tr>
		<tr>
			<th valign="top">Current Amount :</th>
			<td>
            <input type="text" class="input-text" name="due_amt" id="due_amt" value="<?php echo $due_amt; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Amount :</th>
			<td>
            <input type="text" class="input-text" name="amt" id="amt" value="<?php echo $myodprn_tt; ?>" autocomplete="off"/>
            </td>
		</tr>
         
         <tr>
            <th valign="top">Currency :</th>
			<td>
            <input type="text" class="input-text" name="cur" id="cur" value="<?php echo $l_currency; ?>" readonly="readonly"/>
            </td>
		</tr>
        
         <tr>	
        	<td colspan="2">&nbsp;
            	
            </td>
        </tr>
        
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="withdrawal" class="form-submit" name="withdrawal" id="withdrawal" 
            onclick="return confirm('Are you sure want to do repayment for <?php echo $kh_borrower; ?> ?');"/>
                <input type="reset" value="reset" class="form-reset"  />
                <input type="submit" value="withdrawal early" class="form-submit" name="withdrawal_bt" id="withdrawal_bt" 
            onclick="return confirm('Are you sure, do you want to withdrawal early?');"/>
            </td>
            <td>
           </td>
	 </tr>
	</table>
    