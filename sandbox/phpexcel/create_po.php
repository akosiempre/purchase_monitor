<?php

//TEMP FILES
$PurchaseHead = 'Jenny Z. Enriquez';
$DepartmentHead = 'Poncio Pilato';
$HeadManager = 'Jeremy Tan';

$po_id = "999";
$currYR = "2014";
$itemname = array("Monitor", "Keyboard", "Mouse", "Headset");
$itemnotes = array("LG 22 Inches", "Logitech Wireless", "A4 Tech", "Pioneer");
$itemqty = array("1", "3", "3", "3");
$itemprice = array("500", "250", "350", "200");
$itemtotamt = array("500", "750", "1150", "600");


$CurrPOID		= "PO ".$currYR." - ".$po_id;
$RequestItem	= "Computer Parts";
$RequestBy = "MIS";
$PostDate 		= date("Y-m-d");
$PrintDate 		= date("F d, Y");
$ItemStat		= 1;
$GrandTotal		= "3000.00";
$ItemMainNotes	= "For New Hires";
$detail_rows 	= count($itemnotes);

$VendorName		= "PC Workx";
$VendorTIN		= "155-453-999";
$VendorTerms	= "COD";
$VendorAddress	= "No 8 Tangali Quezon City";
$VendorPerson	= "Arnulfo Balawis";
$VendorContact	= "9559966/5542233";

//TEMP FILES

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
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
$objDrawing->setPath('./images/po_logo.jpg');
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
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:E$cell_row");							 
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "No. $currYR - $po_id($RequestBy)");
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
//$objPHPExcel->getActiveSheet()->getColumnDimension('')->setWidth(12);

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
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "VENDOR: $VendorName");

//Vendor Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:B$cell_row")->applyFromArray($bordersAllsides);

//Vendor Contact
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
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
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:B$block_row");
$objPHPExcel->getActiveSheet()->setCellValue("A$cell_row", "$VendorAddress");

//Address Value  Formatting
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row")->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:B$cell_row")->applyFromArray($bordersAllsides);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);

//Contact Value
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
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
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A$cell_row", "$itemname[$i]")
				->setCellValue("B$cell_row", "$itemnotes[$i]")
				->setCellValue("C$cell_row", "$itemqty[$i]")
				->setCellValue("D$cell_row", "$itemprice[$i]")
				->setCellValue("E$cell_row", "$itemtotamt[$i]");
	//Details Formatting
	$objPHPExcel->getActiveSheet()
				->getStyle("A$cell_row:E$cell_row")->getAlignment()->setShrinkToFit(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->applyFromArray($bordersAllsides);
	echo "$itemname[$i]\n";
}

//Include Total Amount
$cell_row += 1;
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "TOTAL: ")
			->setCellValue("E$cell_row", "$GrandTotal");
//Total Amount Formatting
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:D$cell_row");			
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(12);				
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->applyFromArray($bordersAllsides);
						 
//Include Remarks
//Remarks Header
$cell_row += 1;
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "REMARKS:");
//Header Format
$objPHPExcel->getActiveSheet()->getRowDimension("$cell_row")->setRowHeight(20);
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:E$cell_row");			
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(18);				
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);

//Remarks Value			
$cell_row += 1;
$block_row = $cell_row + 1;
$objPHPExcel->getActiveSheet()->mergeCells("A$cell_row:E$block_row");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "$ItemMainNotes");
//remarks format
$from_row = $cell_row - 1;
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(11);				
$objPHPExcel->getActiveSheet()->getStyle("A$from_row:E$block_row")->applyFromArray($bordersOutline);
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:D$cell_row")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
			
//Increase Spaces
$cell_row += 3;

//Include Salutation Header			
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A$cell_row", "Prepared By:")
			->setCellValue("B$cell_row", "Noted By:")
			->setCellValue("C$cell_row", "Approved By:");

//add space
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setSize(11);	
$objPHPExcel->getActiveSheet()->getStyle("A$cell_row:E$cell_row")->getFont()->setBold(true);
$cell_row += 1;

//Include Salutation
$cell_row += 1;
$objPHPExcel->getActiveSheet()->mergeCells("C$cell_row:E$cell_row");
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

//For Footer
$cell_row += 2;
$objPHPExcel->getActiveSheet()->getStyle("A1:E$cell_row")->applyFromArray($bordersOutline);


//Set Worksheet Title
$objPHPExcel->getActiveSheet()->setTitle("$CurrPOID");

//Write to File
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("$CurrPOID.xlsx");
?>
