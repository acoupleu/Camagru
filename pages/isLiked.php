<?php
function isLiked($photo, $username, $bdd)
{
	$photoPath =  '../' . $photo;
	$photo_id = $bdd->prepare("SELECT id FROM photos WHERE photo=?", array($photoPath), null, true)->id;
	$is_liked = $bdd->prepare("SELECT user_login FROM likes WHERE id=:id AND user_login=:username",
							array("id" => $photo_id,
								"username" => $username));
	if ($is_liked == null)
	{
		$imgopt = '<div class="imgopt"><span onclick="likeImg(this);"id="like"><img src="img/nolike.png" title="' . "J'aime" . '"></span>';
	}
	else
	{
		$imgopt = '<div class="imgopt"><span onclick="likeImg(this);"id="like"><img src="img/like.png" title="' . "J'aime" . '"></span>';
	}
	$imgopt .= '<span onclick="deleteImg(this);" id="delete"><img src="img/delete.png" title="Supprimer"></span></div>';
	return $imgopt;
}
?>
