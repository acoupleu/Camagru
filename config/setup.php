<?php
require("config/db_connection.php");
require("config/database.php");

$bdd = new PDO('mysql:localhost', $DB_USER, $DB_PASSWORD);
$bdd->query('CREATE DATABASE IF NOT EXISTS db_Cama');
$bdd = null;
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$bdd->query("CREATE TABLE IF NOT EXISTS users
			(
				user_login VARCHAR(255) NOT NULL,
				user_password VARCHAR(255) NOT NULL,
				user_email VARCHAR(255) NOT NULL,
				user_key varchar(32) NOT NULL,
				actif INT DEFAULT 0,
				reini_key varchar(255),
				reini_done INT DEFAULT 1
			)");
$bdd->query("CREATE TABLE IF NOT EXISTS photos
			(
				user_login VARCHAR(255) NOT NULL,
				photo text,
				likes int,
				date_creation DATETIME
			)");
			define('UPLOAD_DIR', '../photo_users/' . $username . '/');
if (!file_exists("photo_users"))
	mkdir("photo_users");

?>
