<?php
session_start();
require '../config/db_connection.php';
require '../config/user.php';
require '../config/database.php';

$comment = $_POST['comment'];
$photoPath = $_POST['photoPath'];
$origin = base64_encode($_POST['photofrom']);
$username = $_SESSION["username"];
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$photoinfo = $bdd->prepare("SELECT id, user_login FROM photos WHERE photo=?", array($photoPath), null, true);
$photo_id = $photoinfo->id;
$photo_owner = $photoinfo->user_login;
$owner_mail = $bdd->prepare("SELECT user_email FROM users WHERE user_login=?", array($photo_owner), null, true);
$owner_log = new User($username, null, $owner_mail->user_email, null, null, null, null, $origin);
$owner_log->sendCommentMail();
$time = date("Y-m-d H:i:s");
$bdd->prepare("INSERT INTO comments(user_login, id, content, date_creation)
	VALUES (:username,
			:id,
			:content,
			:date_creation)",
	array(	"username" => $username,
			"id" => $photo_id,
			"content" => $comment,
			"date_creation" => $time));
$newdiv = '<span class="user">' . $username . '</span>';
$newdiv .= '<span class="com">' . $comment . '</span>';
$newdiv .= '<span class="date">' . $time . '</span>';
echo $newdiv;
?>
