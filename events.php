<!DOCTYPE html>
<html>
<head>
	<title>BMX Training Sessions</title>
	<?php
		include ("stylesheets/styles.php");
		require_once ("mysql/dbprocedures.php");
		$year = date("Y");
		$month = date("n") + 1;
		$classid = 0;

		if (array_key_exists("month",$_GET)) {
			$month = $_GET['month'];
			$year = $_GET['year'];	
			$classid = $_GET['classid'];	
		}
	?>
	
	<link rel="stylesheet" type="text/css" media="(max-width: 499px)"
				href="/_Project/stylesheets/mobile_pgevents.css" />
	<link rel="stylesheet" type="text/css" media="(min-width: 500px)"
				href="/_Project/stylesheets/screen_pgevents.css" />
	
	</head>
<body>
	<!-- HEADER -->
	<?php include ('header.php'); ?>
	
	<!-- CONTENT -->
	<div class="content">
		<h1>Session &amp; Events</h1>	

		<div class="textframe topright">
			<img class="imgtopright" src="images/sprocket.gif"/>
			<p>Locate the required class or event you wish to attend
			&amp; click 'book' to register your interest in the class.</p>					
		</div>
		
		<!-- Filter -->
		<div id="filterbox">
			<form action="events.php" method="get" id="searchsession">
				<label for="year">Year: 
					<input class="inpyear" name="year" type="number" value="<?= date('Y')?>">
				</label>

				<label for="month">Month: 
					<select class="inpmonth" name="month" default="<?=$month?>">
						<?php 
						foreach($months as $listmth) {?>
							<option 
								value="<?=$listmth['mth']?>" 
								<?php if($month==$listmth['mth']) {?> selected <?php ;} ?> >
										<?=$listmth['month']?></option>
						<?php
						} ?>
					</select>
				</label>	
				
				<label for="class">Class:		
					<select class="inpclass" name="classid" default="<?=$classid?>">
						<option value="0">- all -</option>
						<?php
						$classes = getClassCombo();
									
						foreach ($classes as $class) {
							$thisclassid = $class['ClassId'];?>
							<option 
								value='<?=$thisclassid?>'
								<?php if($classid == $thisclassid) {?> selected <?php ;} ?> >
									<?=$class['Description']?>
							</option>	
						<?php
						}?>
					</select>
				</label>
				
				<input type="submit" value="Filter" />
			</form>	
		</div>
		<div class="clearline">
			
		</div>
		<!-- Main content area (Sessions list) -->
		<div class="tablearea">
			<table id="calendar">
				<thead>
						<th class="hdrdate">Date</th>
						<th class="hdrclass">Session or Event</th>
						<th class="hdrriders">Riders</th>
						<th class="hdrtimes">Times</th>
						<th class="hdrbook">Book</th>
				</thead>
				<tbody>
				<?php
					if ($year == 0) {
						echo 'A year must be selected.';
					} else {
						$sessionlist = getSessionList($year, $month, $classid);

						if (empty($sessionlist)) {
							echo 'There are no sessions during the selected time period.';
						} else if ($year == 0) {
							echo 'A year must be selected.';
						} else {
							foreach ($sessionlist as $session)
							{
						?>
							<tr>
								<td class="coldate"><?= $session["SessDate"] ?></td>
								<td class="colclass"><?= $session["Description"] ?></td>
								<td class="colriders"><?= $session["NumRiders"] ?></td>
								<td class="coltimes"><?= $session["SessionTime"] ?></td>
								<td class="colbook"><a href="bookings.php?mysessionid=<?=$session['SessionId']?>">Book</a></td>
							</tr>
						<?php
							}
						}
					}
					?>
				</tbody>
			</table>
			<br /><br />	
		</div>
	</div>
	
	<!-- FOOTER -->
	<?php include ('footer.php'); ?>
</body>
</html>