<?php

$q = (int)getRequestArgument('q', '');

$cols = NULL;
$rows = NULL;
$query = NULL;

switch( $q ){
	case 1:
	
	$query = "
	SELECT cu_name, count(*) as c
	FROM orders, customers
	WHERE cu_id = o_cu_id
	GROUP BY o_cu_id
	ORDER BY c DESC
	LIMIT 5;
	";
	
	$cols = array("cu_name", "c");
	$rows = array();
	$stmt = $db->query( $query );
	while ($row = $db->fetchAssoc($stmt)) {
		$rows[] = $row;
	}
	
	break;
	case 2:
	
	$query = "<br/>CREATE VIEW best_countries AS<br/>
	SELECT cu_cou_id<br/>
	FROM orders, customers<br/>
	WHERE cu_id = o_cu_id<br/>
	GROUP BY cu_cou_id<br/>
	ORDER BY count(*) DESC<br/>
	LIMIT 5<br/><br/>";
	
	$qr = "SELECT * FROM best_countries";
	$ids = array();
	$stmt = $db->query( $qr );
	while ($row = $db->fetchAssoc($stmt)) {
		$ids[] = $row;
	}
	$query .= $qr . '<br/>';
	$rows = array();
	
	$cols = array("Country", "Name", "Orders");
	foreach($ids as $r){
		$id = $r['cu_cou_id'];
		$qr = "
		SELECT cou_name, cu_name as Name, count(*) AS Orders
		FROM orders, customers, countries
		WHERE cu_id = o_cu_id AND cu_cou_id = $id AND cou_id = cu_cou_id
		GROUP BY o_cu_id 
		ORDER BY Orders DESC 
		LIMIT 3;
		";
		$query .= $qr . '<br/>';
		$stmt = $db->query( $qr );
		while ($row = $db->fetchAssoc($stmt)) {
			$rows[] = $row;
		}
	}
	
	break;
	
	case 3:
	$qr = "SELECT count(o_id) as c
		FROM orders
		WHERE o_date > DATE_SUB(CURDATE(),INTERVAL 2 YEAR) AND o_id not IN
		(SELECT ol_o_id
		 FROM lola)
		AND o_id IN(SELECT ol_o_id
		 FROM lola2
			)
		ORDER BY o_date DESC";
		
		$query .= $qr;
		
		$cols = array("counter");
		$rows = array();
		$stmt = $db->query( $qr );
		while ($row = $db->fetchAssoc($stmt)) {
			$rows[] = $row;
		}
	break;
}

render('head');
render('queries', $cols, $rows, $query);
render('foot');

?>
