<?php 
/*
 * Module:      process_judging_bos.inc.php
 * Description: This module does all the heavy lifting for adding/editing info in the "judging_scores_bos" table
 */

if ($action == "enter") {
	foreach($_POST['score_id'] as $score_id)	{
	if ($_POST['scorePrevious'.$score_id] == "Y") {
	$updateSQL = sprintf("UPDATE $judging_scores_bos_db_table SET
	eid=%s,
	bid=%s,
	scoreEntry=%s,
	scorePlace=%s,
	scoreType=%s
	WHERE id=%s",
                       GetSQLValueString($_POST['eid'.$score_id], "text"),
					   GetSQLValueString($_POST['bid'.$score_id], "text"),
					   GetSQLValueString($_POST['scoreEntry'.$score_id], "text"),
					   GetSQLValueString($_POST['scorePlace'.$score_id], "text"),
					   GetSQLValueString($_POST['scoreType'.$score_id], "text"),
					   GetSQLValueString($_POST['id'.$score_id], "text")
					   );

	//echo $updateSQL."<br>";
	mysql_select_db($database, $brewing);
  	$Result1 = mysql_query($updateSQL, $brewing) or die(mysql_error());
	}
	if (($_POST['scorePlace'.$score_id] != "") && ($_POST['scorePrevious'.$score_id] == "N")) {
	$insertSQL = sprintf("INSERT INTO $judging_scores_bos_db_table (
	eid, 
	bid, 
	scoreEntry,
	scorePlace,
	scoreType
  	) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['eid'.$score_id], "text"),
					   GetSQLValueString($_POST['bid'.$score_id], "text"),
					   GetSQLValueString($_POST['scoreEntry'.$score_id], "text"),
					   GetSQLValueString($_POST['scorePlace'.$score_id], "text"),
					   GetSQLValueString($_POST['scoreType'.$score_id], "text")
					   );

	//echo $insertSQL."<br>";
	mysql_select_db($database, $brewing);
  	$Result1 = mysql_query($insertSQL, $brewing) or die(mysql_error());		
		}
	}
	header(sprintf("Location: %s", $updateGoTo));
}

?>