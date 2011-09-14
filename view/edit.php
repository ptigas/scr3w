<?php
function edit($table, $keys, $ids, $cols, $row, $flash) {
  global $foreignkeys;
  ?><h1><?php
  echo htmlspecialchars($table);
  ?></h1>
  <div style="margin-left:13px; margin-top:5px"><a href="?action=table&amp;name=<?php
  echo htmlspecialchars($table);
  ?>">View table</a></div><?php
  if (isset($flash['message'])) {
    ?><div class="<?php
    echo htmlspecialchars($flash['class']);
    ?>"><strong><?php
    echo htmlspecialchars(ucfirst($flash['class']));
    ?>:</strong> <?php
    echo htmlspecialchars($flash['message']);
    ?></div><?php
  }
  ?><form action="./dispatch.php" method="post">
  <input type="hidden" name="action" value="edit" />
  <input type="hidden" name="table" value="<?php
  echo htmlspecialchars($table);
  ?>" /><?php
  if (!empty($ids)) {
    ?><input type="hidden" name="id" value="<?php
    echo htmlspecialchars(implode(' ', $ids));
    ?>" /><?php
  }
  ?><table><?php
  foreach ($cols as $col) {
    ?><tr>
    <th style="text-align:right"><label for="<?php
    echo htmlspecialchars($col);
    ?>"><?php
    echo htmlspecialchars($col);
    ?></label></th>
    <td><input name="<?php
    echo htmlspecialchars($col);
    ?>" <?php
    if (isset($row[$col])) {
      ?>value="<?php
      echo htmlspecialchars($row[$col]);
      ?>" <?php
    }
    ?>/></td>
    </tr><?php
  }
  ?><tr>
  <td></td>
  <td>
  <input type="submit" value="Save" />
  <input type="reset" value="Reset" />
  <a href="javascript:history.go(-1)">Back</a>
  </td>
  </table>
  </form><?php
}
?>
