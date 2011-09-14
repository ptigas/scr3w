<?php
$table = getRequestArgument('table');
$id = getRequestArgument('id');

// TODO check params

$keys = (array)$tablekeys[$table];
$ids = explode(' ', $id);

if (count($keys) != count($ids)) {
  // TODO error
}

$pairs = array();

for ($i = 0; $i < count($keys); $i++) {
  $pairs[] = $keys[$i] . " = '" . addslashes($ids[$i]) . "'";
}

$sql = "DELETE FROM $table WHERE " . implode(' AND ', $pairs);
$stmt = $db->query($sql);

$success = (($stmt) && ($db->rowCount($stmt) == 1));

$error = $db->error($stmt);

echo json_encode(array('success' => $success, 'message' => isset($error[2])?$error[2]:'Unable to delete row'));
?>
