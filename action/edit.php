<?php
$table = getRequestArgument('table');
$id = getRequestArgument('id');

// TODO check params

$keys = (array)$tablekeys[$table];

if ($id === null) {
  $ids = array();
}
else {
  $ids = explode(' ', $id);
}

if (count($keys) != count($ids)) {
  // TODO error
}

$cols = $db->showColumns($table);

if (empty($_POST)) { // view
  $flash = getFlash();
  unsetFlash();

  if ($id === null) { // add
    $row = array();
  }
  else { // edit
    $pairs = array();

    for ($i = 0; $i < count($keys); $i++) {
      $pairs[] = $keys[$i] . " = '" . addslashes($ids[$i]) . "'";
    }

    $sql = "SELECT * FROM $table WHERE " . implode(' AND ', $pairs);
    $row = $db->fetchFirst($sql);
  }

  render('head');
  render('edit', $table, $keys, $ids, $cols, $row, $flash);
  render('foot');

  exit;
} // save

$values = getRequestArguments($cols);

foreach ($values as $name => $value) {
  if ($value === null) {
    unset($values[$name]);
  }
}

if (!get_magic_quotes_gpc()) {
  foreach ($values as $name => $value) {
    $values[$name] = addslashes($value);
  }
}

if ($id === null) { // add
  $sql  = "INSERT INTO $table (";
  $sql .= implode(', ', array_keys($values));
  $sql .= ") VALUES ('";
  $sql .= implode("', '", $values);
  $sql .= "')";

  $stmt = $db->query($sql);

  foreach ($keys as $key) {
    $ids[] = $values[$key];
  }

  setFlash('Row added successfully', 'info');
}
else { // edit
  $pairs = array();

  foreach ($values as $name => $value) {
    $pairs[] = "$name = '$value'";
  }

  $keypairs = array();

  for ($i = 0; $i < count($keys); $i++) {
    $keypairs[] = $keys[$i] . " = '" . addslashes($ids[$i]) . "'";
  }

  $sql  = "UPDATE $table SET ";
  $sql .= implode(', ', $pairs);
  $sql .= ' WHERE ';
  $sql .= implode(' AND ', $keypairs);

  $stmt = $db->query($sql);

  $ids = array();

  foreach ($keys as $key) {
    $ids[] = $values[$key];
  }

  setFlash('Row updated successfully', 'info');
}

$error = $db->error($stmt);

if (isset($error[2])) {
  setFlash($error[2], 'error');
}

redirect(array('action' => 'edit', 'table' => $table, 'id' => implode(' ', $ids)));
?>
