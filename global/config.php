<?php
	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'db_purchasemonitor');

	ini_set('display_errors', FALSE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Asia/Manila');	
	
	function createLogfile($logmessage, $error) {
		$logfile = '../logs/systemlogfile.txt';
		$logdate = date("Y-m-d");
		$logtime = date("H:i:s");
		
		if (file_exists($logfile)) {
			$fh = fopen($logfile,'a') or die("can't open file $logfile");
			$logdata = $logdate."@".$logtime."=\"".$logmessage.";error-code:".$error."\"\n";
			fwrite($fh, $logdata);
			fclose($fh); 
		} else {
			$fh = fopen($logfile,'w') or die("can't open file $logfile");
			$logdata = "System Log Started date: ".$logdate."@".$logtime."\n";
			fwrite($fh, $logdata);
			fclose($fh); 

			$fh = fopen($logfile,'a') or die("can't open file $logfile");
			$logdata = "LOG_DATE@LOGTIME=\"LOG_MESSAGE\"\n";
			fwrite($fh, $logdata);			
			
			$fh = fopen($logfile,'a') or die("can't open file $logfile");
			$logdata = $logdate."@".$logtime."=\"".$logmessage.";error-code:".$error."\"\n";
			fwrite($fh, $logdata);
			fclose($fh); 		
		}
		if ($error > 0) {
			die("An Error has occured.. please see log message");
		}
	}	

	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}	
?>