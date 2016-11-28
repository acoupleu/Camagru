<?php
session_start();
require '../config/db_connection.php';
require '../config/database.php';
$username = $_SESSION["username"];
$photo = $_POST['photo'];

define('UPLOAD_DIR', '../photo_users/' . $username . '/');
if (!file_exists(UPLOAD_DIR))
	mkdir(UPLOAD_DIR);
$img = str_replace('data:image/png;base64,', '', $photo);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $data);
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$bdd->prepare("INSERT INTO photos(user_login, photo, likes, date_creation) VALUES (:username, :photo, :likes, :times)",
			array("username" => $username,
				"photo" => $file,
				"likes" => 0,
				"times" => date("Y-m-d H:i:s")));
$bdd = null;
?>
