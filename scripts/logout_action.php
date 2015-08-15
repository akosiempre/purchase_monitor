<?php
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['MEMBER_UID']);
	unset($_SESSION['MEMBER_FNAME']);
	unset($_SESSION['MEMBER_LNAME']);
	unset($_SESSION['MEMBER_EMAIL']);
	session_unset();	
	session_destroy();
	if (!headers_sent()) { 
		header("location:../index.php"); 
	}	
?>
