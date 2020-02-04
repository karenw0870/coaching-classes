<?php 
  require_once "dbprocedures.php";

  $licence = $_POST['licence'];
  $sessionid = $_POST['sessionid'];

  // Search for rider
  $riderid = lookupRecord('LicenceNum', 'tblriders', 'LicenceNum = "'.$licence.'"');
  
  if ($riderid == 0) {
    // no rider exists - add rider
    $ridername = $_POST['ridername'];
    $expiry = $_POST['expiry'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $conname = $_POST['contactname'];
    $connum = $_POST['contactphone'];
    
    //addRider($rtype, $rname, $license, $expiry, $gender, $email, $phone, $contact, $contactphone, $password)
    addRider('Rider', $ridername, $licence, $expiry, $gender, $email, $phone, $conname, $connum, null);
    $riderid = lookupRecord('LicenceNum', 'tblriders', 'LicenceNum = "'.$licence.'"');
    
  } else {
    // rider exists
    // update any changes
    
  }
  
  //tblsessionriders (RiderId, SessionId, Attended)
  // lookup to see if rider is already booked in this class
  $sessionriderid = 0; //Lookup function - ADD LATER

  if ($sessionriderid == 0) {
    // add new session rider
    addSessionRider($riderid, $sessionid);
    echo "Your session attendance has been registered successfully.";
//     header("Location: ../bookings.php");
  } 
?>
