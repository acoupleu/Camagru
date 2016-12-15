<?php
session_start();
require '../config/db_connection.php';
require '../config/database.php';
require 'tools.php';

$photoPath = $_POST["photoPath"];
$photoClass = substr($photoPath, strrpos($photoPath, "/") + 1, strrpos($photoPath, "/") - 5);

$bdd = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$actualPhotoId = $bdd->query("SELECT id FROM photos WHERE photo='../" . $photoPath . "'", null, true);
$nblike = $bdd->query("SELECT COUNT(id) AS nb FROM likes WHERE id=" . $actualPhotoId->id, null, true);
$nblike = $nblike->nb;

$newdiv = '<div id="actionBox">';
$newdiv .= '<div class="photoBox"><img class="' . $photoClass . '" src="' . $photoPath . '"></div>';
$newdiv .= '<div class="likeandcom"><div class="likeBox">';
$newdiv .= '<span class="nblike">' . $nblike . '</span>';
$newdiv .= isLiked($photoPath, $_SESSION["username"], $bdd);
$newdiv .= '</div></div>';
if (isset($_SESSION["connect"]))
{
	$newdiv .= '<form onKeyPress="checkSubmit(event, this, true);"><textarea name="commentaire" id="commentaire" placeholder="Votre commentaire..."></textarea>';
}
else
{
	$newdiv .= '<form onKeyPress="checkSubmit(event, this, false);"><textarea name="commentaire" id="commentaire" placeholder="Vous devez vous connecter"></textarea>';
}
$newdiv .= '</form>';
$newdiv .= '<div class="commentBox">';
foreach($bdd->prepare("SELECT user_login, content, date_creation FROM comments WHERE id=:photoId ORDER BY date_creation DESC",
							array("photoId" => $actualPhotoId->id)) as $post):
$newdiv .= '<div class="comment"><span class="user">' . $post->user_login . '</span><span class="com">' . $post->content . '</span><span class="date">' . $post->date_creation . '</span></div>';
endforeach;
$newdiv .= '</div></div>';
echo $newdiv;
?>
