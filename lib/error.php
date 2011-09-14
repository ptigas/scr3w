<?php
define("ERROR_INVALID_ID", 1);
define("ERROR_INVALID_VALUE", 2);
define("ERROR_INVALID_TABLE", 3);

class ErrorList {
        static $codes = array(
                ERROR_INVALID_ID    => "Invalid ID",
                ERROR_INVALID_VALUE => "Invalid Value",
				ERROR_INVALID_TABLE => "Invalid Table"
        );
        public $errors = array();

        function exists($name) {
                return isset($this->errors[$name]);
        }

        function add($name, $errorid) {
                $this->errors[$name] = new Error($errorid);
        }

		function get( $key ){
			return isset($this->errors[$key]) ? $this->errors[$key] : false;
		}
}

class Error {
        public $errorid = null;

        function __construct($errorid) {
                $this->errorid = $errorid;
        }

        function __toString() {
                return ErrorList::$codes[$this->errorid];
        }
};
?>
