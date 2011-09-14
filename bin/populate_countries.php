<?php

include './lib/db.php';

$continents = array("AF"=>"Africa","EU"=>"Europe", "AS"=>"Asia","NA"=>"North America","OC"=>"Oceania","AN"=>"Antartica","SA"=>"South America");

$lines = file('./data/countries.dat');
$c = '';

foreach($lines as $line){
	$l = explode('   ', $line);
	$c = $continents[$l[0]];
	$r = $db->fetchFirst('SELECT * FROM continents WHERE con_name = :name', $c);
	if( !$r ){
		$db->query('INSERT INTO continents (con_name) VALUES (:name)', $c);
	}
	$db->query("INSERT INTO countries (cou_name, cou_con_id) VALUES (:name,:id)",array(trim($l[1]), $r['con_id']));
}

?>
