<?php
session_start();
include '../config/db_connection.php';
include '../config/database.php';
$username = $_SESSION["username"];
$photo = $_POST['photo'];

$photo = str_replace('http://localhost:8080/Camagru/', '../', $photo);
var_dump($photo);
unlink($photo);
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$bdd->prepare("DELETE FROM photos WHERE user_login=:username AND photo=:photo",
			array("username" => $username,
				"photo" => $photo), null);
$bdd = null;
?>