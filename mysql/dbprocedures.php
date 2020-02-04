<?php  
    // %d date 01,02; %D date 1st,2nd; %m month 01,02; %a day Sun,Mon; %b month Jan,Feb

  $months = [
      ['mth'=>0, 'month'=>'- all -'],
      ['mth'=>1, 'month'=>'January'],
      ['mth'=>2, 'month'=>'February'], 
      ['mth'=>3, 'month'=>'March'], 
      ['mth'=>4, 'month'=>'April'], 
      ['mth'=>5, 'month'=>'May'], 
      ['mth'=>6, 'month'=>'June'], 
      ['mth'=>7, 'month'=>'July'], 
      ['mth'=>8, 'month'=>'August'], 
      ['mth'=>9, 'month'=>'September'], 
      ['mth'=>10, 'month'=>'October'], 
      ['mth'=>11, 'month'=>'November'], 
      ['mth'=>12, 'month'=>'December']
    ];


  function getDB(){
    $mydb = new mysqli("localhost","root","","dbbmx");
    return $mydb;
  }


  function getRows($p_sql){

    // db connection
    $db = getDB();

    if(!$db){
       echo $db->error;

    } else {
      //  return array
      $qry = $db->query($p_sql);

      if(!$qry){
        echo $db->error;
        return [];

      } else {
         while($row = $qry->fetch_assoc() ){
            $array[] = $row;
         }
         $db->close();

        if (empty($array)){
          return [];
        } else {
           return $array;
        }

      }
    }
  }


  /* ----- SESSIONS -----*/

  function addSession($p_classid, $p_date, $p_time) {

    if ($p_classid="" or $p_date="" or $p_time=""){
      echo "All values must be filled";
    } else {

      // DB CONNECTION
      $db = getDB();
      if(!$db){
         //echo "<script type='text/javascript'>alert("'.$db->error.'");</script>";
      } else {
         echo "Opened database successfully\n";
      }

      // SET SQL STRING
      $sql ='INSERT INTO tblsessions (Class, SessionDate, SessionTime) 
        VALUES ("'.$p_classid.'", "'.$p_date.'", "'.$p_time.'");';

      // RUN SQL QUERY
      $db->query($sql);
    }
   }


  function deleteSession($p_sessionid) {

    // SET VARIABLES
    $sql = 'DELETE FROM tblsessions WHERE SessionId='.$p_sessionid.';';
    $count = countRecords('SessionId', 'tblsessionriders', 'sessionid='.$p_sessionid);

    if ($p_sessionid == ''){
      echo 'Session Id not set';
    } else {

      if ($count > 0) {
        echo 'Riders exist for this session';
      } else {
        // DB CONNECTION
        $db = getDB();

        if(!$db){
           echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
        } else {
          // RUN SQL QUERY
          $db->query($sql);
        }      
      }
    }
   }


  function getSessionList($p_year, $p_month = 0, $p_classid = 0) {
    // set variables
    $datefmt = '';
    
    // build sql string
    $whr = ' HAVING YEAR(SessionDate) LIKE '.$p_year;
    
    if($p_month != 0){
      $datefmt = 'date_format(SessionDate, "%a %D")';
      $whr = $whr.' AND MONTH(SessionDate) LIKE '.$p_month;
    } else {
      $datefmt = 'date_format(SessionDate, "%d-%b")';
    }
    
    if($p_classid != 0){
      $whr = $whr.' AND c.classid = '.$p_classid;
    } 

    // set sql string
    $sql = "SELECT s.SessionId, CONCAT(classname, ' - ', ridername) as Description, 
        ".$datefmt." as SessDate, SessionTime, Count(sr.sessionriderid) as NumRiders, c.classid 
      FROM ((tblsessions as s 
        INNER JOIN tblclasses as c ON s.classid = c.classid)
        INNER JOIN tblriders as r ON c.coachid = r.riderid)
        LEFT JOIN tblsessionriders as sr ON s.sessionid= sr.sessionid
      GROUP BY s.SessionId, Class, SessionDate, SessionTime ".$whr.";";
    
    //   return array
    if ($p_year == "") {
      return [];      
    } else {
      $qry = getRows($sql);      
      return $qry;
    }     
  }


  function getSessionCombo() {

    // set sql string
    $sql = "SELECT s.SessionId, CONCAT(c.ClassName, ' ', SessionDate, ' ', SessionTime) as Description
      FROM (tblsessions as s 
        INNER JOIN tblclasses as c ON s.classid = c.classid)
        INNER JOIN tblriders as r ON c.coachid = r.riderid
      WHERE SessionDate >= current_date()
      ORDER BY c.ClassName, SessionDate, SessionTime;";
    
    // return array
    $qry = getRows($sql);
    return $qry;
  }


