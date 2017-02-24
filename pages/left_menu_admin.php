				<li id="submenu-active"><a href="javascript:toggle('customer-tab');">Customer</a> <!-- Active -->
                	<div id="customer-tab" style="display:none">
					<ul>
						<li><a href="?pages=new_cust_register&encr=bin">New Customer</a></li>
						<li><a href="?pages=old_cust_register&encr=bin">Old Customer</a></li>
                        <?php 
						if($appSet=='0'){
							echo' 
                        	<li><a href="?pages=appAndCancel&catch=send">Approve Or Cancel</a></li>
							';
						}
						?>
						<li><a href="?pages=edit_cif_form&catch=save">Update CIF</a></li>
					</ul>
                  	</div>
				</li>
               	<li id="submenu-active"><a href="javascript:toggle('loan-tab');">Loan Entry</a> <!-- Active -->
                	<div id="loan-tab" style="display:none">
					<ul>
						<li><a href="?pages=loanEntryForm&catch=save">Individual Form</a></li>
						<li><a href="?pages=gid_form&catch=save">Group Form</a></li>
                        <li><a href="?pages=delete_loanForm&catch=delete">Delete Loan</a></li>
						<li><a href="?pages=edit_schForm&catch=edit">Update Schedule</a></li>
                        <li><a href="?pages=edit_loanForm&catch=edit">Edit Loan</a></li>
					</ul>
                    </div>
				</li>
                <li id="submenu-active"><a href="javascript:toggle('dis-tab');">Disbursement</a> <!-- Active -->
                	<div id="dis-tab" style="display:none">
					<ul>
						<li><a href="?pages=disForm&catch=save">Disbursement Form</a></li>
						<li><a href="?pages=delete_disForm&catch=delete">Delete Disbursement</a></li>
					</ul>
                    </div>
				</li>
                <li id="submenu-active"><a href="javascript:toggle('repay-tab');">Repayment</a> <!-- Active -->
                 	<div id="repay-tab" style="display:none">
					<ul>
						<li><a href="?pages=general_repayForm&catch=repay">General Repayment</a></li>
                        <li><a href="?pages=reschedule&catch=repay">Reschedule</a></li>
                        <li><a href="?pages=payOff_Form&catch=bin">Pay Off</a></li>
					</ul>
                    </div>
				</li>
               <li id="submenu-active"><a href="javascript:toggle('saving-tab');">Saving</a> <!-- Active -->
                 	<div id="saving-tab" style="display:none">
					<ul>
                    	<li><a href="?pages=acc_saving_form&catch=repay">Open New Account</a></li>
						<li><a href="?pages=deposit_form&catch=repay">Deposit</a></li>
                        <li><a href="?pages=witdraw_form&catch=repay">Withdrawal</a></li>
                    
					</ul>
                    </div>
				</li>
                <!-- <li id="submenu-active"><a href="javascript:toggle('Acc-tab');">Accounting</a> <!-- Active 
                 	<div id="Acc-tab" style="display:none">
					<ul>
						<li><a href="?pages=chartofacc&catch=repay">Chart of Account</a></li>
                        <li><a href="?pages=postbatch&catch=repay">Post Batch</a></li>
                        <li><a href="?pages=glpointerform&catch=repay">GL Pointer</a></li>
                        <li><a href="?pages=preparebl&catch=repay">Prepare Balance Sheet</a></li>
                        <li><a href="?pages=prepareincomestatement&catch=repay">Prepare Income statement</a></li>                        
					</ul>
                    </div>
				</li> -->
                <!--<li id="submenu-active"><a href="javascript:toggle('advan-tab');">Clear Advance CO</a> <!-- Active -->
                 <!--	<div id="advan-tab" style="display:none">
					<ul>
						<li><a href="?pages=deposit_form&catch=repay">Recieve</a></li>
                        <li><a href="?pages=witdraw_form&catch=repay">Return</a></li>
                    
					</ul>
                    </div>
				</li>-->
                 <li id="submenu-active"><a href="javascript:toggle('reports-tab');">Reports</a> <!-- Active -->
                 	<div id="reports-tab" style="display:none">
					<ul>
						<li><a href="?pages=search_cif_form&catch=bin">CIFs Information</a></li>
                        <?php 
						if($appSet=='0'){
							echo'
							<li><a href="?pages=search_approval_loan_form&catch=enc">Approval Loan</a></li>
							<li><a href="?pages=search_reject_loan_form&catch=enc">Rejected Loan</a></li>
							' ;
						}
						?>
                        <li><a href="?pages=search_loanInfo_form&catch=enc">Loan Information</a></li>
                        <li><a href="?pages=search_loanDis_form&catch=enc">Loan Disbursement</a></li>
                        <li><a href="?pages=search_perform_form&catch=enc">Performance</a></li>
                        <li><a href="?pages=search_noneDis_form&catch=enc">None-Disbursement</a></li>
                        <li><a href="?pages=print_scheduleForm&catch=enc">Print Schedule</a></li>
                        <li><a href="?pages=search_schrepay_form&catch=enc">Schedule Repayment</a></li>
                         <li><a href="?pages=search_colInfo_list&catch=enc">Collateral Info</a></li>
                         <li><a href="?pages=print_slipForm&catch=enc">Print Repay Slip</a></li>
                        <li><a href="?pages=search_portfolio_form&catch=enc">Loan Disburse by Area</a></li>
                        <li><a href="?pages=search_dailyrepay_form&catch=enc">Daily Repayment</a></li>
                        <li><a href="?pages=addressList&catch=enc">Address</a></li>
                        
                         <li><a href="?pages=print_subsiForm&catch=enc">Subsidery Ledger</a></li>
                        <li><a href="?pages=search_loanClassify_form&catch=enc">Loan Classification</a></li>
                        <!--<li><a href="#">AIR</a></li>-->
                        <li><a href="?pages=search_loanOS_form&catch=enc">Loan Information Detail</a></li>
                        <li><a href="?pages=search_arearepay_form&catch=enc">Area Repayment</a></li>
                        <li><a href="?pages=search_staff_list&catch=user">Staff List</a></li>
                        <li><a href="pages/show_all_gid_list.php" target="_blank">Group ID List</a></li>
                        <li><a href="?pages=search_current_interest&catch=enc">Current Interest</a></li>
                        <li><a href="?pages=search_future_interest_by_period&catch=enc">Future interest by period</a></li>
                        <li><a href="?pages=search_withdraw_transction&catch=enc">Withdrawal Transaction</a></li>
                        <li><a href="?pages=search_deposit_transction&catch=enc">Deposit Transaction</a></li>
                        <li><a href="?pages=search_deposit_customer_list&catch=enc">Deposit Customer List</a></li>
                        <li><a href="?pages=search_total_interest_os&catch=enc">Total Interest and Deposit O/s</a></li>
<!---
                        <li><a href="?pages=search_bl_form" >Balance Sheet</a></li>
                        <li><a href="?pages=search_income_form">Income statement</a></li>
                        <li><a href="?pages=search_ftb_form" >Full Trail Balance</a></li>
                        <li><a href="?pages=search_batch_form">Batch Transaction</a></li>	
                       		---Account------->	

		</ul>
                    </div>
				</li>