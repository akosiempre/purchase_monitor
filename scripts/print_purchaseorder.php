<?php
error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Manila');

require_once 'phpexcel/Classes/PHPExcel.php';

//Borders
$bordersAllsides = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
 );

$bordersOutline = array(
      'borders' => array(
          'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
 );
 
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//Set PHPExcel Properties
$objPHPExcel->getProperties()->setCreator("$PurchaseHead")
							 ->setLastModifiedBy("$PurchaseHead")
							 ->setTitle("$CurrPOID")
							 ->setSubject("$CurrPOID")
							 ->setDescription("$CurrPOID Excel File")
							 ->setKeywords("$CurrPOID")
							 ->setCategory("$CurrPOID");
$cell_row = 9;

//Set Defaults
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(10);
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

//Set Purchase Order Logo
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../styles/images/po_logo.jpg');
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(100);
$objDrawing->setRotation(0);
$objDrawing->setHeight(180);
$objDrawing->setWidth(470);
$objDrawing->getShadow()->setVisible(false);
$objDrawing->getShadow()->setDirection(0);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//PO Number
$cell_row += 1;
$PurchaseNo = stripslashes($PurchaseNo);
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:E$cell_row"); 
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "No. $PurchaseNo");
//PO Number Formatting
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//PO Title
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:E$cell_row");
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "LOCAL PURCHASE REQUISITION");

//PO Title Formatting
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
$objPHPExcel->getActiveSheet()->getRowDimension("A$cell_row")->setRowHeight(20);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//PO Date
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:B$cell_row"); 
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");

//Bold Date Header
$objRichText = new PHPExcel_RichText();
$objBold = $objRichText->createTextRun("DATE: ");
$objBold->getFont()->setBold(true);
$objRichText->createText("$PrintDate");
$objPHPExcel->getActiveSheet()->getCell("C$cell_row")->setValue($objRichText);


//PO Date Formatting
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Century Gothic');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//Vendor
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:B$cell_row");
$VendorName = stripslashes(utf8_encode($VendorName));
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "VENDOR: $VendorName");

//Vendor Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:B$cell_row")->applyFromArray($bordersAllsides);

//Vendor Contact
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
$VendorContact = utf8_encode($VendorContact);
$objPHPExcel->getActiveSheet()->setCellValue("C$cell_row", "TEL#: $VendorContact");

//Vendor Contact Formatting
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row:E$cell_row")->applyFromArray($bordersAllsides);

//Address Header
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:B$cell_row");
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "ADDRESS:");

//Address Header  Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:B$cell_row")->applyFromArray($bordersAllsides);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


//Contact Person Header 
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
$objPHPExcel->getActiveSheet()->setCellValue("C$cell_row", "CONTACT PERSON:");

//Contact Person Formatting
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row:E$cell_row")->applyFromArray($bordersAllsides);

//Address Value 
$cell_row += 1;
$block_row = $cell_row + 1;
$VendorAddress = stripslashes($VendorAddress);
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:B$block_row");
$VendorAddress = utf8_encode($VendorAddress);
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "$VendorAddress");

//Address Value  Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:B$cell_row")->applyFromArray($bordersAllsides);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

//Contact Value
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");

$VendorPerson = stripslashes(utf8_encode($VendorPerson));
$objPHPExcel->getActiveSheet()->setCellValue("C$cell_row", "$VendorPerson");

//Contact Value  Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->applyFromArray($bordersAllsides);

//Terms Header
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
//Bold Terms Header
$objRichText = new PHPExcel_RichText();
$objBold = $objRichText->createTextRun("TERMS: ");
$objBold->getFont()->setBold(true);
$VendorTerms = utf8_encode($VendorTerms);
$objRichText->createText("$VendorTerms");
$objPHPExcel->getActiveSheet()->getCell("C$cell_row")->setValue($objRichText);

//Terms Header  Formatting
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C$cell_row:E$cell_row")->applyFromArray($bordersAllsides);



//Include PO Details Header
$cell_row += 1;
$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A$cell_row", "ITEM")
				->setCellValue("B$cell_row", "DESCRIPTION")
				->setCellValue("C$cell_row", "QTY")
				->setCellValue("D$cell_row", "PRICE")
				->setCellValue("E$cell_row", "AMOUNT");

