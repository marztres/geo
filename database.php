<?php

require_once 'config.php';

class DataBase extends mysqli{

	public function __construct(){
		parent::__construct( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		if(mysqli_connect_error()){
			die("BD ERROR: ".mysqli_connect_errno()." - ".mysqli_connect_error());
		}
	}
}

?>