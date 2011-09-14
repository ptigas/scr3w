<?php
   // Shows contents to a table
   // head = shown in th tags
   // $rows = contents of each row
   function table( $cols, $rows, $table, $keys, $page, $last ){
	global $masterDetailIndex;
	global $tablekeys;
        global $tablenames;
	
	$index = array();
      ?><h1><?php
      echo htmlspecialchars($table);
      ?></h1>
	<div style="margin-left:11px; margin-bottom:5px;float:left">
		[<a href='?action=queries'>common queries</a>]
	</div>
      <div style="margin-bottom:5px; float:right" id="tables" align="right">
		<?php
		$tableBar = '';
		foreach($tablenames as $t){
			if( $t == $table ){
				$tableBar .= "<strong>$t</strong> | ";
			}else{
				$tableBar .= "<a href='dispatch.php?action=table&name=$t'>$t</a> | ";
			}
		}
		echo substr( $tableBar, 0, -2 );
		?>
	  </div>
      <table class='view'><tr><?php
	  $i = 0;
      foreach ( $cols as $head ){
	
	  if (!empty($masterDetailIndex[$table]))
		foreach( $masterDetailIndex[$table] as $md ){
			if( $md[0] == $head ){
				$index []= array($i, $md);
			}			
		}
		$i++;
         ?><th><?php echo htmlspecialchars($head); ?></th><?php
      }
      ?><th></th></tr>
      <?php

      foreach ( $rows as $row ){
         ?><tr><?php
		$i = 0;
         foreach ( $row as $col ){
			$flag = false;
			foreach( $index as $ii ){
				if( $i == $ii[0] ){
					$flag = true;
					$master = $table;
					$source = $ii[1][0];
					$detail = $ii[1][1][0];
					$target = $ii[1][1][1];
					?><td><?php
					echo "<a href='?action=master&master=$master&source=$source&target=$target&detail=$detail&id=".$cols[0]."&value=".$row[$cols[0]]."' >" . htmlspecialchars($col) . "</a>";
					?></a></td><?php
					break;
				}
			}
			if( !$flag ){
            	?><td><?php echo htmlspecialchars($col); ?></td><?php
			}
			$i++;
         }
         ?><td align="right">
         <a href="?action=edit&amp;table=<?php
         echo htmlspecialchars($table);
         ?>&amp;id=<?php
         $ids = array();

         foreach ($keys as $key) {
           $ids[] = $row[$key];
         }

         $ids = implode(' ', $ids);
         echo htmlspecialchars($ids);
         ?>" title="Edit"><img src='static/icons/page_edit.png' /></a>
         <a href="#" onclick="delete_record('<?php
         echo htmlspecialchars($table);
         ?>', '<?php
         echo htmlspecialchars($ids);
         ?>'); return false" title="Delete"><img src='static/icons/page_delete.png' /></a>
         </td>
         </tr><?php
      }
      ?></table>
<div align="right" style="margin-right:40px">
	<a style="text-decoration:none" href="./dispatch.php?action=edit&amp;table=<?php
      echo htmlspecialchars($table);
      ?>" title="Add"><img src='static/icons/add.png' /> Add</a>
</div>
		<div id="pages">
		<?php
		
		$f = ($page>=3)?$page-2:1;
		$t = ($page>=3)?$page+2:($last>5?5:$last);
		if( $page >= 4){
			echo "<a href=?action=table&name=$table&page=".($page-1)." title=\"Previous page\">&laquo;</a> ";
		}
	  for($i=$f;$i<=$t;$i++){
		if( $i != $page ){
			echo "<a href=?action=table&name=$table&page=$i>$i</a> ";
		}else{
			echo "<a class='active'>$i</a> ";
		}
	}
	if( $page < $last - 5){
		echo "<a href=?action=table&name=$table&page=".($page+1)." title=\"Next page\">&raquo;</a> ";
	}
	?>
	<?php
   }
?>
