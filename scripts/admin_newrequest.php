<?php
	//Start session
	session_start();
	
	//Configure These Values !!!!
	include('../global/global_signatories.php');
	$PurchaseHead = $_SESSION['PURCHASE_HEAD'];
	$HeadManager = $_SESSION['MANAGING_HEAD'];
	

	require_once('../scripts/db_connect.php');

	//check last rqsm id
	$currYR			= date("Y");
	
	$rqsm_qry 		= "select coalesce(max(po_yearid),0) + 1 as yearid from rqsm where po_year = $currYR;";
	$result			= mysql_query($rqsm_qry);
	$return		 	= mysql_fetch_assoc($result);
	$po_id		 	= $return["yearid"];
	
	
	$_SESSION['ITEM'] = $_POST['ItemName'];
	$_SESSION['NAME'] = $_POST['RequesterName'];	
	$_SESSION['YEAR'] = $currYR;
	$_SESSION['PO_ID'] = $po_id;
	$_SESSION['result'] = $result;
	$_SESSION['RQSM_QUERY'] = $rqsm_qry;
	
	$CurrPOID		= "PO ".$currYR." - ".$po_id;
	$RequestItem	= trim($_POST['ItemName']);
	$RequestItem	= addslashes($RequestItem);	
	$RequestBy		= trim($_POST['RequesterName']);
	$RequestBy		= addslashes($RequestBy);			
	$DepartmentHead = trim($_POST['RequesterHead']);
	$DepartmentHead	= addslashes($DepartmentHead);		
	$PostDate 		= date("Y-m-d");
	$PrintDate 		= date("F d, Y");
	$ItemStat		= 1;
	$GrandTotal		= trim($_POST['GrandTotal']);
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

	//PO Number Value:
	$PurchaseNo		= "$currYR - $po_id ($RequestBy)";
	
	//Input Validations	
	$errflag = '';

	if ($RequestItem == '') {
		$errmsg = 'Item Name is Required';
		$errflag = true;
	}
	//If there are input validations, redirect back to the login form
	if ($errflag) {
		$_SESSION['SESS_ERROR']  = $errmsg_arr;
		session_write_close();
		header("location:../admin/newrequest.php?success=false");
		exit();
	}	
	
	
	$rqsm_qry  = "INSERT INTO `rqsm`(`po_year`, `po_yearid`, `po_id`, `date`, `item`, `requestor`, `requestor_name`, `amount`, `notes`, `vendor`, `vendor_tin`, `vendor_terms`, `vendor_address`, `vendor_contact`, `vendor_contactnum`, `status`) VALUES ";
	$rqsm_qry .= "('".$currYR."','".$po_id."','".$CurrPOID."','".$PostDate."','".$RequestItem."','".$RequestBy."','".$DepartmentHead."','".$GrandTotal."','".$ItemMainNotes."','".$VendorName."','".$VendorTIN."','".$VendorTerms."','".$VendorAddress."','".$VendorPerson."','".$VendorContact."','".$ItemStat."')";
	$rqsm_result=mysql_query($rqsm_qry);
	$rqsmpoid = mysql_insert_id();
	if (!$rqsm_result) {
		$logmessage = "Query failed!!! $rqsm_result $rqsm_qry";
		createLogfile($logmessage, 12);		
	}

	$_SESSION['RQSM_QUERY'] = $rqsm_qry;
	
	//RQSD INSERT
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


	//$rqsd_yes = "FALSE";
	$rqsd_qry = "INSERT INTO `rqsd` (`reqid`, `po_id`, `det_item`, `det_qty`, `det_price`, `det_totprice`, `det_notes`) VALUES ";
	for ($i=0;$i<$detail_rows;$i++) {
		$max_rows = $detail_rows - 1;
		if ($itemname[$i] != '') {
		//	$rqsd_yes = "TRUE";
			if ($itemqty[$i] == '') {
				$itemqty[$i]  = 0;
			}
			if ($itemprice[$i] == '') {
				$itemprice[$i]  = 0;
				$itemtotamt[$i] = 0;
			}			
			if ($i == $max_rows) {
				$rqsd_qry .= "( ".$rqsmpoid.",'".$CurrPOID."','".addslashes($itemname[$i])."', '".$itemqty[$i]."','".$itemprice[$i]."','".$itemtotamt[$i]."','".addslashes($itemnotes[$i])."');";
			} else {
				$rqsd_qry .= "( ".$rqsmpoid.",'".$CurrPOID."','".addslashes($itemname[$i])."', '".$itemqty[$i]."','".$itemprice[$i]."','".$itemtotamt[$i]."','".addslashes($itemnotes[$i])."'),";
			}			
		} else {
			$itemname[$i]   = $RequestItem;
			$itemqty[$i]    = 1;
			$itemprice[$i]  = $GrandTotal;
			$itemtotamt[$i] = $GrandTotal;
			$itemnotes[$i]  = $ItemMainNotes;
			$rqsd_qry .= "( ".$rqsmpoid.",'".$CurrPOID."','". $RequestItem ."', '1', '". $GrandTotal ."','".$GrandTotal."','".$ItemMainNotes."')";
		}	
	}
	$rqsd_result=mysql_query($rqsd_qry);
	$rqsd_id = mysql_insert_id();
	if (!$rqsd_result) {
		$logmessage = "Query failed!!! ".mysql_error()." $rqsd_qry";
		createLogfile($logmessage, 12);				
	}	
	$_SESSION['RQSD_QUERY'] = $rqsd_qry;
	
	//UPDATE VENDOR
	$updatevendor = 'off';
	if (isset($_POST['UpdateVendor'])) {
		$updatevendor = $_POST['UpdateVendor'];
	};	
	$vdrm_qry = "SELECT `vid` from `vdrm` where `vname` = '$VendorName'";
	$vdrm_result	= mysql_query($vdrm_qry);
	$vdrm_exists 	= mysql_fetch_assoc($vdrm_result);
	$vendor_id 		= $vdrm_exists['vid'];
	$update_venlist = 'off';
	if ($vdrm_exists == 0) {
		$vdrm_qry = "INSERT INTO `vdrm` (`vname`, `vaddress`, `vperson`, `vcontact`, `vtin`, `vmode`, `last_tran`) VALUES ";
		$vdrm_qry .= "( '".$VendorName."','". $VendorAddress ."', '".$VendorPerson."', '". $VendorContact ."','".$VendorTIN."','".$VendorTerms."','".$PostDate."' ) ";
		$update_venlist = 'on';
	} else if ($updatevendor == 'on') {
		$vdrm_qry = "UPDATE `vdrm` set `vname` = '$VendorName',`vaddress` = '$VendorAddress',`vperson` = '$VendorPerson', `vcontact` = '$VendorContact', `vtin` = '$VendorTIN', `vmode` = '$VendorTerms', `last_tran` = '$PostDate' ";
		$vdrm_qry .= "where `vid` = $vendor_id ";
		$update_venlist = 'on';
	} else {
		$vdrm_qry = "UPDATE `vdrm` set `last_tran` = '$PostDate' ";
		$vdrm_qry .= "where `vid` = $vendor_id ";
	}
	$vdrm_result=mysql_query($vdrm_qry);
	$vdrm_id = mysql_insert_id();
	if (!$vdrm_result) {
		$logmessage = "Query failed!!! $vdrm_result $vdrm_qry";
		createLogfile($logmessage, 12);				
	}
	if ($update_venlist == 'on') {
		include ('vendorlist_update.php');
		include ('vendorlink_update.php');
	}
	include ('print_purchaseorder.php');
	$dept_new = $_POST['dept_check'];
	$name_new = $_POST['name_check'];
	if ($dept_new = 'off' || $name_new = 'off') {
		include('deptlist_update.php');
	}
	$user = $_SESSION['MEMBER_USRNAME'];
	$activity = "NEW REQUEST"; 
	$RequestItem		= str_replace( '\\', '', $RequestItem );
	$RequestBy		= str_replace( '\\', '', $RequestBy );
	$VendorName		= str_replace( '\\', '', $VendorName );
	$logdetails  = "'".$CurrPOID."'\nItem: '".$RequestItem."'\nBy: '".$RequestBy."'\nVendor: '".$VendorName."'\n";
    include('createlog.php');   
	
	header("location:../admin/newrequest.php?success=true");
	
?>