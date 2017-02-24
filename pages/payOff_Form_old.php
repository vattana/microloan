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
				if (parseInt(input)<=parseInt(document.getElementById("total_amt_hiden").value)){
					document.getElementById("total_amt").value = (document.getElementById("total_amt_hiden").value-input).toFixed(2);
					document.getElementById("remain").value = 0; 

				}
			    else if (parseInt(input)>parseInt(document.getElementById("total_amt_hiden").value)){
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
					document.getElementById("to_pen").value = input1;
					document.getElementById("repay_penalty_remain").value = 0; 
					return;
				}
				if (parseInt(input)<=parseInt(document.getElementById("repay_penalty_hiden").value)){
					document.getElementById("to_pen").value = (document.getElementById("repay_penalty_hiden").value-input).toFixed(2);
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
		$query = "SELECT * FROM loan_process WHERE dis='1' ORDER BY max_id ASC";
			$result = mysql_query($query);
			$counter = 0;
			echo("<script type='text/javascript'>");
			echo("this.nameArray = new Array();");
			if($result) {
				while($row = mysql_fetch_array($result)) {
					echo("this.nameArray[" . $counter . "] = '" . trim($row['ld']) . " ';");
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
			$display_info="SELECT * FROM loan_process WHERE ld='$lid' ORDER BY id ASC";
			$result_info=mysql_query($display_info) or die (mysql_error());
				while($row=mysql_fetch_array($result_info)){
						$reg_id = $row['regis_id'];
						$cid = $row['cid'];
					}
			//display approval info
			$Num_of_rep=0;
			$display_appinfo="SELECT * FROM customer_app WHERE cid='$cid'";
			$result_appinfo=mysql_query($display_appinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_appinfo)){
						$rate = $row['approval_rate'];
						$Num_of_rep=$row['number_of_repay'];
					}
			//-----start show currency
			$display_reginfo="SELECT * FROM register WHERE id='$reg_id'";
			$result_reginfo=mysql_query($display_reginfo) or die (mysql_error());
			$check_dis=mysql_num_rows($result_reginfo);
				while($row=mysql_fetch_array($result_reginfo)){
						$kh_borrower=$row['kh_borrower'];
						$l_currency=$row['cur'];
						$dis=$row['dis'];
					}
				//////end register-------------//
				/////Get today penalty
				$minInstall="SELECT MIN(repayment_date) as min_no FROM schedule WHERE ld='$lid' AND rp='0'";
				$result_mininstall=mysql_query($minInstall) or die (mysql_error());
					while($row=mysql_fetch_array($result_mininstall)){
							$min_no=$row['min_no'];
						}
				$month=date('Y-m-d',strtotime($repay_date));	
				$cur_date_sql ="SELECT repayment_date FROM schedule where ld='$lid' and rp='0' order by repayment_date limit 1;";
				$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
								while($row=mysql_fetch_array($result_cur)){
									$pre_date=$row['repayment_date'];
									
									$days=dateDiff($pre_date,$month);	
								}
								
	
				$Num_of_rep1=0;
				
				if ($Num_of_rep==7 || $Num_of_rep ==14){
					$Num_of_rep1=7;
				}
				else
				{
					$Num_of_rep1=30;	
				}
				$due_pn=0;
								$round_khinfo="SELECT setting FROM loan_config WHERE property='rounding'";
			$result_khrinfo=mysql_query($round_khinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_khrinfo)){
						$round_khr=$row['setting'];
					}
					
				$query_pn=" SELECT (interest-int_paid) as interest,remain_amt,total,repayment_date FROM schedule where ld='$lid' AND dis='1' AND rp='0' and repayment_date < '$dis_repay_date' order by repayment_date desc";
						$result_pn=mysql_query($query_pn);
						echo mysql_error();
						while($row = mysql_fetch_array($result_pn))
								{
									$sch_pn=$row['total'];
									$date_pn=date('Y-m-d',strtotime($row['repayment_date']));
									$remain = $row['remain_amt'];
									$days_pn=intval(dateDiff($date_pn,$dis_repay_date));

									if($days_pn>=4){
										if ($remain==0){
												if ($l_currency=='KHR'){
												$due_pn=roundkhr(round(($sch_pn*$rate/100)*$days_pn*2/$Num_of_rep1,2),$round_khr);
												
											}
											else{
												$due_pn=formatmoney(round(($sch_pn*$rate/100)*$days_pn*2/$Num_of_rep1,2),true);
											}
											
										}
										else
										{
											if ($l_currency=='KHR'){
												$due_pn=roundkhr(round(($remain*$rate/100)*$days_pn*2/$Num_of_rep1,2),$round_khr);
											}
											else{
												$due_pn=formatmoney(round(($remain*$rate/100)*$days_pn*2/$Num_of_rep1,2),true);
											}
											
										}			
									}
									else{
										$due_pn=0.00;
										}
								}
				
				/*echo "<script>alert('$due_pn');</script>";*/
				/////end today penalty
				//find min installment
				$minInstall="SELECT MIN(repayment_date) as min_no FROM schedule WHERE ld='$lid' AND rp='0'";
				$result_mininstall=mysql_query($minInstall) or die (mysql_error());
					while($row=mysql_fetch_array($result_mininstall)){
							$min_no=$row['min_no'];
						}
				/*echo"<script>alert('$min_no');</script>";*/
				

				//show due information
				
				$sch_info="SELECT * FROM schedule WHERE ld='$lid' and rp='0' and dis='1' Order By repayment_date asc";
				$result_dueinfo=mysql_query($sch_info) or die (mysql_error());
				//echo $sch_info;
				/*echo"<script>alert('$dis_repay_date');</script>";*/
				while($row=mysql_fetch_array($result_dueinfo)){
						$due_date = date('d-m-Y',strtotime($row['repayment_date']));
						$due_prn=formatMoney($row['principal'],true);
						$due_amt=formatMoney($row['total'],true);
						$due_int=formatMoney($row['interest'],true);
						
						$ori_due_prn=$row['principal'];
						$ori_due_amt=$row['total'];
						$ori_due_int=$row['interest'];
						$co=$row['response_co'];
						break;
					}
					
				// calculate interest discount
						$days_dis=dateDiff(date('Y-m-d',strtotime($repay_date)),date('Y-m-d',strtotime($due_date)));
						$dis_info="SELECT * FROM int_dis";
						$result_disinfo=mysql_query($dis_info) or die (mysql_error());
						while($row=mysql_fetch_array($result_disinfo)){
							if ($days_dis<=$row['T']){
								$int_dis=$row['C_DIS'];
								if ($int_dis==0){
									$int_dis==0;
									break;
								}
										if ($l_currency=='KHR'){
												$int_dis=roundkhr((($due_int)*$int_dis)/100,$round_khr);
											}
											else{
												$int_dis=round((($due_int)*$int_dis)/100,2);
											}
								
								break;
							}
							
						}
				// end
				//Select PO_Pel from loan config
				$Po_Pel=mysql_query("SELECT setting  FROM loan_config WHERE  property='POCharge'");
				$Po_Pel_tt=mysql_fetch_array($Po_Pel);
				
				if ($l_currency=='KHR'){
												$Po_setting=formatMoney($Po_Pel_tt['setting'],true);
											}
											else{
												$Po_setting=formatMoney(round($Po_Pel_tt['setting'],2),true);
											}
			
				///Over due penalty 
				$pn_int=mysql_query("SELECT SUM(penalty) as pn_tt FROM schedule WHERE ld='$lid'");
				$pn_tt=mysql_fetch_array($pn_int);
				if ($l_currency=='KHR'){
												$overdue_pn=formatMoney(roundkhr($pn_tt['pn_tt'],$round_khr),true);
											}
											else{
												$overdue_pn=formatMoney(round($pn_tt['pn_tt'],2),true);
											}
				
				//PO_Penalty
				

				$po_pn1_First=0;
				
				if ($month > $pre_date){
				$sum_OP_P_First=mysql_query("SELECT (((balance*$rate)/100)/$Num_of_rep1)*$days as PO_P FROM schedule WHERE  ld='$lid' AND rp='0' order by repayment_date limit 1");
				$Sum_OP_tt_First=mysql_fetch_array($sum_OP_P_First);
				if ($l_currency=='KHR'){
												$po_pn1_First=roundkhr($Sum_OP_tt_First['PO_P'],$round_khr);
											}
											else{
												$po_pn1_First= formatMoney(round($Sum_OP_tt_First['PO_P'],2),true);
											}
				 //First Interest
				}
				
				//On time
					if ($due_date==$repay_date){
						$sum_int=mysql_query("SELECT interest-int_paid as int_tt FROM schedule WHERE ld='$lid' AND rp='0' limit 1");
						
						
						while($row=mysql_fetch_array($sum_int))
						{	
							$int_first=$row['int_tt'];
							$int_last=$int_first;
							break;
						}
					
					}
				//End
				//Early Time
					if ($due_date<$repay_date){
						$sum_int=mysql_query("SELECT interest-int_paid as int_tt FROM schedule WHERE ld='$lid' AND rp='0' order by repayment_date limit 2");
						$d=0;
						while($row=mysql_fetch_array($sum_int))
						{	
							
							$int_first=$row['int_tt'];
							$int_last=$int_last+$int_first;
							if ($d==1){
								break;
							}
							$d=+1;
						}
						$po_pn1_First=0;
		
						
					}
				//End
				
				$sum_OP_P=mysql_query("SELECT ((SUM(interest-int_paid)-$int_last-$po_pn1_First)*$Po_setting)/100 as PO_P FROM schedule WHERE  ld='$lid' AND rp='0'");
				$Sum_OP_tt=mysql_fetch_array($sum_OP_P);
				
						if ($l_currency=='KHR'){
												$po_pn1=roundkhr($Sum_OP_tt['PO_P'],$round_khr);
											}
											else{
												$po_pn1= formatMoney(round($Sum_OP_tt['PO_P'],2),true);
											}
											
				//$po_pn1_First=round(($po_pn1_First*$Po_setting)/100,2);
				
				$l=0;
				$count_int_P_Last=mysql_query("SELECT no_install FROM schedule WHERE  ld='$lid' AND rp='0' and repayment_date<'$dis_repay_date' order by repayment_date ");
				$count_row=mysql_num_rows($count_int_P_Last);
				while($row=mysql_fetch_array($count_int_P_Last))
				{	
					$l=$row['no_install'];
					break;
				}
				
				$m=0;
				$total_late=0;
				$total_late_last=0;
				$due_late=0;
				$remain_late=0;
				$due_pn_late=0;
				
				if ($count_row>1){
					$po_pn1_First=0;
					

					while($m<=$count_row)
					{
						$sql_date=mysql_query("SELECT repayment_date FROM schedule WHERE  ld='$lid' AND rp='0' and no_install='$l'");
						//$sql_date1=mysql_fetch_array($sql_date);
						while($row=mysql_fetch_array($sql_date))
						{	
							$sql_date1=$row['repayment_date'];
							break;
						}
						$days_late=dateDiff($sql_date1,$month);
				
						if ($sql_date1<$month){
							
							$sum_tt=mysql_query("SELECT (interest-int_paid) as interest,remain_amt,total FROM schedule WHERE  ld='$lid' AND rp='0' and no_install='$l' order by repayment_date");
							while($row=mysql_fetch_array($sum_tt))
							{
								$total_late= $row['total'];
								$remain_late=$row['remain_amt'];
								if($days_late>=4){
									if ($remain_late==0)
									{
												if ($l_currency=='KHR'){
												$due_pn_late=roundkhr(round(($total_late*$rate/100)*$days_late*2/$Num_of_rep1,2),$round_khr);
											}
											else{
												$due_pn_late=round(($total_late*$rate/100)*$days_late*2/$Num_of_rep1,2);
											}
										
									}
									else
									{
											if ($l_currency=='KHR'){
												$due_pn_late=roundkhr(round(($remain_late*$rate/100)*$days_late*2/$Num_of_rep1,2),$round_khr);
											}
											else{
												$due_pn_late=round(($remain_late*$rate/100)*$days_late*2/$Num_of_rep1,2);
											}
										
									
									}
								}	
								else{
									$due_pn_late=0.00;
								}
								$int_late=$row['interest'];
								
								if ($l_currency=='KHR'){
												$total_late_last=roundkhr(trim(str_replace(",","",$total_late_last))+trim(str_replace(",","",$int_late)),$round_khr);
												$due_late=roundkhr(trim(str_replace(",","",$due_late))+trim(str_replace(",","",$due_pn_late)),$round_khr);
											}
											else{
												$total_late_last = round(trim(str_replace(",","",$total_late_last))+trim(str_replace(",","",$int_late)),2);
												$due_late=round(trim(str_replace(",","",$due_late))+trim(str_replace(",","",$due_pn_late)),2);
											}
								
								$due_pn=$due_pn_late;

								

							}
						}
						else{
							$r=$l-1;
							$sql_date=mysql_query("SELECT repayment_date FROM schedule WHERE  ld='$lid' AND rp='0' and no_install='$r'");
						//$sql_date1=mysql_fetch_array($sql_date);
						while($row=mysql_fetch_array($sql_date))
						{	
							$sql_date1=$row['repayment_date'];
							break;
						}
						$days_late=dateDiff($sql_date1,$month);

							$sum_OP_P_First=mysql_query("SELECT (((balance*$rate)/100)/$Num_of_rep1)*$days_late as PO_P FROM schedule WHERE  ld='$lid' AND rp='0' and no_install='$r' order by repayment_date desc limit 1");
							$Sum_OP_tt_First=mysql_fetch_array($sum_OP_P_First);
							if ($l_currency=='KHR'){
												$po_pn1_First=roundkhr($Sum_OP_tt_First['PO_P'],$round_khr);
											}
											else{
												$po_pn1_First= formatMoney(round($Sum_OP_tt_First['PO_P'],2),true);
											}
							

						}
						$m++;
						$l++;				

					}				
					$r=$l-1;
					$sum_OP_P=mysql_query("SELECT ((SUM(interest)-$po_pn1_First)*$Po_setting)/100 as PO_P FROM schedule WHERE  ld='$lid' AND rp='0' and no_install>=$r");
					$Sum_OP_tt=mysql_fetch_array($sum_OP_P);
					if ($l_currency=='KHR'){
												$po_pn1=formatMoney(roundkhr($Sum_OP_tt['PO_P'],$round_khr),true);
												$po_pn1_First=roundkhr($po_pn1_First,$round_khr);
												
											}
											else{
												$po_pn1= formatMoney(round($Sum_OP_tt['PO_P'],2),true);
												$po_pn1_First=round(($po_pn1_First),2);
											}
					
					$int_tt=$total_late_last;
					
				}
				//$po_pn=$po_pn-$;
				
				///Get paid penalty 
				$pn_paid=mysql_query("SELECT SUM(norpen_paid) as norpn_paid FROM schedule WHERE ld='$lid'");
				$pn_p=mysql_fetch_array($pn_paid);
				
					if ($l_currency=='KHR'){
												$paid_pn=roundkhr($pn_p['norpn_paid'],$round_khr);
												$remain_pn=roundkhr(trim(str_replace(",","",$overdue_pn))-trim(str_replace(",","",$paid_pn)),$round_khr);
											}
											else{
												$paid_pn=round($pn_p['norpn_paid'],2);
												$remain_pn=round(trim(str_replace(",","",$overdue_pn))-trim(str_replace(",","",$paid_pn)),2);
											}
		
			
				//total penalty
				if ($due_late==0)
				{
					$due_late=$due_pn;	
				}
					if ($l_currency=='KHR'){
												$total_pn=formatMoney(roundkhr(trim(str_replace(",","",$due_late))+trim(str_replace(",","",$remain_pn)),$round_khr),true);
											}
											else{
												$total_pn=formatMoney(round(trim(str_replace(",","",$due_late))+trim(str_replace(",","",$remain_pn)),2),true);
											}
				
				
				/*echo"<script>alert('days:$days_pn,due_pn:$due_pn,remain_pn:$remain_pn,total_pn:$total_pn,OD:$overdue_pn');</script>";*/
				///show over due information
				
				
				$sum_prn=mysql_query("SELECT SUM(principal-prn_paid) as prn_tt FROM schedule WHERE ld='$lid' AND rp='0'");
				$prn_tt=mysql_fetch_array($sum_prn);
					if ($l_currency=='KHR'){
												$myodprn_tt=formatMoney(roundkhr($prn_tt['prn_tt']+$int_first,$round_khr),true);
											}
											else{
												$myodprn_tt= formatMoney(round($prn_tt['prn_tt']+$int_first,2),true);
											}
				
				
				/*$sum_int=mysql_query("SELECT (SUM(interest)*$Po_setting)/100 as int_tt FROM schedule WHERE  ld='$lid' AND rp='0'");
				$int_tt=mysql_fetch_array($sum_int);
				$myodint_tt= formatMoney(round($int_tt['int_tt'],2),true);
				*/
					if ($l_currency=='KHR'){
												$myodint_tt=formatMoney(roundkhr($int_tt,$round_khr),true);
											}
											else{
												$myodint_tt= formatMoney(round($int_tt,2),true);
											}
				
				//$total_int=mysql_query("SELECT SUM(total-(prn_paid+int_paid+int_dis)) as total_tt FROM schedule WHERE repayment_date <= '$dis_repay_date' AND ld='$lid' AND rp='0'");
				//$toal_tt=mysql_fetch_array($total_int);
					//Total Penalty
					if ($l_currency=='KHR'){
												$T_P=formatMoney(roundkhr(trim(str_replace(",","",$total_pn)) + trim(str_replace(",","",$po_pn1)),$round_khr),true);
											}
											else{
												$T_P = formatMoney(trim(str_replace(",","",$total_pn)) + trim(str_replace(",","",$po_pn1)),true);

											}
												
					if ($l_currency=='KHR'){
												$myodtotal_tt=formatMoney(roundkhr(trim(str_replace(",","",$myodprn_tt))+trim(str_replace(",","",$T_P))+trim(str_replace(",","",$total_late_last))+
				trim(str_replace(",","",$po_pn1_First)),$round_khr),true);
											}
											else{
				$myodtotal_tt=formatMoney(round(trim(str_replace(",","",$myodprn_tt))+trim(str_replace(",","",$T_P))+trim(str_replace(",","",$total_late_last))+
				trim(str_replace(",","",$po_pn1_First)),2),true);

											}

				
				/////////////
				if($min_no==''){
					echo"<script>alert('There is no this record in System! Please Check again!');</script>";	
					echo"<script>window.location.href='index.php?pages=general_repayForm';</script>";
					exit();
					}
				///check dis
				if($dis=='0'){
					echo"<script>alert('There Customer is not yet disbursed! Please Check again!');</script>";	
					echo"<script>window.location.href='index.php?pages=general_repayForm';</script>";
					}
			}///isset displaay
			
	//--check ld
	//---end diplay
	//---------start disbursement----------------//
		if(isset($_POST['repayment'])){//start schedule 
		
			$lid = $_POST['lid'];
			$myreg_id=$_POST['reg_id'];
			$prn=$_POST['repay_prn'];
			$int=$_POST['repay_int'];
			$total=$_POST['total_amt'];
			$myco=$_POST['co']; 
			$mycur=$_POST['cur'];
			$int_dis=$_POST['int_dis'];
			$repay_date=date('Y-m-d',strtotime($_POST['repay_date']));
			$sch_date=date('Y-m-d',strtotime($_POST['due_date']));
			$total_pn=$_POST['repay_penalty'];
			$total_pn_all=$total_pn;
		//	$total_pn_org=$_POST['repay_penalty'];
			//myodtotal_tt
			$spit = array(",", "'");
			$my_prn = str_replace($spit, "",$prn);
			$my_int = str_replace($spit, "",$int);
			$my_total =str_replace($spit, "",$total);
			$amount = $_POST['g_amt'];
			$penalty = $_POST['g_pn'];
			$po_int=$_POST['po_pn'];
			$addi_int = $_POST['adInt'];
		
			//
			//--check days--//
		
			//find min installment
				/*$minInstall="SELECT MIN(repayment_date) as min_no FROM schedule WHERE ld='$lid' AND rp='0'";
				$result_mininstall=mysql_query($minInstall) or die (mysql_error());
				
					while($row=mysql_fetch_array($result_mininstall)){
							$min_no=$row['min_no'];
						}	*/
			///--------update schedule------------------
				$normaltotalpenalty =0;
				$Prin = 0;
				$total_from_db= 0;
				$remain_from_db=0;
				$due_remain=0;
				$int_paid=0;
				$prin_pain=0;
				$j=0;
				$balance =0;					
					
				$Po_Pel=mysql_query("SELECT setting  FROM loan_config WHERE  property='POCharge'");
				$Po_Pel_tt=mysql_fetch_array($Po_Pel);
				$Po_setting=formatMoney(round($Po_Pel_tt['setting'],2),true);
				
				$month=date('Y-m-d',strtotime($repay_date));	
				$cur_date_sql ="SELECT repayment_date,balance FROM schedule where ld='$lid' and rp='1' order by repayment_date;";
				$result_cur=mysql_query($cur_date_sql) or die(mysql_error());
								while($row=mysql_fetch_array($result_cur)){
									$pre_date=$row['repayment_date'];
									$balance=$row['balance'];
									$days=dateDiff($pre_date,$month);	
								}
				//display approval info
				$Num_of_rep=0;
				$display_appinfo="SELECT * FROM customer_app WHERE reg_id='$reg_id'";
				$result_appinfo=mysql_query($display_appinfo) or die (mysql_error());
				while($row=mysql_fetch_array($result_appinfo)){
						$rate = $row['approval_rate'];
						$Num_of_rep=$row['number_of_repay'];
					}
					
				$Num_of_rep1=0;
				
				if ($Num_of_rep==7 || $Num_of_rep ==14){
					$Num_of_rep1=7;
				}
				else
				{
					$Num_of_rep1=30;	
				}
				
				//// Pay-OFF Calculation
				$po_pn1_First=0;
				$count_int_P_cou=mysql_query("SELECT no_install FROM schedule WHERE  ld='$lid' AND rp='0' and repayment_date<'$month' order by repayment_date ");
				$count_inst = mysql_num_rows($count_int_P_cou);
				if ($count_inst<=1){
				if ($month > $pre_date){
				$sum_OP_P_First=mysql_query("SELECT (((balance*$rate)/100)/$Num_of_rep1)*$days as PO_P,principal,prn_paid,no_install,interest-int_paid as last_int,interest FROM schedule WHERE  ld='$lid' AND rp='0' order by repayment_date limit 1");
				
				$Sum_OP_tt_First=mysql_fetch_array($sum_OP_P_First);
				$po_pn1_First= round($Sum_OP_tt_First['PO_P'],2);
				$last_int =$Sum_OP_tt_First['last_int'];
				$interest = $Sum_OP_tt_First['interest'];
				$prn_paid = $Sum_OP_tt_First['prn_paid'];
				if($last_int==0){
					$po_pn1_First=$interest;
				}
				else
				{
					if ($addi_int!=0){
						$po_pn1_First =$interest+$addi_int;
						$addi_int=0;
					}
				}
				$prin_1 = formatMoney(round($Sum_OP_tt_First['principal'],2),true);
				$result_mininstall= $Sum_OP_tt_First['no_install'];
					$update_sch="UPDATE schedule SET prn_paid ='$prin_1',int_paid='$po_pn1_First',rp='9',paid_date ='$month' 
									 ,penalty='$total_pn',remain_amt='0',int_dis='',pay_status='', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
										mysql_query($update_sch) or die (mysql_error());
										
										//Insert schedule his
										$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$pre_date','$month','$max','$prin_1-$prn_paid','$po_pn1_First','$normaltotalpenalty',0,'','','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
										$total_pn=0;
										$po_pn1_First=$po_pn1_First-$interest;
										
				 //First Interest
				}
				
				
				$count_install=mysql_query("SELECT no_install,principal FROM schedule WHERE  ld='$lid' AND rp='0' and repayment_date>'$month' order by repayment_date ");
				
				while($row=mysql_fetch_array($count_install)){
					$no_ins=$row['no_install'];
					$prin_1=$row['principal'];
					$sum_OP_P=mysql_query("SELECT ((interest-int_paid-$po_pn1_First)*$Po_setting)/100 as PO_P FROM schedule WHERE  ld='$lid' AND rp='0' and no_install='$no_ins'");
					$Sum_OP_tt=mysql_fetch_array($sum_OP_P);
					$po_pn1= formatMoney(round($Sum_OP_tt['PO_P'],2),true);
					if($addi_int!=0){
						$po_pn1=$addi_int;
						$addi_int=0;											
					}
					
					$update_sch="UPDATE schedule SET prn_paid ='$prin_1',int_paid='$po_pn1',rp='9',paid_date ='$month' 
						,penalty='$total_pn',remain_amt='0',int_dis='',pay_status='', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$no_ins'";
						mysql_query($update_sch) or die (mysql_error());
										
										//Insert schedule his
					$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$pre_date','$month','$max','$prin_1','$po_pn1','$normaltotalpenalty',0,'','','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
										$po_pn1_First=0;
				}
				}
				//Late more installment

				$l=0;
				$count_int_P_Last=mysql_query("SELECT no_install FROM schedule WHERE  ld='$lid' AND rp='0' and repayment_date<'$month' order by repayment_date ");
				$count_row=mysql_num_rows($count_int_P_Last);
				while($row=mysql_fetch_array($count_int_P_Last))
				{	
					$l=$row['no_install'];
					break;
				}
				$update_sch="UPDATE schedule SET rp='0' WHERE ld='$lid' AND no_install>='$l'";
				mysql_query($update_sch) or die (mysql_error());
				$m=0;
				$total_late=0;
				$total_late_last=0;
				$due_late=0;
				$remain_late=0;
				$due_pn_late=0;

				if ($count_row>1){
					$po_pn1_First=0;
					

					while($m<=$count_row)
					{
						$sql_date=mysql_query("SELECT repayment_date FROM schedule WHERE  ld='$lid' AND rp='0' and no_install='$l'");
						//$sql_date1=mysql_fetch_array($sql_date);
						while($row=mysql_fetch_array($sql_date))
						{	
							$sql_date1=$row['repayment_date'];
							break;
						}
						$days_late=dateDiff($sql_date1,$month);
						
						if ($sql_date1<$month){
							
							$sum_tt=mysql_query("SELECT (interest-int_paid) as interest,remain_amt,total,principal FROM schedule WHERE  ld='$lid' AND rp='0' and no_install='$l' order by repayment_date");
							$i=0;
							while($row=mysql_fetch_array($sum_tt))
							{
								
								$prin_1 = $row['principal'];
								$int_late=$row['interest'];
								
								if ($i==0)
								{
									$update_sch="UPDATE schedule SET prn_paid ='$prin_1',int_paid='$int_late',rp='9',paid_date ='$month' 
						,penalty='$total_pn',remain_amt='0',int_dis='',pay_status='', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$l'";
						mysql_query($update_sch) or die (mysql_error());
										
										//Insert schedule his
								$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$pre_date','$month','$max','$prin_1','$int_late','$normaltotalpenalty',0,'','','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
										$po_pn1_First=0;
								}
								else{
							$update_sch="UPDATE schedule SET prn_paid ='$prin_1',int_paid='$int_late',rp='9',paid_date ='$month' 
						,penalty='',remain_amt='0',int_dis='',pay_status='', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$l'";
						mysql_query($update_sch) or die (mysql_error());
										
										//Insert schedule his
								$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$pre_date','$month','$max','$prin_1','$int_late','$normaltotalpenalty',0,'','','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
										$po_pn1_First=0;
								}
								$i=$i+1;
				
							}
						}
						else{
							$r=$l-1;
							$sql_date=mysql_query("SELECT repayment_date FROM schedule WHERE  ld='$lid' and no_install='$r'");
						//$sql_date1=mysql_fetch_array($sql_date);
						while($row=mysql_fetch_array($sql_date))
						{	
							$sql_date1=$row['repayment_date'];
							break;
						}
						$days_late=dateDiff($sql_date1,$month);
						
							$sum_OP_P_First=mysql_query("SELECT (((balance*$rate)/100)/$Num_of_rep1)*$days_late as PO_P,principal,interest FROM schedule WHERE  ld='$lid' and no_install='$r' order by repayment_date desc limit 1");
							$Sum_OP_tt_First=mysql_fetch_array($sum_OP_P_First);
							$po_pn1_First= formatMoney(round($Sum_OP_tt_First['PO_P'],2),true);
							$prin_1= formatMoney(round($Sum_OP_tt_First['principal'],2),true);
							$interadd = round($Sum_OP_tt_First['interest'],2);
							$update_sch="UPDATE schedule SET prn_paid ='$prin_1',int_paid='$po_pn1_First',rp='9',paid_date ='$month' 
						,penalty='',remain_amt='0',int_dis='',pay_status='', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$l'";
						mysql_query($update_sch) or die (mysql_error());
										
							//Insert schedule his
							$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$pre_date','$month','$max','$prin_1','$po_pn1_First','$normaltotalpenalty',0,'','','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
						}
						$m++;
						$l++;				
					}				
					$r=$l-1;
			
					$count_install=mysql_query("SELECT no_install,principal FROM schedule WHERE  ld='$lid' and no_install>=$r");
					while($row=mysql_fetch_array($count_install)){
						$result_mininstall=$row['no_install'];
						
						$sum_OP_P=mysql_query("SELECT (((interest+$interadd)-$po_pn1_First)*$Po_setting)/100 as PO_P,principal FROM schedule WHERE  ld='$lid' and no_install=$l");
						$Sum_OP_tt=mysql_fetch_array($sum_OP_P);
						$po_pn1= formatMoney(round($Sum_OP_tt['PO_P'],2),true);
						$po_pn1_First=round(($po_pn1_First),2);
						$prin_1=round($Sum_OP_tt['principal'],2);
							
						//$int_tt=$total_late_last;
						$update_sch="UPDATE schedule SET prn_paid ='$prin_1',int_paid='$po_pn1',rp='9',paid_date ='$month' 
						,penalty='',remain_amt='0',int_dis='',pay_status='', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$l'";
						mysql_query($update_sch) or die (mysql_error());
										$l=$l+1;
							//Insert schedule his
						$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$pre_date','$month','$max','$prin_1','$po_pn1','$normaltotalpenalty',0,'','','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
						$po_pn1_First=0;
						$interadd=0;
					}

					
				}
				/////// End Process
				
				/*while ($amount>0){
					//Get some data for calculator
					$total_from_db = "Select total,(principal-prn_paid) as principal,(interest-int_paid) as interest,int_paid,prn_paid,no_install,remain_amt,repayment_date, int_dis,pay_status,balance  from schedule where ld='$lid' and rp='0' order by repayment_date asc";
					$total_from = mysql_query($total_from_db) or die(mysql_error());
					
					while($row=mysql_fetch_array($total_from)){
								$total_from=$row['total'];
								$int_from=$row['interest'];
								$prin_from=$row['principal'];
								$result_mininstall=$row['no_install'];
								$remain_from_db=$row['remain_amt'];
								$int_paid=$row['int_paid'];
								$prin_pain=$row['prn_paid'];
								$repay_date_from = $row['repayment_date'];
								$int_dis = $row['int_dis'];
								$dis_type=$row['pay_status'];
								$bal = $row['balance'];
								break;
						}
						// End
						$amount_bal=$amount-$total_from;
						$j+=1;
						$prin_end=$prin_from+$prin_pain;	
						if($month>$pre_date){
							if ($j==1){ //have penalty
								$int_end= round(((($balance*$rate)/100)/$Num_of_rep1)*$days,2);
										echo "<script>alert('$Num_of_rep1,$rate,$days,$month,$pre_date,$int_end');</script>";
										$update_sch="UPDATE schedule SET prn_paid ='$prin_end',int_paid='$int_end',rp='1',paid_date ='$repay_date' 
									 ,penalty='$total_pn',remain_amt='0',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
										mysql_query($update_sch) or die (mysql_error());
										
										//Insert schedule his
										$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_end','$int_end','$normaltotalpenalty',0,'$int_dis','$dis_type','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
										
								}
								else{// Non penalty
									
									$int_end= round((($int_from)*$Po_setting)/100,2);
	
									$update_sch="UPDATE schedule SET prn_paid ='$prin_end',int_paid='$int_end',rp='1',paid_date ='$repay_date' 
									 ,remain_amt='0',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
										mysql_query($update_sch) or die (mysql_error());
										
											//Insert schedule his
										$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_end','$int_end','0',0,'$int_dis','$dis_type','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
								}
							}
							else{
									$int_end= round((($int_from)*$Po_setting)/100,2);
								

									$update_sch="UPDATE schedule SET prn_paid ='$prin_end',int_paid='$int_end',rp='1',paid_date ='$repay_date' 
									 ,remain_amt='0',int_dis='$int_dis',pay_status='$dis_type', pay_type = 'po',pay_at='$get_br',recieve_by='$user' WHERE ld='$lid' AND no_install='$result_mininstall'";
										mysql_query($update_sch) or die (mysql_error());
										
											//Insert schedule his
										$insert_sch="Insert into schedule_hist(id,cid,ld,due_date,paid_date,invoice_no,pri_paid,int_paid,pn_paid,payoff_pnpaid,int_dis_paid,pay_status,pay_type,pay_at,recieve_by) values (null,'$cid','$lid','$repay_date_from','$repay_date','$max','$prin_end','$int_end','0',0,'$int_dis','$dis_type','po','$get_br','$user')";
										mysql_query($insert_sch) or die (mysql_error());
								}
							if ($remain_from_db>0){
								$amount=$amount-$remain_from_db;
							}
							else
							{
								$amount=round($amount-($int_end+$prin_end)+$int_dis,2);
							}
							
							
							//Total prn,int,pn,int_dis
							$prn_pain_total = $prn_pain_total + $prin_end;
							$int_pain_total = $int_pain_total + $int_end;
							$int_dis_total = $int_dis_total + $int_dis;
							//$pn_pain_total = $pn_pain_total + $total_pn;
							$prin_from=0;
							$int_dis=0;
							$int_from=0;
							//$total_pn=0;
						
					}*/
				
				$invoice_exc="INSERT INTO invoice(id,reg_id,lc,paid_date,sch_date,invioce_no,prn_paid,int_paid,pn_paid,int_dis,payoff_pnpaid,total,cashier,pay_type,pay_status,reciev_at,max_id,res_co,cur) VALUES (null,'$myreg_id', '$lid', '$repay_date', '$sch_date', '$max','$prn','$po_int','$total_pn_all','0','0', '$total', '$user','$dis_type', 'po', '$get_br', '$max', '$myco', '$mycur');";
					
					$invoice_sms = mysql_query($invoice_exc) or die(mysql_error());
					
					$loan_process_exc="update loan_process set status='9' where ld=$lid";
					///
					$mycur=$_POST['cur'];
					$mystatus="PO";
					echo"
					<script> 
						var print =window.open('','print','status=1,width=1100,height=700,scrollbars=yes,menubar=yes,addressbar=no,resizable=no');
						print.location.href='pages/transactionSlip.php?lid=$lid&inNo=$max&t=rp&cur=$mycur&mystatus=$mystatus';
					</script>";
					
					echo "<script>alert('Repayment Successful,This is Invoice No : $max');</script>";
					////////
					$loan_process_sms = mysql_query($loan_process_exc) or die(mysql_error());
			echo"<script>window.location.href='index.php?pages=payOff_Form';</script>";
		}//end isset schedule
		
	//------------end repay transaction---------------// 
	?>
