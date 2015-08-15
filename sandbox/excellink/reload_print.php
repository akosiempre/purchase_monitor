<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Manila');

$DIR = './reports';
// Returns array of files
$files = scandir($DIR);

// Count number of files and store them to variable..
$num_files = count($files) - 2;
echo "now doing PO number  ".($num_files + 1)."<BR>";
echo "START PROCESS"."<BR>";
	require_once('../../global/config.php');	

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
	
	
/** Include PHPExcel_IOFactory */
require_once './Classes/PHPExcel/IOFactory.php';

$rqsm_qry 		= "select po_id, requestor from rqsm where reqid > $num_files";
$result			= mysql_query($rqsm_qry);
//$return		 	= mysql_fetch_assoc($result);
echo $rqsm_qry."<BR>";	
if (!result) {
	die("Error in query");
}
while ($return = mysql_fetch_assoc($result)){
	$CurrPOID  = $return['po_id'];
	$RequestBy = $return['requestor'];

	if (!file_exists("Purchase Order 2013.xlsx")) {
		exit("Missing File");
	}

	$inputFileType = 'Excel2007'; 
	$inputFileName = 'Purchase Order 2013.xlsx'; 
	$sheetname = "$CurrPOID ($RequestBy)"; 
	echo date('H:i:s') , " Load workbook $inputFileName from Excel7 file<BR>";

	echo date('H:i:s') , " Load worksheet $sheetname<BR> ";
	$objPHPExcel = new PHPExcel();
	$objReader  = PHPExcel_IOFactory::createReader($inputFileType); 
	$objReader ->setLoadSheetsOnly($sheetname); 
	$objPHPExcel = $objReader->load($inputFileName); 

	echo date('H:i:s') , " Load workbook from Excel5 file<BR>";
	$structure = "./reports/$CurrPOID";
	if (!mkdir($structure, 0777, true)) {
		die("cannot create flat file");
	}

	//Write to File
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("$structure/$CurrPOID.xlsx");
}
