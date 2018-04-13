<?php
	
	$zone = $_POST["timezone"];
	$startH = $_POST["startTimeHr"];
	$startM = $_POST["startTimeMin"];
	$endH = $_POST["endTimeHr"];
	$endM = $_POST["endTimeMin"];
	
	$ip     = $_SERVER['REMOTE_ADDR']; // means we got user's IP address 
	$json   = file_get_contents( 'http://ip-api.com/json/'.$ip); // this one service we gonna use to obtain timezone by IP
	// maybe it's good to add some checks (if/else you've got an answer and if json could be decoded, etc.)
	$ipData = json_decode( $json, true);
	
	//echo $ipData["timezone"] ;

	if ($ipData['timezone']) {
		//$current = new DateTimeZone( $ipData['timezone']);
		$current = $ipData['timezone'];
		//echo "yes " ;
		//$now = new DateTime( 'now', $tz); // DateTime object corellated to user's timezone
	} else {
		$current = "America/New_York";
		//echo "no ";
	}
	
	$startT = $startH.":".$startM.":00";
	$endT = $endH.":".$endM.":00";
	$startZ = new DateTime($startT);
	$endZ = new DateTime($endT);
	
	date_default_timezone_set($current);

	echo "Current time zone by IP address:   ".$current.":  ";
	
	$date =  date("Y-m-d h:i:s");
	
	$dateTime = new DateTime($date);
	
	echo "EST ".$dateTime->format('Y-m-d H:i:s')."<br><br>";
	
	$newZone = new DateTimeZone($zone);
	
	$dateTime->setTimezone($newZone);
	
	echo "Current time in the destination time zone:   $zone:   ".$dateTime->format('Y-m-d H:i:s')."<br><br>";
	
	echo "Local time frame in current time zone is from start at:  ".
				$startZ->format('H:i:s')."   To end at:  ".$endZ->format('H:i:s')."<br><br>";
	
	$startZ->setTimezone($newZone);
	$endZ->setTimezone($newZone);
		
	echo "Local time frame in selected time zone is from start at:  ".
				$startZ->format('H:i:s')."   To end at:  ".$endZ->format('H:i:s')."<br><br>";
	
?>