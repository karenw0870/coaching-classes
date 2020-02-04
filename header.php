<?php
  require_once ("mysql/dbprocedures.php");

	if (session_status() == PHP_SESSION_NONE) {
    session_start();
	}

	$_SESSION['rider'] = '';		
	$_SESSION['licence'] = '';
	$_SESSION['password'] = '';

		if (empty($_POST['licencenum']) || empty($_POST['password'])) {
		$error = 'Licence or Password is invalid';
	} else {
		$licence = $_POST['licencenum'];
		$password = $_POST['password'];
		$ridername = lookupRecord('ridername', 'tblriders', 
															'LicenceNum = "'.$licence.'" and Password="'.$password.'"');

		$_SESSION['rider'] = $ridername;		
		$_SESSION['licence'] = $licence;
		$_SESSION['password'] = $password;
		$_user = $ridername;
		$_loglicence = $licence;
	}
?>

<!-- Logo Title -->
	<div id="hdr">
		<div id="hdr_logo">
			<a href="index.php"><img id="hdr_logo_img" src="/_Project/images/logo.gif"/></a>			
		</div>
		<div id="hdr_title">
			<div id="hdr_title_screen">Coaching Program<br/></div>
			<div id="hdr_title_mobile">Coaching</div>	
		</div>
	</div>
	
	<!-- Menu -->
	<div id="menubar">
	</div>

	<div id="menu">
		<div id="menublock" width="100%">	
			<ul id="menu_items" style="margin-top: 0; margin-bottom: 0;">
			<!-- this ul WILL NOT give a top margin of 0 if entered into css -->
				<li><a href="/_Project/classes.php">Classes</a></li>
				<li><a href="/_Project/coaches.php">Coaches</a></li>
				<li><a href="/_Project/events.php">Sessions</a></li>
			</ul>					
		</div>
		<div>
			<img id="menu_navimg" name="navimg" src="/_Project/images/navbtn_light.gif"
				 onmouseover="this.src='/_Project/images/navbtn_dark.gif';" 
				 onmouseout="this.src='/_Project/images/navbtn_light.gif';">			
		</div>
	</div>

	<!-- Login -->
	<div id="login">
		<form action="" method="post" name="loginform">
			<input id="login_input" type="text" name="licencenum" placeholder="licence..."
						 value=""/>
			<input id="login_input" type="password" name="password" placeholder="password..."
						 value=""/><br/>
			<input id="login_submit" type="submit" value="Log in">
			<input type="reset" value="Reset">
		</form>
				<p>Hi <?=$_SESSION['rider']?></p>
			<?php
				if ($_SESSION['rider'] != '') { ?>
					<p>Hello <?=$_SESSION['rider']?></p>
			<?php
				} ?>
	</div>

	<!-- Home -->
	<div id="home">
		<a href="/_Project/index.php">
			<img id="home_img" src="/_Project/images/myhome.gif" 
				 onmouseover="this.src='/_Project/images/homedark.gif';" 
				 onmouseout="this.src='/_Project/images/myhome.gif';" /></a>			
	</div>



