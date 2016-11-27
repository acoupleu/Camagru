<?php
session_start();
include '../config/db_connection.php';
include '../config/Article.php';
include '../config/database.php';

$nbImage = $_POST["nbImage"];
$moreImage = $nbImage + 10;
$imgopt = '<div class="imgopt"><span id="like"><img src="img/nolike.png" title="' . "J'aime" . '"></span>';
$imgopt .= '<span onclick="deleteImg(this);" id="delete"><img src="img/delete.png" title="Supprimer"></span></div>';
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
foreach($bdd->prepare("SELECT photo FROM photos WHERE user_login=:username ORDER BY date_creation DESC LIMIT " . $nbImage . "," . $moreImage,
							array("username" => $_SESSION["username"]), Article) as $post):
	$newdiv .= '<div class="photogallery">';
	$newdiv .= $post->getImage();
	$newdiv .= $imgopt;
	$newdiv .= '</div>';
endforeach;
$bdd = null;
echo $newdiv;
?>
