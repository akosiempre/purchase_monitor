<?php
	$perpage = 10;
	$tbl_name="syslog";
	$qry="select count(*) as logcount from $tbl_name";
	$result=mysql_query($qry);
	$_SESSION['LOGS_QRYTEST'] = $qry;
	if($result) {
		$logs_count = mysql_fetch_assoc($result);
		$_SESSION['LOGS_COUNT'] = $logs_count['logcount'];
	}else {
		$logmessage = "Query failed $qry". mysql_error()." - $result $qry $tbl_name";
		createLogfile($logmessage, 12);			
	};
	$records = $_SESSION['LOGS_COUNT'];
	$perpage = 10;
	$quotient = explode('.',($records / $perpage));
	$pages=$quotient[0];
	if ($records % $perpage !== 0) {
		$pages = $pages + 1;
	}	
	$_SESSION['LOGS_ROWS'] = $pages;
//Sorting Order
	if (isset($_GET['lorder'])) {
		$orderby = $_GET['lorder'];
		switch ($orderby) {
			case "date":
				$sortkey = "syslog.log_date" ;
				break;
			case "logid":
				$sortkey = "syslog.log_id" ;
				break;
			case "type":
				$sortkey = "syslog.log_activity";
				break;
			case "user":
				$sortkey = "syslog.log_user";
				break;				
		}
		$_SESSION['LOG_ORDERKEY'] = $sortkey;
	} else 
	if (isset($_SESSION['LOG_ORDERKEY'])) {
		$sortkey = $_SESSION['LOG_ORDERKEY'];
	} else 	{
		$sortkey = "syslog.log_date";
	}
	if (isset($_GET['lsort'])) {
		$sort_order =  $_GET['lsort'];
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
		$_SESSION['LOG_SORT_ORDER'] = $sortby;
	} else 
	if (isset($_SESSION['LOG_SORT_ORDER'])) {
		$sortby = $_SESSION['LOG_SORT_ORDER'] ;
	} else {
		$sortby = "desc";
	}	
//Setting page number
	if (isset($_GET['logpage'])) {
		$pagenum   = $_GET['logpage'];
		$queryfrom = ($pagenum - 1);
		if ($pagenum == "prev") {
			$pagenum = $_SESSION['LOGS_CURPAGE'] - 1;
		} else 
		if ($pagenum == "next") {
			$pagenum = $_SESSION['LOGS_CURPAGE'] + 1;
		}
	} else {
		$pagenum = 1;
	}	
//Query
	$_SESSION['LOGS_CURPAGE'] = $pagenum;
	$queryfrom = ($pagenum - 1) * $perpage;
	if ($queryfrom < 0) {
		$queryfrom = 0;
		$_SESSION['LOGS_CURPAGE'] = 1;
	} else 
	if ($queryfrom > $records) {
		$queryfrom = $queryfrom - $perpage;
		$_SESSION['LOGS_CURPAGE'] = $pages;
	}	
	$qry = "SELECT syslog.log_id, syslog.log_date, syslog.log_activity, syslog.log_user, syslog.log_dtls from syslog ";
	$qry .= " order by  $sortkey $sortby limit $queryfrom, 10";

	$result=mysql_query($qry);
	if($result) {
		$_SESSION['SYSLOG_ROWS'] = mysql_num_rows($result);
		$_SESSION['SESS_QRY'] = $qry;
	}else {
		$logmessage = "Query failed $qry". mysql_error()." - $result $qry $tbl_name";
		createLogfile($logmessage, 12);					
	};
?>