<?php
	session_start();
	
	require_once('../scripts/db_connect.php');
	$currYR			= date("Y");
	
	$Username		= $_POST['Username'];
	$Password		= $_POST['UserPwd'];
	$NewUserPwd		= $_POST['NewUserPwd'];
	$UserPwdConfirm	= $_POST['UserPwdConfirm'];
	$Email			= $_POST['Email'];
	$Department		= $_POST['Department'];
	$Position		= $_POST['Position'];
	$AdminFlag		= $_POST['EmpFlag'];
	
	$Updates = '';
	$error = 0;
	$Changes = 0;
	$oldPosition = $_SESSION['MEMBER_POST'];
	$oldEmail	 = $_SESSION['MEMBER_EMAIL'];
	$oldDepartment = $_SESSION['MEMBER_DEPT'];
	$oldAdminFlag	= $_SESSION['MEMBER_ADMFLG'];
	
	if ($Position != $oldPosition) {
		$Changes += 1;
		$Updates .= "=>Position from (".$oldPosition.") to (".$Position.")\n";
	}
	if ($Email != $oldEmail) {
		$Changes += 1;
		$Updates .= "=>Email from (".$oldEmail.") to (".$Email.")\n ";
	}
	if ($Department != $oldDepartment) {
		$Changes += 1;
		$Updates .= "=>Department from (".$oldDepartment.") to (".$Department.")\n";
	}	
	if ($AdminFlag != $oldAdminFlag) {
		$Changes += 1;
		$Updates .= "=>Admin Flag from (".$oldAdminFlag.") to (".$AdminFlag.")\n";
	}
	//Checking Password
	$qry="SELECT * FROM usrm WHERE username='$Username'";
	$result=mysql_query($qry);
	if ($result) {
		$userdtl = mysql_fetch_assoc($result);
		$oldPassword = $userdtl['password'];
		$inputPassword = md5($Password);
		echo $oldPassword. " -- ".$inputPassword;
		if ($oldPassword != $inputPassword) {
			$error += 1;
			echo "error == 'Invalid Password'";
			$update_error = 'Invalid Password';
			$_SESSION['MEMBER_USRNAME']	 = $myusername;
			$_SESSION['USER_ERROR']     = $update_error;
			header("location:../admin/userdtls.php?success=false");	
			exit();
		}
	} else {
		$logmessage = "Query failed!!! $result $qry";
		createLogfile($logmessage, 12);		
	}
	//Check Password Change
	if (isset($_POST['NewUserPwd']) && !empty($_POST['NewUserPwd'])) {
		if ($NewUserPwd != $UserPwdConfirm) {
			$error += 1;
			$update_error = 'Password Mismatch';
			$_SESSION['MEMBER_USRNAME']	 = $myusername;
			$_SESSION['USER_ERROR']     = $update_error;
			header("location:../admin/userdtls.php?success=false");
			exit();
		} else {
			$Password = $NewUserPwd;
			$Updates .= "=>Password Change\n";
		}
	}
	//update details
	$qry="update usrm set password = '".md5($Password)."', `emailadd` = '$Email' , `empdepartment` = '$Department', `empposition` = '$Position' , `adminflg` = '$AdminFlag' ";
	$qry .= "WHERE username='$Username'";
	$result=mysql_query($qry);
	if ($result) {
		header("location:../admin/userdtls.php?success=true");
	} else {
		$logmessage = "Query failed!!! $result $qry";
		createLogfile($logmessage, 12);		
	}
	$activity = "UPDATE PROFILE"; 
	$logdetails .= "Updates:\n".$Updates."";
    include('createlog.php');   	
	
	if ($error == 0) {
		header("location:../admin/userdtls.php?success=true");	
	}	

?>