<?php

class Connect {

public function __construct() {
	$database = new mysqli($host, $user, $pass, $db_name);
}


}
