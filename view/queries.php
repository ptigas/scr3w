<?php
   // Shows contents to a table
   // head = shown in th tags
   // $rows = contents of each row
   function queries($cols, $rows, $query){
	
	?>
	<h1>common queries</h1>
	<div style="margin-left:11px; margin-bottom:5px;">
		<a href='dispatch.php'>back</a>
	</div>
	
	<ul>
		<li><a href=?action=queries&q=1>Οι 5 καλύτεροι πελάτες της αγοράς</a></li>
		<li><a href=?action=queries&q=2>3 καλύτεροι πελάτες για κάθε ένα απο τα 5 πρώτα σε αγορές κράτη</a></li>
		<li><a href=?action=queries&q=3>3 αριθμός/ποσοστό απο τις παραγγελίες που δεν έχουν εφηχθεί ακόμη</a></li>
	</ul>
	
	<?php if ( $rows ) {?>
		
		<?php 
		if( $query ){
			echo '<b>query : </b><i>'. $query .'</i>'; 
		}
		?>
		
		<table class='view'><tr><?php
		foreach ( $cols as $head ){
		?><th><?php echo htmlspecialchars($head); ?></th><?php
	     }
	     ?></tr>
		 <?php

	      foreach ( $rows as $row ){
	         ?><tr><?php
			$i = 0;
	         foreach ( $row as $col ){
				?><td><?php echo htmlspecialchars($col); ?></td><?php
			}
			?></tr><?php
		}
		?></table><?php
		
	}else{
		echo '<div align="center"><i>No data or no query made</i></div>';
	}
	
   }
?>