<!-- start content-outer -->
<h3 class="tit">Easy Pay Off Form :</h3>

		<!-- start id-form -->
        <form name="ind_loanpo" method="post" enctype="multipart/form-data">
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
						 	margin-top:-24px; background-color: #FFFFFF;float:right; color: #666666; 
                            height: 100px; padding-left: 5px;position:absolute;">
                </div>
		</td>
			<th>&nbsp;</th>
			<td>
            <a href="pages/schedule.php?r_id=<?php echo $reg_id;?>" target="_blank" title="ទៅកាន់តារាងបង់ប្រាក់">Goto Schedule</a>
            </td>
		</tr> 
		<tr>
			<th valign="top">Due Date :</th>
			<td>
            <input type="text" class="input-text" name="due_date" id="due_date" value="<?php echo $due_date; ?>" autocomplete="off"
             readonly="readonly"/></td>
            <th valign="top">Repay Date :</th>
			<td>
            <input type="text" class="input-text" name="repay_date" id="repay_date" 
            value="<?php if(!empty($mydate)){
												echo $mydate;
											}
											 else{
											 	echo date('d-m-Y'); 
											 } ?>" 
            onblur="doDate(this,'em_Date');" autocomplete="off"/></td>
		</tr>
		<tr>
			<th valign="top">Customer Name :</th>
			<td><input type="text" class="input-text" name="cust_name" id="cust_name" value="<?php echo $kh_borrower; ?>" 
            onblur="doDate(this,'em_Date');" onkeypress="return handleEnter(this, event);" autocomplete="off"/></td>
            <th valign="top">Total Amount :</th>
			<td><input type="text" class="input-text" name="total_amt" id="total_amt" value="<?php echo $myodtotal_tt; ?>" autocomplete="off"/></td>
            <td><input type="hidden" class="input-text" name="total_amt_hiden" id="total_amt_hiden" value="<?php echo $myodtotal_tt; ?>" autocomplete="off"/></td>
		</tr>
		<tr>
			<th valign="top">Due Amount :</th>
			<td>
            <input type="text" class="input-text" name="due_amt" id="due_amt" value="<?php echo $due_amt; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Total Principal :</th>
			<td>
            <input type="text" class="input-text" name="repay_prn" id="repay_prn" value="<?php echo $myodprn_tt; ?>" autocomplete="off"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Due Principal :</th>
			<td>
            <input type="text" class="input-text" name="due_prn" id="due_prn" value="<?php echo $due_prn; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Total Interest:</th>
			<td>
            <input type="text" class="input-text" name="repay_int" id="repay_int" autocomplete="off" value="<?php echo $myodint_tt; ?>"/>
            </td>
		</tr>
        <tr>
			<th valign="top">Due Interest :</th>
			<td>
            <input type="text" class="input-text" name="due_int" id="due_int" value="<?php echo $due_int; ?>" readonly="readonly"/>
            </td>
            <th valign="top">Total Late Penalty :</th>
		<td>	
		<input type="text" class="input-text" name="repay_penalty" id="repay_penalty" autocomplete="off" value="<?php echo $total_pn; ?>"/>
        <input type="hidden" class="input-text" name="repay_penalty_hiden" id="repay_penalty_hiden" autocomplete="off" value="<?php echo $T_P; ?>"/>
        <input type="hidden" class="input-text" name="repay_penalty_remain" id="repay_penalty_remain" autocomplete="off" value="<?php echo "0.00"; ?>"/>
        <input type="hidden" class="input-text" name="po_late_total" id="po_late_total" autocomplete="off" value="<?php echo $total_late_last; ?>"/>
		</td>
		</tr>
         <tr>
         	<th valign="top">Late Due Penalty :</th>
			<td>
            <input type="text" class="input-text" name="due_pn" id="due_pn" value="<?php echo formatmoney(roundkhr($due_pn,$set),true); ?>" readonly="readonly"/> 
            </td>
            <th valign="top">Addional Int :</th>
			<td>
            <input type="text" class="input-text" name="adInt" id="adInt" value="<?php echo formatmoney(roundkhr($po_pn1_First,$set),true); ?>" readonly="readonly"/>
            </td>
			
		</tr>
         <tr>
			<th valign="top">PayOff Penalty :</th>
			<td>
            <input type="text" class="input-text" name="po_pn" id="po_pn" value="<?php 
					if ($l_currency=='KHR'){
						echo formatmoney(roundkhr($po_pn1,$set),true); 
					}
					else{
						echo formatmoney(round($po_pn1,2),true); 
					}
					
				
				?>" readonly="readonly"/>
            </td>
             <th valign="top">Total Penaly :</th>
			<td>
            <input type="text" class="input-text" name="to_pen" id="to_pen" readonly="readonly" value="<?php echo $T_P; ?>" />
            </td>
        
		</tr>
        
         <tr>	
        	<td>&nbsp;
            	 	
            </td>
            <td>
            	<h3><u>Repayment Area:</u></h3> 
            </td>
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
			<th valign="top">Amount :</th>
			<td><input type="text" class="input-text" name="g_amt" id="g_amt" value="<?php echo $myodtotal_tt; ?>" onkeyup="doTotalAmount(this.value)" 
            onkeypress="return isNumberKey(event);" autocomplete="off" readonly="readonly"/></td>
            <th valign="top"></th>
			<td>
            <input type="text" class="input-text" name="g_pn" id="g_pn" value="<?php echo '00'; ?>" onkeyup="doTotalPenalty(this.value)" autocomplete="off" hidden="true"/>
            </td>
		</tr>
       
		<tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="submit" value="Pay Off" class="form-submit" name="repayment" id="repayment" 
            onclick="return confirm('Are you sure want to do repayment for <?php echo $kh_borrower; ?> ?');"/>
                <input type="reset" value="reset" class="form-reset"  />

            </td>
            <td>
           </td>
	 </tr>
	</table>
    </form>
	<!-- end id-form  -->