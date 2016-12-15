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
		$imgopt = '<div class="imgopt"><span onclick="';
		if (isset($_SESSION["connect"]))
		{
			$imgopt .= 'likeImg(this);';
		}
		else
		{
			$imgopt .= "alert('Vous devez être connecté pour pouvoir liker');";
		}
		$imgopt .= '" id="like">';
		$imgopt .= '<img class="' . substr($photoPath, strrpos($photoPath, "/") + 1, strrpos($photoPath, "/") - 8) . '" src="img/nolike.png" title="' . "J'aime" . '"></span>';
	}
	else
	{
		$imgopt = '<div class="imgopt"><span onclick="';
		if (isset($_SESSION["connect"]))
		{
			$imgopt .= 'likeImg(this);';
		}
		else
		{
			$imgopt .= 'alert("Vous devez être connecté pour pouvoir liker");';
		}
		$imgopt .= '" id="like">';
		$imgopt .= '<img class="' . substr($photoPath, strrpos($photoPath, "/") + 1, strrpos($photoPath, "/") - 8) . '" src="img/like.png" title="' . "J'aime" . '"></span>';
	}
	return $imgopt;
}

function isSecured($password)
{
	return (strlen($password) >= 8 && preg_match("/[a-zA-Z]/", $password) && preg_match("/\d/", $password));
}

function isValidEmail($mail)
{
	return (filter_var($mail, FILTER_VALIDATE_EMAIL));
}
?>
