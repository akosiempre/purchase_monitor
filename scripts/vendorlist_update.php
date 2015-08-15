<?php
$vdrm = "select * from vdrm";
$vdrm_qry=mysql_query($vdrm);
$vendor_file = '../styles/js/vendor.list.js';
$handle = fopen($vendor_file, 'w');
if (!$handle) {
	$logmessage = "Cannot write file:  '.$vendor_file";
	createLogfile($logmessage, 12);	
}
$varlist = "var vendors = [ \n";
while ($vdritem = mysql_fetch_assoc($vdrm_qry)){
	$varlist .=  "\t{ value: '".addslashes($vdritem['vname'])."', ";
	$varlist .=  "person: '".addslashes($vdritem['vperson'])."',";
	$varlist .=  "address: '".addslashes($vdritem['vaddress'])."',";
	$varlist .=  "contact: '".addslashes($vdritem['vcontact'])."',";
	$varlist .=  "vtin: '".addslashes($vdritem['vtin'])."',";
	$varlist .=  "vmode: '".addslashes($vdritem['vmode'])."',";
	$varlist .=  "type: '".addslashes($vdritem['buss_type'])."',";
	$varlist .=  "notes: '".addslashes($vdritem['notes'])."' },\n";
	}
$varlist .=  " ];\n";
fwrite($handle, $varlist);
?>