<?php
session_start();
include '../config/db_connection.php';
include '../config/Article.php';
include '../config/database.php';
require 'tools.php';

$nbImage = $_POST["nbImage"];
$page = $_POST["page"];
$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
if ($page === "mygallery")
{
	foreach($bdd->prepare("SELECT photo FROM photos WHERE user_login=:username ORDER BY date_creation DESC LIMIT " . $nbImage . ", 10",
								array("username" => $_SESSION["username"]), Article) as $post):
		$newdiv .= '<div class="photogallery"><a href="pages/photo.php">';
		$newdiv .= $post->getImage();
		$newdiv .= '</a>';
		$imgopt = isLiked($post->getUrlImage(), $_SESSION["username"], $bdd);
		$imgopt .= '<span onclick="deleteImg(this);" id="delete"><img src="img/delete.png" title="Supprimer"></span></div>';
		$newdiv .= $imgopt;
		$newdiv .= '</div>';
	endforeach;
}
else
{
	foreach($bdd->query("SELECT photo FROM photos ORDER BY date_creation DESC LIMIT " . $nbImage . ", 10", Article) as $post):
		$newdiv .= '<div class="photogallery"><a href="index.php?p=profil">';
		$newdiv .= $post->getImage();
		$newdiv .= '</a>';
		if (isset($_SESSION["connect"]))
		{
			$imgopt = isLiked($post->getUrlImage(), $_SESSION["username"], $bdd);
			$imgopt .= '</div>';
			$newdiv .= $imgopt;
		}
		$newdiv .= '</div>';
	endforeach;
}
$bdd = null;
echo $newdiv;
?>
