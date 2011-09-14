<?php
function getRequestArgument($arg, $default = null) {
  if (!isset($_REQUEST[$arg])) {
    return $default;
  }

  return $_REQUEST[$arg];
}

function getRequestArguments($args) {
  $values = array();

  foreach ($args as $arg) {
    $values[$arg] = getRequestArgument($arg);
  }

  return $values;
}

function getFlash() {
  $flash = array();

  if ((isset($_COOKIE['screw_flash_message'])) && (isset($_COOKIE['screw_flash_class']))) {
    $flash['message'] = $_COOKIE['screw_flash_message'];
    $flash['class']   = $_COOKIE['screw_flash_class'];
  }

  return $flash;
}

function setFlash($message, $class = 'info') {
  setcookie('screw_flash_message', $message, time() + 60);
  setcookie('screw_flash_class', $class, time() + 60);
}

function unsetFlash() {
  setcookie('screw_flash_message', '', time() - 60);
  setcookie('screw_flash_class', '', time() - 60);
}

function redirect($params = array()) {
  $pairs = array();

  foreach ($params as $name => $value) {
    $pairs[] = "$name=$value";
  }

  header("Location: ./dispatch.php?" . implode('&', $pairs));
  exit;
}

function render() {
  $args = func_get_args();
  $funcname = array_shift($args);
  $parts = preg_split('/(?<=[a-z](?=[A-Z]))/', $funcname);
  $parts = array_map('strtolower', $parts);
  $path = './view/' . implode('_', $parts) . '.php';
  require_once $path;
  call_user_func_array($funcname, $args);
}

date_default_timezone_set('Europe/Athens');
?>
