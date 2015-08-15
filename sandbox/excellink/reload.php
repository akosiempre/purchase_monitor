<?php
// Load your PHPExcel class
require_once 'classes/PHPExcel/Classes/PHPExcel.php';

// Set variables for file location and type to make code more portable and 
// less memory intensive
$file = '/tmp/ac.xlsx';
$file_type = 'Excel2007';

// Open file for reading
$objReader = PHPExcel_IOFactory::createReader($file_type);

// Take all exisiting worksheets in open file and place their names into an array
$worksheet_names = $objReader->listWorksheetNames($file);

// Array of worksheet names that should be editable
$editable_worksheets = array('activity', 'store');

// You will need to load ALL worksheets if you intend on saving to the same 
// file name, so we will pass setLoadSheetsOnly() the array of worksheet names 
// we just created.
$objReader->setLoadSheetsOnly($worksheet_names);

// Load the file
$objPHPExcel = $objReader->load($file);

// Loop through each worksheet in $worksheet_names array
foreach($worksheet_names as $worksheet_name) {

    // Only edit the worksheets with names we've allowed in  
    // the $editable_worksheets array
if(in_array($worksheet_name, $editable_worksheets)) {
        // Take each sheet, one at a time, and set it as the active sheet
        $objPHPExcel->setActiveSheetIndexByName($worksheet_name);

        // Grab the sheet you just made active
        $sheet = $objPHPExcel->getActiveSheet();

        // Grab the highest row from the current active sheet
        $max_row = $sheet->getHighestRow();

        // Set the value of column "A" in the last row to the text "Data"
        $sheet->setCellValue("A" . $max_row, "Data");

    }

    // Foreach loop will repeat until all sheets in the workbook have been looped
    // through
}

// Unset variables to free up memory
unset($worksheet_names, $worksheet_name, $sheet, $max_row);

// Prepare to write a new file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $file_type);

// Tell excel not to precalculate any formulas
$objWriter->setPreCalculateFormulas(false);

// Save the file
$objWriter->save($file);

// This must be called before unsetting to prevent memory leaks
$objPHPExcel->disconnectWorksheets();

// Again, unset variables to free up memory
unset($file, $file_type, $objReader, $objPHPExcel);

?>