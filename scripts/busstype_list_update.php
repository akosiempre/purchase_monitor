<?php
$vdrm = "select distinct buss_type as type from vdrm where buss_type <> '' order by buss_type";
$vdrm_qry=mysql_query($vdrm);
$vendor_file = '../styles/js/busstype.list.js';
$handle = fopen($vendor_file, 'w');
if (!$handle) {
	$logmessage = "Cannot open file:  '.$vendor_file";
	createLogfile($logmessage, 12);	
}	
$varlist = "var busstype = [ \n";
while ($vdritem = mysql_fetch_assoc($vdrm_qry)){
	$varlist .=  "\t \"".addslashes($vdritem['type'])."\",\n";
	}
$varlist .=  " ];\n";
fwrite($handle, $varlist);
?>