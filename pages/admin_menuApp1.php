<div id="nav-right">
		
			<div class="nav-divider">&nbsp;</div>
			<div class="showhide-account"><img src="images/shared/nav/nav_myaccount.gif" width="93" height="14" alt="" /></div>
			<div class="nav-divider">&nbsp;</div>
			<a href="pages/signout.php?action=signout" id="logout">
            	<img src="images/shared/nav/nav_logout.gif" width="64" height="14" alt="" />
            </a>
			<div class="clear">&nbsp;</div>
		
			<!--  start account-content -->	
			<div class="account-content">
			<div class="account-drop-inner">
				<a href="" id="acc-settings">Settings</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-details">Personal details </a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-project">Project details</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-inbox">Chatting</a>
				<div class="clear">&nbsp;</div>
				<div class="acc-line">&nbsp;</div>
				<a href="" id="acc-stats">History</a> 
			</div>
			</div>
            <div class="account-drop-inner">
            	<a><?php echo 'Welcome - <font color="#FFFF99">'.$user.'<font>'; ?></a>
            </div>
			<!--  end account-content -->
		
		</div>
		<!-- end nav-right -->


		<!--  start nav -->
		<div class="nav">
		<div class="table">
		
		<ul class="current"><li><a href="#nogo"><b>CUSTOMER</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="?pages=new_cust_register&encr=bin">New-Customer</a></li>
				<li><a href="?pages=old_cust_register&encr=bin">Old-Customer</a></li>
                <li><a href="?pages=edit_cif_form&catch=save">Edit CIF</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>               
		<ul class="select"><li><a href="#nogo"><b>LOAN ENTRY</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="?pages=loanEntryForm&catch=save">Individual Loan Form</a></li>
                <li><a href="?pages=gid_form&catch=save">Group Loan Form</a></li>
                <li><a href="?pages=delete_loanForm&catch=delete">Delete Loan</a></li>
                <li><a href="?pages=edit_schForm&catch=edit">Edit Schedule</a></li>
                <li><a href="?pages=edit_loanForm&catch=edit">Edit Loan</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
        <div class="nav-divider">&nbsp;</div>
		<ul class="select"><li><a href="#nogo"><b>DISBURSEMENT</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub show">
			<ul class="sub">
				<li><a href="?pages=disForm&catch=save">Disburse Form</a></li>
                 <li><a href="?pages=delete_disForm&catch=delete">Delete Disbursement</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>
		<ul class="select"><li><a href="#nogo"><b>REPAYMENT</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
                <li><a href="?pages=general_repayForm&catch=repay" title="General Repayment">General Repayment</a></li>
				<li><a href="#nogo">Specified Repayment</a></li>
				<li><a href="?pages=reschedule&catch=repay">Reschedule</a></li>
                <li><a href="?pages=payOff_Form&catch=repay">Pay Off</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		
		<div class="nav-divider">&nbsp;</div>
		
		<ul class="select"><li><a href="#nogo"><b>REPORT</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
            	<li><a href="#nogo">CIFs Information</a></li>
				<li><a href="?pages=search_loanInfo_form&catch=enc">Loan Information</a></li>
                <li><a href="?pages=search_loanDis_form&catch=enc">Loan Disbursement</a></li>
				<li><a href="#nogo">Performance</a></li>
                <li><a href="?pages=search_noneDis_form&catch=enc">None-Disbursement</a></li>
                <li><a href="?pages=print_scheduleForm&catch=enc">Print Schedule</a></li>	
                 <li><a href="?pages=search_schrepay_form&catch=enc">Schedule Repayment</a></li>	
                <li><a href="#nogo">Loan Portfolio</a></li> 
                <li><a href="?pages=search_dailyrepay_form&catch=enc">Daily Repayment</a></li>
                <li><a href="#nogo">Address</a></li>	
                <li><a href="?pages=print_subsiForm&catch=enc">Subsidery Ledger</a></li> 
                <li><a href="#nogo">Loan Classification</a></li> 
                <li><a href="#nogo">AIR</a></li> 
                <li><a href="#nogo">Online User</a></li> 
                <li><a href="#nogo">Users-Logs</a></li>
                 <li><a href="?pages=search_arearepay_form&catch=enc">Area Repayment</a></li>
                <li><a href="#nogo">Active Users</a></li> 
                <li><a href="#nogo">None-Active Users</a></li>
                <li><a href="?pages=search_staff_list&catch=user">Staff List</a></li>
                <li><a href="pages/show_all_gid_list.php" target="_blank">All Group ID List</a></li>
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		
		<div class="nav-divider">&nbsp;</div>
		<ul class="select"><li><a href="#nogo"><b>SETTING</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub">
			<ul class="sub">
				<li><a href="?pages=loan_config_list&catch=enc">Loan Config</a></li>
                <li><a href="?pages=payment_fq_list&catch=enc">Repayment Frequency</a></li>
				<li><a href="?pages=show_user_list&catch=empty">User Level</a></li>
				<li><a href="?pages=show_ip_list&catch=catch">IP Management</a></li>
                <li><a href="#nogo">Address Management</a></li>
                <li><a href="#nogo">Dumper Database</a></li>
                <li><a href="#nogo">Back Up</a></li>
                
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div>
		<!--  start nav -->