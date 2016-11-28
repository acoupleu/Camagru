<?php
session_start();
include '../config/db_connection.php';
include '../config/Article.php';
include '../config/database.php';
require 'isLiked.php';

$nbImage = $_POST["nbImage"];
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
foreach($bdd->prepare("SELECT photo FROM photos WHERE user_login=:username ORDER BY date_creation DESC LIMIT " . $nbImage . ", 10",
							array("username" => $_SESSION["username"]), Article) as $post):
	$newdiv .= '<div class="photogallery">';
	$newdiv .= $post->getImage();
	$imgopt = isLiked($post->getUrlImage(), $_SESSION["username"], $bdd);
	$newdiv .= $imgopt;
	$newdiv .= '</div>';
endforeach;
$bdd = null;
echo $newdiv;
?>
