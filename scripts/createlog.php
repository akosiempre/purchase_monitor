<?php 
    $tbl_name    = 'syslog'; 
    $log_date = date("Y-m-d H:i:s", time());   
	$user = $_SESSION['MEMBER_USRNAME'];
  
//  set_time_limit(0); 
//  ignore_user_abort(1); 
      
    $qry = "insert into syslog (`log_date`, `log_activity`, `log_user` , `log_dtls`) values ('$log_date','$activity','$user','".addslashes($logdetails)."')"; 
    $result=mysql_query($qry); 
    if (!$result) { 
        $logmessage = "Query failed:  $qry - ".mysql_error(); 
        createLogfile($logmessage, 12); 
    }; 
	
  
?>