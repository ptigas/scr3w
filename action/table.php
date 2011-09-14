<?php
$name = getRequestArgument('name', 'countries');
$page = getRequestArgument('page', '1');
$rows = $db->fetchFirstFirst( "select count(*) from $name" );
$query = "* FROM $name";

$rowsPerPage = 5;
$last = ceil($rows/$rowsPerPage);
$max = ' limit ' . ($page - 1)*$rowsPerPage .', ' . $rowsPerPage;

$query .= $max;

$stmt = $db->select( $query ); // FIXME

if($stmt){
	$rows = array();

	while ($row = $db->fetchAssoc($stmt)) {
		$rows[] = $row;
	}

	$cols = $db->showColumns($name);
	$keys = (array)$tablekeys[$name];

	render('head');
	render('table', $cols, $rows, $name, $keys, $page, $last);
	render('foot');
	
}else{
	$error->add("table", ERROR_INVALID_TABLE);
	
	echo $error->get('table');
}

?>
