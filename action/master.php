<?php
/*
 * master - master table  
 * detail - detail table
 * source - master id to match with the detail id
 * target - detail id to match with the master id
 * id - master id
 * value - value to match with the master id
 */

$master = getRequestArgument('master', NULL);
$detail = getRequestArgument('detail', NULL);
$source = getRequestArgument('source', NULL);
$target = getRequestArgument('target', NULL);
$id = getRequestArgument('id', NULL);
$value = getRequestArgument('value', NULL);

$page = getRequestArgument('page', '1');

$query = "SELECT $detail.* FROM $master, $detail WHERE $master.$source = $detail.$target AND $master.$id = $value";

$rows = $db->fetchFirstFirst( "SELECT COUNT(*) FROM $master, $detail WHERE $master.$source = $detail.$target AND $master.$id = $value" );

$rowsPerPage = 5;
$last = ceil($rows/$rowsPerPage);
$max = ' limit ' . ($page - 1)*$rowsPerPage .', ' . $rowsPerPage;

$query .= $max;

$stmt = $db->query( $query );
$rows = array();

while ($row = $db->fetchAssoc($stmt)) {
	$rows[] = $row;
}

$cols = $db->showColumns($detail);
$key = (array)$tablekeys[$detail];

render('head');
render('table', $cols, $rows, $detail, $key, $page, $last);
render('foot');
?>
