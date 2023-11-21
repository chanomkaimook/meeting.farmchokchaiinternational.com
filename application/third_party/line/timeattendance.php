<?
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Bangkok");
	$date = date('d/m/Y');
	$time = date('H:i:s');
	$lat = $_GET["lat"];
	$long = $_GET["long"];
	$reason = $_GET["reason"];
	if($_GET["outsite"] != ""){
	$sToken = "YyhX2VrFswxWpp2ZfMwKEH3YDCcvEMFFDGLA8sUI28g";
	$sMessage = "\nรหัสพนักงาน : ".$_COOKIE["Username"]."\nชื่อ-นามสกุล : ".$_COOKIE["Name"]."\nวันที่ : ".$date."\nเวลา : ".$time."\nสาเหตุ : ".$reason."\nตำแหน่ง : https://www.google.com/maps/search/".$lat."%2B".$long;
	}else{
	$sToken = "4aSKjXhuoXNEJWPWn0J06pYcfw8QmsuVzWHYd9ytLpC";
	$sMessage = "\nรหัสพนักงาน : ".$_COOKIE["Username"]."\nชื่อ-นามสกุล : ".$_COOKIE["Name"]."\nวันที่ : ".$date."\nเวลา : ".$time."\nตำแหน่ง : https://www.google.com/maps/search/".$lat."%2B".$long;
	//Something to write to txt log
	$log  = $_COOKIE["Username"]."	".date('Ymd')."	".date('H:i:s')."\n";
	//Save string to log, use FILE_APPEND to append.
	file_put_contents('./timeattendance_'.date("n").'.log', $log, FILE_APPEND);
	}
	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		header('Location: https://thaidrill-hr.com/timeattendance/');
	} 
	curl_close( $chOne );
?>