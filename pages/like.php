<?php
session_start();
require '../config/db_connection.php';
require '../config/database.php';

$photoPath = $_POST['photo'];
$username = $_SESSION["username"];
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$photo_id = $bdd->prepare("SELECT id FROM photos WHERE photo=?", array($photoPath), null, true)->id;
$is_liked = $bdd->prepare("SELECT user_login FROM likes WHERE id=:id AND user_login=:username",
						array("id" => $photo_id,
							"username" => $username));
if ($is_liked == null)
{
	$bdd->prepare("INSERT INTO likes(id, user_login)
	VALUES (:id,
			:username)",
	array(	"id" => $photo_id,
			"username" => $username));
	echo 'like';
}
else
{
	$bdd->prepare("DELETE FROM likes WHERE id=:id AND user_login=:username",
				array("id" => $photo_id,
					"username" => $username));
	echo 'dislike';
}
$bdd = null;
?>
