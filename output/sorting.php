<?php 
session_start(); 
require('../paths.php'); 
require(INCLUDES.'functions.inc.php');
require(INCLUDES.'url_variables.inc.php');
require(INCLUDES.'db_tables.inc.php');
require(DB.'common.db.php');
require(DB.'admin_common.db.php');
require(INCLUDES.'version.inc.php');
require(INCLUDES.'headers.inc.php');

$query_style = "SELECT brewStyleGroup FROM $styles_db_table WHERE brewStyleActive='Y'";
if ($filter !="default") $query_style .= " AND brewStyleGroup='$filter'";
$style = mysql_query($query_style, $brewing) or die(mysql_error());
$row_style = mysql_fetch_assoc($style);

do { $s[] = $row_style['brewStyleGroup']; } while ($row_style = mysql_fetch_assoc($style));
sort($s);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($tb == "default") { ?><meta http-equiv="refresh" content="0;URL=<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&tb=true"; ?>" /><?php } ?>
<title>Brew Competition Online Entry and Management - brewcompetition.com</title>
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="../js_includes/jquery.dataTables.js"></script>

<style type="text/css">
<!--
body {
	font-size: 10px;
}
-->
</style>
</head>
<body <?php if ($tb == "true") echo "onload=\"javascript:window.print()\""; ?>>
<div id="content">
	<div id="content-inner">
<?php foreach (array_unique($s) as $style) { 
$query_entries = sprintf("SELECT id,brewName,brewStyle,brewCategorySort,brewSubCategory,brewBrewerLastName,brewBrewerFirstName,brewBrewerID,brewJudgingNumber FROM $brewing_db_table WHERE brewCategorySort='%s'", $style);
$entries = mysql_query($query_entries, $brewing) or die(mysql_error());
$row_entries = mysql_fetch_assoc($entries);
$totalRows_entries = mysql_num_rows($entries);
if ($totalRows_entries > 0) {
?>
    <div id="header">	
		<div id="header-inner">
        	<h1><?php echo "Category ".ltrim($style,"0").": ".style_convert($style,1); ?></h1>
            <h3><?php echo $totalRows_entries." Entries"; ?></h2>
        </div>
	</div>
    <?php if ($go == "default") { ?>
     <script type="text/javascript" language="javascript">
	 $(document).ready(function() {
		$('#sortable<?php echo $style; ?>').dataTable( {
			"bPaginate" : false,
			"sDom": 'rt',
			"bStateSave" : false,
			"bLengthChange" : false,
			"aaSorting": [[4,'asc'],[3,'asc'],[0,'asc']],
			"bProcessing" : false,
			"aoColumns": [
				null,
				null,
				null,
				null,
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] }
				]
			} );
		} );
	</script>
    <table class="dataTable" id="sortable<?php echo $style; ?>">
    <thead>
    <tr>
    	<th width="1%" class="dataHeading bdr1B">Entry #</th>
    	<th width="1%" class="dataHeading bdr1B">Judging #</th>
        <th width="20%" class="dataHeading bdr1B">Brewer</th>
        <th class="dataHeading bdr1B">Entry Name</th>
        <th width="20%" class="dataHeading bdr1B">Style</th>
        <th width="1%" class="dataHeading bdr1B">Sub</th>
        <th width="5%" class="dataHeading bdr1B">Contact</th>
        <th width="1%" class="dataHeading bdr1B">Paid?</th>
        <th width="1%" class="dataHeading bdr1B">Sorted?</th>
    </tr>
    </thead>
    <tbody>
    <?php do { 
	$info = brewer_info($row_entries['brewBrewerID']);
	$brewer_info = explode("^",$info);
	?>
    <tr>
        <td class="data bdr1B_gray"><?php if ($row_entries['id'] < 100) echo "0"; echo $row_entries['id']; ?></td>
        <td class="data bdr1B_gray"><?php echo $row_entries['brewJudgingNumber']; ?></td>
        <td class="data bdr1B_gray"><?php echo $row_entries['brewBrewerLastName'].", ".$row_entries['brewBrewerFirstName']; if ($row_entries['brewCoBrewer'] != "") echo "<br>".$row_entries['brewCoBrewer']; ?></td>
        <td class="data bdr1B_gray"><?php echo $row_entries['brewName']; ?></td>
        <td class="data bdr1B_gray"><?php echo $row_entries['brewStyle']; ?></td>
        <td class="data bdr1B_gray"><?php echo $row_entries['brewSubCategory']; ?></td>
        <td class="data bdr1B_gray"><?php echo $brewer_info[2]."<br>".$brewer_info[6]; ?></td>
        <td class="data bdr1B_gray"><p class="box_small">&nbsp;</p></td>
        <td class="data bdr1B_gray"><p class="box_small">&nbsp;</p></td>
    </tr>
    <?php } while ($row_entries = mysql_fetch_assoc($entries)); ?>
    </tbody>
    </table>
<div style="page-break-after:always;"></div>
	<?php } // end if ($go == "default") ?>
    <?php if ($go == "cheat") { ?>
    <h3>Entry Number / Judging Number Cheat Sheet</h3>
     <script type="text/javascript" language="javascript">
	 $(document).ready(function() {
		$('#sortable<?php echo $style; ?>').dataTable( {
			"bPaginate" : false,
			"sDom": 'rt',
			"bStateSave" : false,
			"bLengthChange" : false,
			"aaSorting": [[0,'asc'],[1,'asc']],
			"bProcessing" : false,
			"aoColumns": [
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] },
				{ "asSorting": [  ] }
				]
			} );
		} );
	</script>
    <table class="dataTable" id="sortable<?php echo $style; ?>">
    <thead>
    <tr>
    	<th width="10%" class="dataHeading bdr1B">Entry #</th>
        <th width="10%" class="dataHeading bdr1B">Judging #</th>
        <th class="dataHeading bdr1B">Label Affixed?</th>
    </tr>
    </thead>
    <tbody>
    <?php do { 
	$info = brewer_info($row_entries['brewBrewerID']);
	$brewer_info = explode("^",$info);
	?>
    <tr>
        <td class="data bdr1B_gray"><?php echo $row_entries['id']; ?></td>
        <td class="data bdr1B_gray"><?php echo $row_entries['brewJudgingNumber']; ?></td>
        <td class="data bdr1B_gray"><p class="box_small">&nbsp;</p></td>
    </tr>
    <?php } while ($row_entries = mysql_fetch_assoc($entries)); ?>
    </tbody>
    </table>
	<div style="page-break-after:always;"></div>  
    <?php } // end if ($go == "cheat") ?>
<?php 
  } // end if ($totalRows_entries > 0)
} // end foreach ?>
</div>
</div>