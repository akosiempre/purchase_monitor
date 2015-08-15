<?php

	session_start();
	
	//Configure These Values !!!!
	require_once('../scripts/db_connect.php');

$team = array ();

$rqsm = "select distinct requestor as dept from rqsm order by requestor;";
$rqsm_qry=mysql_query($rqsm);
$team_file = '../styles/js/team.list.js';
$handle = fopen($team_file, 'w');
if (!$handle) {
	$logmessage = "Cannot open file:  '.$team_file";
	createLogfile($logmessage, 12);	
}
$varlist = "var dept = [ \n";
while ($deptitem = mysql_fetch_assoc($rqsm_qry)){
	$varlist .=  "\t \"".addslashes($deptitem['dept'])."\",\n ";
	array_push($team,addslashes($deptitem['dept']));
	}
$varlist .=  "];\n\n";
fwrite($handle, $varlist);
$teamcount=count($team);
print_r ($team);
for ($i=0;$i<$teamcount;$i++) {
	$deptname = $team[$i];
	$nameqry = "select distinct requestor_name as name from rqsm where requestor = '$deptname' order by requestor_name;";
	$name_qry=mysql_query($nameqry);
	$handle = fopen($team_file, 'a');
	if (!$handle) {
		$logmessage = "Cannot open file:  '.$team_file";
		createLogfile($logmessage, 12);	
	}
	$varlist = "var $team[$i] = [ \n";	
	while ($teamitem = mysql_fetch_assoc($name_qry)){
		$varlist .=  "\t \"".addslashes($teamitem['name'])."\",\n ";
		}
	$varlist .=  "];\n\n";
	fwrite($handle, $varlist);
}

?>