<?php
	$perpage = 10;
	$tbl_name="rqsm";
	$qry="select count(*) as vdrcount from vdrm";
	$result=mysql_query($qry);
	$_SESSION['DASH_QRYTEST'] = $qry;
	if($result) {
		$reqcount = mysql_fetch_assoc($result);
		$_SESSION['VDRM_COUNT'] = $reqcount['vdrcount'];
	}else {
		$logmessage = "Query failed $qry". mysql_error()." - $result $qry $tbl_name";
		createLogfile($logmessage, 12);			
	};
	$records = $_SESSION['VDRM_COUNT'];
	$perpage = 10;
	$quotient = explode('.',($records / $perpage));
	$pages=$quotient[0];
	if ($records % $perpage !== 0) {
		$pages = $pages + 1;
	}	
	$_SESSION['VNDR_ROWS'] = $pages;
//Sorting Order
	if (isset($_GET['vorder'])) {
		$orderby = $_GET['vorder'];
		switch ($orderby) {
			case "date":
				$sortkey = "vdrm.po_date" ;
				break;
			case "vid":
				$sortkey = "vdrm.vid" ;
				break;
			case "type":
				$sortkey = "vdrm.buss_type";
				break;
			case "last_tran":
				$sortkey = "vdrm.last_tran";
				break;				
		}
		$_SESSION['VEN_ORDERKEY'] = $sortkey;
	} else 
	if (isset($_SESSION['VEN_ORDERKEY'])) {
		$sortkey = $_SESSION['VEN_ORDERKEY'];
	} else 	{
		$sortkey = "vdrm.vid";
	}
	if (isset($_GET['vsort'])) {
		$sort_order =  $_GET['vsort'];
		switch ($sort_order) {
			case "":
				$sortby = "desc" ;
				break;
			case "desc":
				$sortby = "asc" ;
				break;
			case "asc":
				$sortby = "desc" ;
				break;				
			default:
		}	
		$_SESSION['VEN_SORT_ORDER'] = $sortby;
	} else 
	if (isset($_SESSION['VEN_SORT_ORDER'])) {
		$sortby = $_SESSION['VEN_SORT_ORDER'] ;
	} else {
		$sortby = "desc";
	}	
//Setting page number
	if (isset($_GET['venpage'])) {
		$pagenum   = $_GET['venpage'];
		$queryfrom = ($pagenum - 1);
		if ($pagenum == "prev") {
			$pagenum = $_SESSION['VNDR_CURPAGE'] - 1;
		} else 
		if ($pagenum == "next") {
			$pagenum = $_SESSION['VNDR_CURPAGE'] + 1;
		}
	} else {
		$pagenum = 1;
	}	
//Query
	$_SESSION['VNDR_CURPAGE'] = $pagenum;
	$queryfrom = ($pagenum - 1) * $perpage;
	if ($queryfrom < 0) {
		$queryfrom = 0;
		$_SESSION['VNDR_CURPAGE'] = 1;
	} else 
	if ($queryfrom > $records) {
		$queryfrom = $queryfrom - $perpage;
		$_SESSION['VNDR_CURPAGE'] = $pages;
	}	
	$qry="SELECT  vdrm.vid, vdrm.vname, vdrm.buss_type,  vdrm.last_tran from vdrm 
		  order by  $sortkey $sortby limit $queryfrom, 10";

	$result=mysql_query($qry);
	if($result) {
		$_SESSION['VDRM_ROWS'] = mysql_num_rows($result);
		$_SESSION['SESS_QRY'] = $qry;
	}else {
		$logmessage = "Query failed $qry". mysql_error()." - $result $qry $tbl_name";
		createLogfile($logmessage, 12);					
	};
?>