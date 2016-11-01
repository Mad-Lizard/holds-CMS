<?php
// Database connection with constants

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "Protu-holds");

$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//Test connection
if(mysqli_connect_errno()) {
	printf("Йо-майо - Не получилось соединиться с базой данных: %s\n",
		 mysqli_connect_errno());
	exit();
} 
?>