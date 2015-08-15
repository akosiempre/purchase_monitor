<?php
$vdrm = "select * from vdrm";
$vdrm_qry=mysql_query($vdrm);
$vendor_file = '../styles/js/vendor.link.js';
$handle = fopen($vendor_file, 'w');
if (!$handle) {
	$logmessage = "Cannot write file:  '.$vendor_file";
	createLogfile($logmessage, 12);	
}
$varlist = "var venpage = [ \n";
while ($vdritem = mysql_fetch_assoc($vdrm_qry)){
	$varlist .=  "\t{ value: '".addslashes($vdritem['vname'])."', ";
	$varlist .=  "link: 'vendordtls.php?vid=".$vdritem['vid']."' },\n";
}
$varlist .=  " ];\n";
fwrite($handle, $varlist);
?>