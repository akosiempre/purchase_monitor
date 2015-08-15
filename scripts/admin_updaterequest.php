<?php
	session_start();
	
	require_once('../scripts/db_connect.php');
	include('../global/global_signatories.php');
	$PurchaseHead = $_SESSION['PURCHASE_HEAD'];
	$HeadManager = $_SESSION['MANAGING_HEAD'];	
	
	//Retrieve Old Values for Update of Printout
	$RequestItem	= trim($_POST['ItemName']);
	$RequestItem	= addslashes($RequestItem);	
	$RequestBy		= trim($_POST['RequesterName']);
	$RequestBy		= addslashes($RequestBy);			
	$DepartmentHead = trim($_POST['RequesterHead']);
	$DepartmentHead	= addslashes($DepartmentHead);		
	$PostDate 		= date("Y-m-d");
	$ItemStat		= 1;
	$GrandTotal		= trim($_POST['GrandTotal']);
	$GrandTotal		= str_replace( ',', '', $GrandTotal );
	$ItemMainNotes	= trim($_POST['ItemMainNotes']);
	$ItemMainNotes	= addslashes($ItemMainNotes);		
	
	$VendorName		= trim($_POST['VendorName']);
	$VendorName		= addslashes($VendorName);
	$VendorTIN		= trim($_POST['VendorTIN']);
	$VendorTerms	= trim($_POST['VendorTerms']);
	$VendorAddress	= trim($_POST['VendorAddress']);
	$VendorAddress	= addslashes($VendorAddress);
	$VendorPerson	= trim($_POST['VendorPerson']);
	$VendorPerson	= addslashes($VendorPerson);
	$VendorContact	= trim($_POST['VendorContact']);
	
	//RQSD VALUES
	$itemname 		= $_POST['itemname'];
	$itemname		= array_map('trim',$itemname);
	$itemnotes 		= $_POST['itemnotes'];
	$itemnotes		= array_map('trim',$itemnotes);
	$itemqty 		= $_POST['itemqty'];
	$itemqty		= array_map('trim',$itemqty);
	$itemprice 		= $_POST['itemprice'];
	$itemprice		= array_map('trim',$itemprice);
	$itemtotamt 	= $_POST['itemtotamt'];
	$itemtotamt		= array_map('trim',$itemtotamt);
	$detail_rows 	= count($_POST['itemname']);	
		
	//Updated Values
	$CurrPOID		= $_POST['ItemPOID'];
	$PODate			= explode('-',$_SESSION['RQSM_DATE']);
	$POYear			= $PODate[0];
	$PrintDate		= date("F d, Y", strtotime($_SESSION['RQSM_DATE']));
	$POreqid		= $_SESSION['RQSM_REQID'];
	$PurchaseNo		= "$POYear - $POreqid ($RequestBy)";	
	$PO_stat		= $_POST['ItemStat'];
	$ItemRemarks	= $_POST['ItemMainNotes'];
	$oldStat		= $_SESSION['RQSM_STAT_VAL'];
	$oldNotes		= $_SESSION['RQSM_NOTES'];
	$Updates = '';
	
	
	if ($PO_stat != $oldStat) {
		switch ($PO_stat) {
			case 1:
				$PO_statVal = "Done" ;
				break;
			case 8:
				$PO_statVal = "Disapproved" ;
				break;
			case 9:
				$PO_statVal = "Cancelled";
				break;
		}
		switch ($oldStat) {
			case 1:
				$oldStatVal = "Done" ;
				break;
			case 8:
				$oldStatVal = "Disapproved" ;
				break;
			case 9:
				$oldStatVal = "Cancelled";
				break;
		}		
		$Updates .= "=>Stat from (".$oldStatVal.") to (".$PO_statVal.");\n";
	}
	if ($ItemRemarks != $oldNotes) {
		$Updates .= "=>Remarks from ('".$oldNotes."') to ('".$ItemRemarks."');\n";
	}
	
	$rqsm_qry = "UPDATE `rqsm` set `status` = '$PO_stat', `notes` = '".addslashes($ItemRemarks)."' where po_id = '$CurrPOID';";
	$rqsm_result=mysql_query($rqsm_qry);
	
	if (!$rqsm_result) {
		$logmessage = "Query Failed!! error:".mysql_error()." - $rqsm_qry ";
		createLogfile($logmessage, 12);					
	} else {
		$_SESSION['RQSM_QUERY'] = $rqsm_qry;
		$_SESSION['RQSM_STAT'] = $PO_stat;
		switch ($_SESSION['RQSM_STAT']) {
			case 0:
				$_SESSION['RQSM_STAT'] = "New";
				$_SESSION['RQSM_STAT_VAL'] = "0";
				break;
			case 1:
				$_SESSION['RQSM_STAT'] = "Done";
				$_SESSION['RQSM_STAT_VAL'] = "1";
				$_SESSION['RQSM_STAT_X1'] = "Disapproved";
				$_SESSION['RQSM_STAT_X1VAL'] = "8";	
				$_SESSION['RQSM_STAT_X2'] = "Cancelled";
				$_SESSION['RQSM_STAT_X2VAL'] = "9";
				break;
			case 2:
				$_SESSION['RQSM_STAT'] = "For Approval";
				break;
			case 3:
				$_SESSION['RQSM_STAT'] = "Accounting";
				break;
			case 4:
				$_SESSION['RQSM_STAT'] = "Delivery/Pickup";
				break;
			case 5:
				$_SESSION['RQSM_STAT'] = "Finished";
				break;
			case 8:
				$_SESSION['RQSM_STAT'] = "Disapproved";
				$_SESSION['RQSM_STAT_VAL'] = "8";
				$_SESSION['RQSM_STAT_X1'] = "Done";
				$_SESSION['RQSM_STAT_X1VAL'] = "1";	
				$_SESSION['RQSM_STAT_X2'] = "Cancelled";
				$_SESSION['RQSM_STAT_X2VAL'] = "9";					
				break;				
			case 9:
				$_SESSION['RQSM_STAT'] = "Cancelled";
				$_SESSION['RQSM_STAT_VAL'] = "9";
				$_SESSION['RQSM_STAT_X1'] = "Done";
				$_SESSION['RQSM_STAT_X1VAL'] = "1";	
				$_SESSION['RQSM_STAT_X2'] = "Disapproved";
				$_SESSION['RQSM_STAT_X2VAL'] = "8";						
				break;
			default:
				$_SESSION['RQSM_STAT'] = "New";
		}
	}
	//upload file 
	$filename = $_FILES["attachedfile"]["name"];
	if ($filename != '') {
		$Updates .= "=>File uploaded: (".$filename.");\n";
		$tmpname  = $_FILES["attachedfile"]["tmp_name"];
		$directory = "../reports/$CurrPOID";
		if (!is_dir($directory)) {
			mkdir($directory);
		}
		if ($_FILES["attachedfile"]["error"] > 0) {
			$error = $_FILES["attachedfile"]["error"];
			$filename = $_FILES["attachedfile"]["name"];
			$logmessage = "Error in uploading: Error: $error $filename $CurrPOID";
			createLogfile($logmessage, 12);			
		} else {
			move_uploaded_file($tmpname,"$directory/$filename");
		} 
	}	
	//Recreate purchaseorder excel file
	$Updates .= "=>Reprint Purchase Order file\n";
	include ('print_purchaseorder.php');
	
	$RequestItem = $_SESSION['RQSM_ITEM'];
	$RequestBy = $_SESSION['RQSM_RQSTOR'];
	$VendorName = $_SESSION['RQSM_VENDOR'];
	$user = $_SESSION['MEMBER_USRNAME'];
	
	$activity = "UPDATE REQUEST"; 
	$logdetails  = "'".$CurrPOID."'\nItem: '".$RequestItem."'\nBy: '".$RequestBy."'\nVendor: '".$VendorName."'\n";
	$logdetails .= "Updates:\n".$Updates."";
    include('createlog.php');   
		
	header("location:../admin/itemdtls.php?success=true");


?>