<?php 
 session_start();
    if(empty($_SESSION['usr'])) header('location:pages/login.php?clear');
	include('pages/conn.php');
	$user=$_SESSION['usr'];
	$get_br=$_SESSION['br'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" /> <!-- RESET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" /> <!-- MAIN STYLE SHEET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
	<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="css/1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
	<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" /> <!-- GRAPHIC THEME -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
    <script type="text/javascript" src="js/class_and_function.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/switcher.js"></script>
	<script type="text/javascript" src="js/toggle.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.tabs.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".tabs > ul").tabs();
	});
	</script>

	<title>Online Loan Management System - OLMS</title>
</head>
<body>
<div id="main">
	<!-- Tray --> 
	<div id="tray" class="box">

		<p class="f-left box">

			<!-- Switcher -->
			<span class="f-left" id="switcher">
				<a href="#" rel="1col" class="styleswitch ico-col1" title="Display one column"><img src="design/switcher-1col.gif" 
                alt="1 Column" /></a>
				<a href="#" rel="2col" class="styleswitch ico-col2" title="Display two columns"><img src="design/switcher-2col.gif" 
                alt="2 Columns" /></a>
			</span>

			PROJECT NAME : <strong>ONLINE LOAN MANAGEMENT SYSTEM VERSION 1.0.0</strong>

		</p>

		<p class="f-right">User: <strong><?php echo $user; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>
        <a href="pages/signout.php?action=signout" id="logout">Log out</a></strong></p>

	</div> 
    <!--  /tray -->

	<hr class="noscreen" />

	<!-- Menu -->
				<?php
					include("pages/top_admin_menu.php");
				?>
    <!-- Menu -->
    <!-- /header -->

	<hr class="noscreen" />

	<!-- Columns -->
	<div id="cols" class="box">

		<!-- Aside (Left Column) -->
		<div id="aside" class="box">

			<div class="padding box">

				<!-- Logo (Max. width = 200px) -->
				<p id="logo"><a href="?index"><img src="tmp/logo.png" alt="Our logo" title="សមាគម ឥណទាន សារីណា" /></a></p>

				<!-- Search -->
				<form action="?pages=qSearch" method="post" id="search" enctype="multipart/form-data">
					<fieldset>
						<legend>Quick Search</legend>

						<p><input type="text" size="17"  value="LD" name="quick_search" class="input-text" onblur="ChangeCase(this);" 
                        maxlength="15" autocomplete="off" onblur="if (this.value=='') { this.value='LD'; }" onfocus="if (this.value=='LD') { this.value=''; }"/>
                        &nbsp;<input type="submit" value="OK" name="submit" class="input-submit-02"/><br />
						<a href="javascript:toggle('search-options');" class="ico-drop">Advanced search</a></p>

						<!-- Advanced search -->
						<div id="search-options" style="display:none;">

							<p>
								<label><input type="checkbox" name="chk" checked="checked" value="loan"/> Loan</label><br />
								<label><input type="checkbox" name="chk" value="dis"/> Disburse</label><br />
								<label><input type="checkbox" name="chk" value="repay"/> Repayment</label>
							</p>

						</div> <!-- /search-options -->

					</fieldset>
				</form>

				<!-- Create a new project -->
				<!--<p id="btn-create" class="box"><a href="#"><span>Create a new project</span></a></p>-->

			</div> <!-- /padding -->

			<ul class="box">
				<!-- left menus -->
					<?php
						include("pages/left_menu_admin.php");
					?>
				<!-- end left menus -->
		</div> <!-- /aside -->
		
		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">
        <!-- dynamic pages -->
        
			<?php 
						if($_REQUEST['pages']==''){
							include('pages/home.php');
						}else{
							include('pages/'.$_REQUEST['pages'].'.php');
						}
						mysql_close();
			?>
              
			<!-- end dynamic pages -->
		</div> <!-- /content -->

	</div> <!-- /cols -->

	<hr class="noscreen" />
	<!-- Footer -->
	<div id="footer" class="box">
		<p class="f-left">&copy; 2013 <a href="#">SARINA</a>, All Rights Reserved &reg;  Developed By Software Development Technology (SDT)
        </p>
	</div> <!-- /footer -->
</div> <!-- /main -->
</body>
</html>