/* ----- RIDERS -----*/

   function selectRider($p_riderid) {
      
      $db = getDB();
      if (!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
        if(!$p_riderid == 0) {
           $sql ='SELECT * FROM tblriders WHERE riderid='.$p_riderid.';';
        }
        $ret = $db->query($sql);
        if(!$ret){
          echo $db->error;
          return [];
        } else {
            while($row = $ret->fetch_assoc() ){
              $array[] = $row;
           }
           $db->close();
           return $array;
        }
        
      }


   }

   function getRiders($searchTerm = null) {
      
      $db = new mysqli("localhost","root","","dbbmx");
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      if(!$searchTerm) {
         $sql ='SELECT * FROM tblriders;';
      } else {
         $sql ='SELECT * ' +
           'FROM tblriders ' +
           'WHERE RiderName LIKE "'.$searchTerm.'" OR ' +
              'LicenceNum LIKE "'.$searchTerm.'" OR ' +
              'ContactName LIKE "'.$searchTerm.'" OR ' +
              'ContactNum LIKE "'.$searchTerm.'";';
      }
      $ret = $db->query($sql);
      if(!$ret){
        echo $db->error;
        return [];
      } else {
          while($row = $ret->fetch_assoc() ){
            $array[] = $row;
         }
         $db->close();
         return $array;
      }
   }

   function addRider($rtype, $rname, $licence, $expiry, $gender, $email, $phone, $contact, $contactphone, $password) {
     
      $db = new mysqli("localhost","root","","dbbmx");
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO tblriders (RiderType, RiderName, LicenceNum, ExpiryDate, Gender,
            ContactName, ContactNum, Phone, Email, Password) '.
        'VALUES ("'.$rtype.'", "'.$rname.'", "'.$licence.'", "'.$expiry.'", "'.$gender.'", 
            "'.$contact.'", "'.$contactphone.'", 
            "'.$phone.'", "'.$email.'", "'.$password.'");';
      $db->query($sql);
   }


/* ----- CLASSES -----*/

    function getClassList() {

      // set sql string
      $sql = "SELECT ClassId, ClassName, RiderName 
        FROM tblclasses as c INNER JOIN tblriders as r ON c.CoachId = r.RiderId
        ORDER BY ClassName;";
      
      // return array
      $qry = getRows($sql);
      return $qry;
    }


    function getClassCombo() {

      // set sql string
      $sql = "SELECT ClassId, CONCAT(classname, ' - ', ridername) as Description
        FROM tblclasses as c INNER JOIN tblriders as r ON c.CoachId = r.RiderId
        ORDER BY ClassName;";
      echo $qry;
      
      // return array
      $qry = getRows($sql);
      return $qry;
   }
   

   function addClass($classname, $coach) {
      
      $db = new mysqli("localhost","root","","dbbmx");
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO tblclasses (ClassName, Coach) '.
        'VALUES ("'.$classname.'", "'.$coach.'");';
      $db->query($sql);
   }


