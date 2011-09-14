<?php
require './settings.php';
require './lib/common.php';
require './lib/error.php';
require './lib/db.php';

$db = new Database();

$error = new ErrorList();

if (isset($_REQUEST['action'])) {
  $action = basename($_REQUEST['action'], '.php');
}

if ((!isset($_REQUEST['action'])) || (!file_exists("./action/$action.php"))) {
  $action = 'table';
}

require "./action/$action.php";
?>
