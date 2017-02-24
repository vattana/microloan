<?php
	include("pages/module.php");
	$code=$_POST['quick_search'];
	$chk=$_POST['chk'];
		///check Loan
		if(!empty($code) && ($chk=='loan')){
			echo"<h3 class='tit'>Loan Information:</h3>";
			echo'
			<table width="100%" cellpadding="0" cellspacing="0" height="auto" >
							<thead>
							<tr align="center" height="28" style="background:#0066FF; color:#FFF">
                                <td><b>LD</b></td>
								<td><b>CID</b></td>
                                <td><b>Register Date</b></td>
                                <td><b>Approval Date</b></td>
                                <td><b>អ្នកខ្ចី</b></td>
                                <td><b>Borrower</b></td>
                                <td><b>Loan</b></td>
                                <td><b>Rate</b></td>
                                <td><b>Period</b></td>
								<td><b>Currency</b></td>
                                <td><b>Entry By</b></td>
                                <td><b>At</b></td>
							</tr>
                           </thead>		
						   ';
			///
				$sql = "SELECT * FROM `loan_process` WHERE ld='$code' AND dis='0' ORDER BY ld ASC limit 0,1;";
				$result = mysql_query($sql) or die(mysql_error());
				while($row=mysql_fetch_array($result))
					{
						$regis_id=$row['regis_id'];
						$lid=$row['ld'];
						$cid=$row['cid'];
						$cur=$row['cur'];
						$br=$row['loan_at'];
						//echo $currency_type;
						$regDate=date('d-m-Y',strtotime($row['reg_date']));
						$myregDate=date('Y-m-d',strtotime($row['reg_date']));
						$approvalDate=date('d-m-Y',strtotime($row['app_date']));
						$myapprovalDate=date('Y-m-d',strtotime($row['app_date']));
						$postBy=$row['post_by'];
						break;
				}// end while
				///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
						////
				///get from register
				$display_info="SELECT * FROM register WHERE id='$regis_id'";
				$result_info=mysql_query($display_info) or die (mysql_error());
				
				while($row=mysql_fetch_array($result_info)){
						$kh_borrower=$row['kh_borrower'];
						$borrower=$row['borrower'];
						break;
				}
				///get from cusApp
				$display_app="SELECT * FROM customer_app WHERE cid='$cid' AND register_date='$myregDate' AND approval_date='$myapprovalDate' order by cid";
				$result_app=mysql_query($display_app) or die (mysql_error());
				
				while($row=mysql_fetch_array($result_app)){
						$loan=formatMoney($row['approval_amt'],true);
						$rate=$row['approval_rate'];
						$term=$row['approval_period'];
						break;
				}
				echo " <tbody><tr>
								
									<td align='center'>$lid</td>
									<td align='center'>$cid</td>
									<td align='center'>$regDate</td>
									<td align='center'>$approvalDate</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$cur $loan</td>
									<td align='center'>$rate %</td>
									<td align='center'>$term</td>
									<td align='center'>$cur</td>
									<td align='center'>$postBy</td>
									<td align='center'>$br_name</td>
									
									";
						echo "</tr></tbody></table>";
						
			}/////////////////
		///check Disburse
		if(!empty($code) && ($chk=='dis')){
			echo"<h3 class='tit'>Disburse Information:</h3>";
			echo'
			<table width="100%" cellpadding="0" cellspacing="0" height="auto" >
							<thead>
							<tr align="center" height="28" style="background:#0066FF; color:#FFF">
                                <td><b>LD</b></td>
								<td><b>CID</b></td>
                                <td><b>Register Date</b></td>
								<td><b>Disbursement Date</b></td>
                                <td><b>អ្នកខ្ចី</b></td>
                                <td><b>Borrower</b></td>
                                <td><b>Loan</b></td>
                                <td><b>Rate</b></td>
                                <td><b>Period</b></td>
								<td><b>Currency</b></td>
                                <td><b>Entry By</b></td>
                                <td><b>At</b></td>
							</tr>
                           </thead>		
						   ';
			///
				$sql = "SELECT * FROM `loan_process` WHERE ld='$code' AND dis='1' ORDER BY ld ASC limit 0,1;";
				$result = mysql_query($sql) or die(mysql_error());
				while($row=mysql_fetch_array($result))
					{
						$regis_id=$row['regis_id'];
						$lid=$row['ld'];
						$cid=$row['cid'];
						$cur=$row['cur'];
						$br=$row['loan_at'];
						//echo $currency_type;
						$regDate=date('d-m-Y',strtotime($row['reg_date']));
						$disDate=date('d-m-Y',strtotime($row['dis_date']));
						$myregDate=date('Y-m-d',strtotime($row['reg_date']));
						$approvalDate=date('d-m-Y',strtotime($row['app_date']));
						$myapprovalDate=date('Y-m-d',strtotime($row['app_date']));
						$postBy=$row['post_by'];
						break;
				}// end while
				///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$br' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
											break;
										}
						////
				///get from register
				$display_info="SELECT * FROM register WHERE id='$regis_id'";
				$result_info=mysql_query($display_info) or die (mysql_error());
				
				while($row=mysql_fetch_array($result_info)){
						$kh_borrower=$row['kh_borrower'];
						$borrower=$row['borrower'];
						break;
				}
				///get from cusApp
				$display_app="SELECT * FROM customer_app WHERE cid='$cid' AND register_date='$myregDate' AND approval_date='$myapprovalDate' order by cid";
				$result_app=mysql_query($display_app) or die (mysql_error());
				
				while($row=mysql_fetch_array($result_app)){
						$loan=formatMoney($row['approval_amt'],true);
						$rate=$row['approval_rate'];
						$term=$row['approval_period'];
						break;
				}
				echo " <tbody><tr>
								
									<td align='center'>$lid</td>
									<td align='center'>$cid</td>
									<td align='center'>$regDate</td>
									<td align='center'>$disDate</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$cur $loan</td>
									<td align='center'>$rate %</td>
									<td align='center'>$term</td>
									<td align='center'>$cur</td>
									<td align='center'>$postBy</td>
									<td align='center'>$br_name</td>
									
									";
						echo "</tr></tbody></table>";
						
			}/////////////////
		
		///check repay
		if(!empty($code) && ($chk=='repay')){
			echo"<h3 class='tit'>Repayment Detail :</h3>";
			echo'
			<table width="100%" cellpadding="0" cellspacing="0" height="auto">
							<thead>
							<tr align="center" height="28" style="background:#0066FF; color:#FFF">
								
								<td><b>N<sup>o</sup></b></td>
                                <td><b>Invoice No</b></td>
								<td><b>LD</b></td>
                                <td><b>Repaid Date</b></td>
								<td><b>អ្នកខ្ចី</b></td>
								<td><b>Borrower</b></td>
								<td><b>Principal</b></td>
								<td><b>Interest</b></td>	
								<td><b>Total</b></td>
								<td><b>COs</b></td>
								<td><b>Cashier</b></td>
                                <td><b>Repaid At</b></td>
                               
							</tr>
                           </thead>	
						   ';
			///
				$sql = "SELECT * FROM `invoice` WHERE lc='$code' ORDER BY invioce_no asc;";
				$result = mysql_query($sql) or die(mysql_error());
				$i=1;
				while($row=mysql_fetch_array($result))
					{
					
						$id=$row['reg_id'];
						//echo $currency_type;
						$mypaid_date=date('d-m-Y',strtotime($row['paid_date']));
						$invoice_no=$row['invioce_no'];
						$myld=$row['lc'];
						$principal=formatMoney($row['prn_paid'],true);
						$interest =formatMoney($row['int_paid'],true);
						$total=formatMoney($row['total'],true);
						$mycashier=$row['cashier'];
						$myco=$row['res_co'];
						$branch=$row['reciev_at'];
						///find branch name
								$br_info="SELECT * FROM br_ip_mgr where br_no='$branch' group by br_no";
									$result_br=mysql_query($br_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_br)){
											$br_name=$row['br_name'];
										}
						////
						///find approval info
								$more_info="SELECT * FROM register where id='$id' order by id";
									$result_info=mysql_query($more_info) or die (mysql_error());
										while($row = mysql_fetch_array($result_info)){
											$kh_borrower=$row['kh_borrower'];
											$borrower=$row['borrower'];
											$kh_co_borrower=$row['kh_co_borrower'];
											$co_borrower=$row['co_borrower'];
											$cur=$row['cur'];
										}
				
						////
					
						echo " <tbody><tr>
									<td align='center'>$i</td>
									<td align='center'>$invoice_no</td>
									<td align='center'>$myld</td>
									<td align='center'>$mypaid_date</td>
									<td align='center'>$kh_borrower</td>
									<td align='center'>$borrower</td>
									<td align='center'>$principal</td>
									<td align='center'>$interest </td>
									<td align='center'>$total</td>
									<td align='center'>$myco</td>
									<td align='center'>$mycashier</td>
									<td align='center'>$br_name</td>
									";
							
						echo "</tr>";
							$i++;
				}// end while
				echo "</tbody></table>";
		}
		///////
					$check_record=mysql_num_rows($result);
					if($check_record=='0'){
						echo"<script>alert('No Records Found!');</script>";
						echo"<script>window.location.href='?pages=home&catch=back';</script>";
						exit();
						}
	/*echo"<script>alert('$code,$chk!');</script>";*/
?>
<!-- Form -->
	
			
            