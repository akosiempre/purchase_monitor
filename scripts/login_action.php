<?php
	session_start();
	require_once('../global/config.php');	
	
	//Array to store validation errors
	$errmsg_arr = array();
	$login_err = "";
	
	//Validation error flag
	$errflag = false;
	
	//table name
	$tbl_name="usrm";

	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		$logmessage = "Failed to connect to server:". mysql_error()." - $link ";
		createLogfile($logmessage, 12);			
	}
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		$logmessage = "Unable to select database $db";
		createLogfile($logmessage, 12);				
	} 
	
	//Function to sanitize values received from the form. Prevents SQL injection

	//Sanitize the POST values
	$myusername = clean($_POST['Username']);
	$mypassword = clean($_POST['Userpwd']);
	
	//Input Validations
	if($myusername == '') {
		$login_err = 'Username required';
		$errflag = true;
	}
	else
	if($mypassword == '') {
		$login_err = 'Password missing';
		$errflag = true;
	}

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['MEMBER_USRNAME']	 = $myusername;
		$_SESSION['LOGIN_ERROR'] = $login_err;
		session_write_close();
		header("location:../index.php");
		exit();
	}
	
	//Create query
	$qry="SELECT * FROM $tbl_name WHERE username='$myusername' and password='".md5($_POST['Userpwd'])."'";
	$result=mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$activeflg = $member['activeflg'];
			$adminflg  = $member['adminflg'];
			if ($activeflg !== "Y") {
				$login_err = 'Account not active, Contact your System Administrator..';
				$_SESSION['LOGIN_ERROR'] = $login_err;
				session_write_close();
				header("location:../index.php");
				exit();
			}
			$currdate = date("Y-m-d");
			$tbl_name = "usrm";
			$qry="UPDATE $tbl_name set `last_activedt` = '$currdate' where `id` = '".$member['id']."'";
			$last_active = mysql_query($qry);
			$_SESSION['MEMBER_USRID']   = $member['id'];			
			$_SESSION['MEMBER_USRNAME'] = $member['username'];			
			$_SESSION['MEMBER_FNAME']   = $member['firstname'];
			$_SESSION['MEMBER_LNAME']   = $member['lastname'];
			$_SESSION['MEMBER_EMAIL']   = $member['emailadd'];
			$_SESSION['MEMBER_DEPT']    = $member['empdepartment'];
			$_SESSION['MEMBER_POST']    = $member['empposition'];
			$_SESSION['MEMBER_USRFLG']  = $activeflg;
			$_SESSION['MEMBER_ADMFLG']  = $adminflg;
			$_SESSION['LOGGEDIN'] 		= $member['username'];
			switch ($adminflg) {
				case "Y":
					$_SESSION['MEMBER_FLG'] = "Admin";
					$_SESSION['MEMBER_ADMFLG'] = "Y";
					$_SESSION['MEMBER_FLG_X'] = "Non-Admin";
					$_SESSION['MEMBER_ADMFLG_X'] = "N";						
					break;
				case "N":
					$_SESSION['MEMBER_FLG_X'] = "Admin";
					$_SESSION['MEMBER_ADMFLG_X'] = "Y";	
					$_SESSION['MEMBER_FLG'] = "Non-Admin";
					$_SESSION['MEMBER_ADMFLG'] = "N";					
					break;
				}
			session_write_close();
			if ($adminflg == "Y") {
				header("location:../admin/");
			} else {
				header("location:../personal/");
			}
			exit();
		}else {
			//Login failed
			$login_err = 'Invalid Username/Password Combination';
			$_SESSION['MEMBER_USRNAME']	 = $myusername;
			$_SESSION['LOGIN_ERROR']     = $login_err;
			header("location:../index.php");
			exit();
		}
	}else {
		$logmessage = "Query failed $qry". mysql_error()."";
		createLogfile($logmessage, 12);		
	}	


?>