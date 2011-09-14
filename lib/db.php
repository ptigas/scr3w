<?php
class Database {
  private $dbh = null;

  public function __construct() {
    $this->connect();
  }

  public function connect() {
    if (!$this->dbh) {
      $this->dbh = new PDO('mysql:host=localhost;dbname=screw','root','');
     // $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $this->dbh;
  }

  public function disconnect() {
    $this->dbh = null;
  }

  private function fixParams($sql, $params) {
    $params = (array)$params;

    if ((empty($params)) || (preg_match_all('/(:\w+)/', $sql, $matches) != count($params))) {
      return $params;
    }

    array_shift($matches); // get rid of whole pattern match

    foreach ($matches as $i => $m) {
      if (!isset($params[$m[0]])) {
        $params[$m[0]] = $params[$i];
        unset($params[$i]);
      }
    }

    return $params;
  }

  public function query($sql, $params = array()) {
    $params = $this->fixParams($sql, $params);
    $stmt = $this->dbh->prepare($sql);

    if (!$stmt) {
      return false;
    }

    $ret = $stmt->execute($params);

    return $stmt;
  }

  public function select($sql, $params = array()) {
    return $this->query('SELECT ' . $sql, $params);
  }

  public function insert($sql, $params = array()) {
    return $this->query('INSERT INTO ' . $sql, $params);
  }

  public function delete($sql, $params = array()) {
    return $this->query('DELETE FROM ' . $sql, $params);
  }

  public function update($sql, $params = array()) {
    return $this->query('UPDATE ' . $sql, $params);
  }

  public function showColumns($table) {
    $stmt = $this->query("SHOW COLUMNS FROM $table"); // FIXME SQL injection
    $cols = array();

    while ($row = $this->fetchAssoc($stmt)) {
      $cols[] = $row['Field'];
    }

    return $cols;
  }

  // fetch next row as a numerical array
  public function fetchNum($stmt) {
    return $stmt->fetch(PDO::FETCH_NUM);
  }

  // fetch next row as an associative array
  public function fetchAssoc($stmt) {
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // fetch first row
  public function fetchFirst($sql, $params = array()) {
    $stmt = $this->query($sql, $params);
    return $this->fetchAssoc($stmt);
  }

  // fetch first column of first row
  public function fetchFirstFirst($sql, $params = array()) {
    $stmt = $this->query($sql, $params);
    $row = $this->fetchNum($stmt);
    return $row[0];
  }

  // fetch first column of all rows
  public function fetchAllFirst($sql, $params = array()) {
    $stmt = $this->query($sql, $params);
    $col = array();

    while ($row = $this->fetchNum($stmt)) {
      $col[] = $row[0];
    }

    return $col;
  }

  public function rowCount($stmt) {
    return $stmt->rowCount();
  }

  public function lastInsertId() {
    return $this->dbh->lastInsertId();
  }

  public function error($stmt) {
    return $stmt->errorInfo();
  }
}
?>