//Header Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->applyFromArray($bordersAllsides);
							 
//Include PO Details Items
for ($i=0;$i<$detail_rows;$i++) {
	$cell_row += 1;
	$itemname[$i]  = stripslashes(utf8_encode($itemname[$i]));
	$itemnotes[$i] = stripslashes(utf8_encode($itemnotes[$i]));
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A$cell_row", "$itemname[$i]")
				->setCellValue("B$cell_row", "$itemnotes[$i]")
				->setCellValue("C$cell_row", "$itemqty[$i]")
				->setCellValue("D$cell_row", "$itemprice[$i]")
				->setCellValue("E$cell_row", "$itemtotamt[$i]");
	//Details Formatting
	//$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getAlignment()->setShrinkToFit(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getStyle("B$cell_row")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->applyFromArray($bordersAllsides);
	$objPHPExcel->getActiveSheet()->getStyle("D$cell_row:E$cell_row")->getNumberFormat()->setFormatCode('#,##0.00'); 
	$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
	$objPHPExcel->getActiveSheet()->getStyle("B$cell_row:C$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

//Include Total Amount
$cell_row += 1;
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "TOTAL: ")
			->setCellValue("E$cell_row", "$GrandTotal");
//Total Amount Formatting
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:D$cell_row");			
$objPHPExcel->getActiveSheet()->getStyle("E$cell_row")->getNumberFormat()->setFormatCode('#,##0.00'); 
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(12);				
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->applyFromArray($bordersAllsides);


//Include Remarks
//Remarks Header
$cell_row += 1;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$cell_row", "REMARKS:");
//Header Format
$objPHPExcel->getActiveSheet()->getRowDimension("$cell_row")->setRowHeight(20);
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:E$cell_row");			
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(18);				
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);

//Remarks Value
preg_match_all("/(\n)/", $ItemMainNotes, $matches);
$total_lines = count($matches[0]) + 1;
if ($total_lines == 1) {
	$length = strlen(trim($ItemMainNotes));
	$total_lines += floor($length / 80);
}
$cell_row += 1;
$block_row = $cell_row + $total_lines;
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:E$block_row");
$ItemMainNotes = stripslashes(utf8_encode($ItemMainNotes));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$cell_row", "$ItemMainNotes");
//remarks format
$from_row = $cell_row - 1;
$objPHPExcel->getActiveSheet()->getRowDimension("A$cell_row:A$block_row")->setRowHeight(-1);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:A$block_row")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle("A$from_row:E$block_row")->applyFromArray($bordersOutline);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

//add used block to the total rows
$cell_row += $total_lines;

//Increase Spaces for signatories
$cell_row += 2;

//Include Salutation Header
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "Prepared By:")
			->setCellValue("B$cell_row", "Noted By:")
			->setCellValue("C$cell_row", "Approved By:");

//Salutation Header Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(11);	
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$cell_row += 1;

//Include Salutation
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
$PurchaseHead = stripslashes(utf8_encode($PurchaseHead));
$DepartmentHead = stripslashes(utf8_encode($DepartmentHead));
$HeadManager = stripslashes(utf8_encode($HeadManager));
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "  $PurchaseHead  ")
			->setCellValue("B$cell_row", "  $DepartmentHead  ")
			->setCellValue("C$cell_row", "  $HeadManager  ");

//Salutation Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setUnderline(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//Name Titles
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "SIGNATURE OVER PRINTED NAME")
			->setCellValue("B$cell_row", "SIGNATURE OVER PRINTED NAME")
			->setCellValue("C$cell_row", "SIGNATURE OVER PRINTED NAME");

//Name Titles Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(5);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

//For Footer
$cell_row += 2;
$objPHPExcel->getActiveSheet()->getStyle("A1:E$cell_row")->applyFromArray($bordersOutline);

//Set Worksheet Title
$objPHPExcel->getActiveSheet()->setTitle("PO $PurchaseNo");

//Create Report Directory
$structure = "../reports/$CurrPOID";
if (!dir($structure)) {
	if (!mkdir($structure, 0777, true)) {
		$logmessage = "Failed to create folder $CurrPOID..."; 
		createLogfile($logmessage, 12); 	
	}
}

//Write to File
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("$structure/$CurrPOID.xlsx");
?>