/* ----- ATTENDANCE -----*/

   function getSessionRiders($searchTerm = null) {
      $db = new mysqli("localhost","root","","dbbmx");
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }
      
        if(!$searchTerm) {
         $sql ='SELECT sr.RiderName, sr.LicenceNum, s.Class, s.SessionDate, s.SessionTime ' +
           'FROM tblsessionriders as sr ' +
              'INNER JOIN tblsessions as s ON sr.sessionid = s.sessionid;';
      } else {
         $sql ='SELECT sr.RiderName, sr.LicenceNum, s.Class, s.SessionDate, s.SessionTime ' +
           'FROM tblsessionriders as sr ' +
              'INNER JOIN tblsessions as s ON sr.sessionid = s.sessionid ' +
           'WHERE sr.RiderName LIKE "'.$searchTerm.'" OR ' +
              'sr.LicenceNum LIKE "'.$searchTerm.'" OR ' +
              's.Class LIKE "'.$searchTerm.'" OR ' +
              's.SessionDate LIKE "'.$searchTerm.'"';
      }
      $ret = $db->query($sql);
      if(!$ret){
        echo $db->error;
        return [];
      } else {
          while($row = $ret->fetch_assoc() ){
            $array[] = $row;
         }
         $db->close();
         return $array;
      }
   }

   
   function addSessionRider($riderid, $sessionid) {
  //tblsessionriders (RiderId, SessionId, Attended)
     
      $db = new mysqli("localhost","root","","dbbmx");
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO EVENTS (RiderId, SessionId, Attended) 
        VALUES ("'.$riderid.'", "'.$sessionid.'", null);';
      $db->query($sql);
   }
   

/* ----- USERS -----*/

   function getUser($searchTerm = null) {
      $db = new mysqli("localhost","root","","dbbmx");
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }
      
        if(!$searchTerm) {
         $sql ='SELECT * FROM tblusers;';
      } else {
         $sql ='SELECT * '.
           'FROM tblusers '.
           'WHERE UserName LIKE "'.$searchTerm.'" OR '.
              'UserType LIKE "'.$searchTerm.'" ;';
      }
      $ret = $db->query($sql);
      if(!$ret){
        echo $db->error;
        return [];
      } else {
          while($row = $ret->fetch_assoc() ){
            $array[] = $row;
         }
         $db->close();
         return $array;
      }
   }

   
   function addUser($p_name, $p_type, $p_password) {
      
      $db = new mysqli("localhost","root","","dbbmx");
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO EVENTS (UserName, usertype, password) '.
        'VALUES ("'.$p_name.'", "'.$p_type.'", "'.$p_password.');';
      $db->query($sql);
   }


/* ----- FUNCTIONS -----*/

function countRecords($p_keyname, $p_tablename, $p_criteria=''){
  
  // SET VARIABLES
  $key = $p_keyname;
  $table = $p_tablename;
  $criteria = $p_criteria;
  
  // SET SQL QUERY
  if ($criteria==''){
    $sql = 'SELECT '.$p_keyname.' FROM '.$p_tablename.';';    
  } else {
    $sql = 'SELECT '.$p_keyname.' FROM '.$p_tablename.' WHERE '.$p_criteria.';';    
  }
  
  // CONNECT & RUN QUERY
  $db = getDB();
  if(!$db){
    echo '<script type="text/javascript">alert("'.$db->error.'");</script>';
    return 0;
    
  } else {
    $result = mysqli_query($db, $sql);
    $num_rows = mysqli_num_rows($result);
    return $num_rows;    
  }
  
}


function lookupRecord($p_keyname, $p_tablename, $p_criteria){
  
  // Set variables
  $key = $p_keyname;
  $table = $p_tablename;
  $criteria = $p_criteria;
  
  // Set sql query
  $sql = 'SELECT '.$p_keyname.' FROM '.$p_tablename.' WHERE '.$p_criteria.';';    

  // Get row array
  $rows = getRows($sql);
  
  if ($rows == []) {
    return 0;    
  } else {
    return $rows[0][$p_keyname];
  }
}











?>