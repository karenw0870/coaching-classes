<!DOCTYPE html>
<html>
<head>
	<title>Training Session Booking</title>
	<?php 
		include ('stylesheets/styles.php');
		require_once ('mysql/dbprocedures.php');
		
		if (array_key_exists("mysessionid",$_GET)) {
			$mysessionid = $_GET["mysessionid"];	
		} else {
			$mysessionid = 0;
		}
?>
</head>
<body>
	<!-- HEADER -->
	<?php include ('header.php'); ?>

	<!-- CONTENT -->
	<div class="content">
		<h1>Training Session Bookings</h1>
		
		<form action="mysql/sessionridersave.php" method="post" id="bookingform">
			<fieldset id="riderdetails">
				<legend><span>Rider Details</span></legend>
							
				<input type="text" name="riderid" hidden>				
				<label>Rider's name: <input class="txt_long" type="text" name="ridername"></label>
				<label>Licence num.: <input class="txt_short" type="text" name="licence"></label>
				<label>Expiry date: <input class="txt_med" type="date" name="expiry"></label>		
				<label>Email:<input class="txt_long" type="email" name="email"></label>
				<label>Phone:<input class="txt_short" type="text" name="phone"></label>
				
				<div class="gender">
					<label><input type="radio" name="gender" id="male" value="male">Male</label>
					<label><input type="radio" name="gender" id="female" value="female">Female</label>
				</div>
				
			</fieldset>

			<fieldset id="contactperson">
				<legend><span>Contact details</span></legend>
				<label>Contact person:<input class="txt_long" type="text" name="contactname"></label>
				<label>Phone:<input class="txt_short" type="text" name="contactphone"></label>
			</fieldset>

			<fieldset id="classbooking">
				<legend><span>Select class</span></legend>
				<label>Class:<select name="sessionid" class="txt_long">
					<?php
						$sessions = getSessionCombo();
					
						foreach ($sessions as $session) {
							$thisid = $session['sessionid'];?>
							<option 
								value='<?=$thisid?>'
								<?php if($mysessionid == $thisid) {?> selected <?php ;} ?> >
									<?=$session['Description']?>
							</option>	
					<?php
						}?>
				</select></label>
			</fieldset>		

			<fieldset id="comments">				
				<legend><span>Comment</span></legend>
				<textarea name="message"></textarea>
			</fieldset>
			
			<input type="submit" value="Save Booking">
			<br class="clearline" />
		</form>
</div>

	<!-- FOOTER -->
	<?php include ('footer.php'); ?>
</body>
</html>