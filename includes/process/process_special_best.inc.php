<?php 
/*
 * Module:      process_special_best_info.inc.php
 * Description: This module does all the heavy lifting for adding/editing info in the "special_best_info" table
 */

if ($action == "add") {
	$insertSQL = sprintf("INSERT INTO $special_best_info_db_table (sbi_name, sbi_description, sbi_places, sbi_rank) VALUES (%s, %s, %s, %s)",
					   GetSQLValueString(capitalize($_POST['sbi_name']), "text"),
					   GetSQLValueString($_POST['sbi_description'], "text"),
					   GetSQLValueString($_POST['sbi_places'], "int"),
					   GetSQLValueString($_POST['sbi_rank'], "int")
					   );

	mysql_select_db($database, $brewing);
	$Result1 = mysql_query($insertSQL, $brewing) or die(mysql_error());
	header(sprintf("Location: %s", $insertGoTo));					   
}

if ($action == "edit") {
	$updateSQL = sprintf("UPDATE $special_best_info_db_table SET sbi_name=%s, sbi_description=%s, sbi_places=%s, sbi_rank=%s WHERE id=%s",
					   GetSQLValueString(capitalize($_POST['sbi_name']), "text"),
					   GetSQLValueString($_POST['sbi_description'], "text"),
					   GetSQLValueString($_POST['sbi_places'], "int"),
					   GetSQLValueString($_POST['sbi_rank'], "int"),
					   GetSQLValueString($id, "int"));

	mysql_select_db($database, $brewing);
	$Result1 = mysql_query($updateSQL, $brewing) or die(mysql_error());
	header(sprintf("Location: %s", $updateGoTo));					   
}


?>