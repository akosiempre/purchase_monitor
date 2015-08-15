<?php
	$perpage = 10;
	$tbl_name="rqsm";
	$qry="select count(*) as reqcount from rqsm where vendor = '".addslashes($vname)."'";
	$result=mysql_query($qry);
	$_SESSION['DASH_QRYTEST'] = $qry;
	if($result) {
		$reqcount = mysql_fetch_assoc($result);
		$_SESSION['RQSM_COUNT'] = $reqcount['reqcount'];
	}else {
		$logmessage = "Query failed!!! $result $qry $tbl_name";
		createLogfile($logmessage, 12);							
	};
	$records = $_SESSION['RQSM_COUNT'];
	$perpage = 10;
	$quotient = explode('.',($records / $perpage));
	$pages=$quotient[0];
	if ($records % $perpage !== 0) {
		$pages = $pages + 1;
	}	
	$_SESSION['DASH_ROWS'] = $pages;
//Sorting Order
	if (isset($_GET['order'])) {
		$orderby = $_GET['order'];
		switch ($orderby) {
			case "date":
				$sortkey = "rqsm.date" ;
				break;
			case "reqid":
				$sortkey = "rqsm.reqid" ;
				break;
			case "status":
				$sortkey = "rqsm.status";
				break;
		}
		$_SESSION['ORDERKEY'] = $sortkey;
	} else 
	if (isset($_SESSION['ORDERKEY'])) {
		$sortkey = $_SESSION['ORDERKEY'];
	} else 	{
		$sortkey = "rqsm.date";
	}
	if (isset($_GET['sort'])) {
		$sort_order =  $_GET['sort'];
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
		$_SESSION['SORT_ORDER'] = $sortby;
	} else 
	if (isset($_SESSION['SORT_ORDER'])) {
		$sortby = $_SESSION['SORT_ORDER'] ;
	} else {
		$sortby = "asc";
	}	
//Setting page number
	if (isset($_GET['page'])) {
		$pagenum   = $_GET['page'];
		$queryfrom = ($pagenum - 1);
		if ($pagenum == "prev") {
			$pagenum = $_SESSION['DASH_CURPAGE'] - 1;
		} else 
		if ($pagenum == "next") {
			$pagenum = $_SESSION['DASH_CURPAGE'] + 1;
		}
	} else {
		$pagenum = 1;
	}	
//Query
	$_SESSION['DASH_CURPAGE'] = $pagenum;
	$queryfrom = ($pagenum - 1) * $perpage;
	if ($queryfrom < 0) {
		$queryfrom = 0;
		$_SESSION['DASH_CURPAGE'] = 1;
	} else 
	if ($queryfrom > $records) {
		$queryfrom = $queryfrom - $perpage;
		$_SESSION['DASH_CURPAGE'] = $pages;
	}	
	$qry="SELECT  rqsm.reqid, rqsm.po_id, rqsm.date,  rqsm.item, rqsm.status from rqsm 
	      where vendor = '".addslashes($vname)."'
		  order by rqsm.reqid desc limit $queryfrom, 10";
		//  order by  $sortkey $sortby limit $queryfrom, 10";

	$result=mysql_query($qry);
	if($result) {
		$_SESSION['RQSM_ROWS'] = mysql_num_rows($result);
		$_SESSION['SESS_QRY'] = $qry;
	}else {
		$logmessage = "Query failed!!! $result $qry $tbl_name ";
		createLogfile($logmessage, 12);			
	};
	
?>