<!DOCTYPE html>
<html>
<head>
	<title>Timbucktoo BMX Coaching</title>
	<?php 
		include ('stylesheets/styles.php');
		require_once ('mysql/dbprocedures.php');
	?>
</head>
<body>
	<!-- HEADER -->
	<?php include ('header.php'); ?>
	 
	<!-- MAIN CONTENT -->
	<div class="home_content">

		<div class="box home_contentitem">
			<h2>Classes</h2>
			<a href="pg_classes.php" ><img class="homeimg" src="images/molly.jpg" width=80% /></a>
			<ul>
				<li>Track skills</li>
				<li>Bike maintenance</li>
				<li>Healthy body</li>
			</ul>
			<p>Discounts will apply for more than 2 classes per week.  
				Family discounts may also apply.</p>
			<img class="imgtopleft" src="images/sprocket.gif"/>
		</div>

		<div class="box home_contentmid">
			<h2>Announcements</h2>
			<dl>
				<dt class="hdr">4th April</dt>
				<dd>
					Coaching classes cancelled due to poor track conditions.
				</dd>
			</dl>
			<img class="homeimg" src="images/announce.jpg" width=90% />
		</div>
		
		<div class="box home_contentitem">
			<h2>Coaches</h2>
			<a href="pg_classes.php" ><img class="homeimg" src="images/jump.jpg" width=80% /></a>
			<p>Meet our wonderful range of coaches. Our coaches come with loads of 
				experience from current Elite riders to the veteran class riders.</p>
			<img class="imgtopright" src="images/sprocket.gif"/>	
		</div>
	</div>
	
	<!-- FOOTER -->
	<?php include ('footer.php'); ?>
</body>
</html>