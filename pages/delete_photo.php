<?php
session_start();
require '../config/db_connection.php';
require '../config/database.php';
$username = $_SESSION["username"];
$photo = $_POST['photo'];

$photo = str_replace('http://localhost:8080/Camagru/', '../', $photo);
unlink($photo);
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$bdd->prepare("DELETE FROM photos WHERE user_login=:username AND photo=:photo",
			array("username" => $username,
				"photo" => $photo));
$bdd = null;
?>
