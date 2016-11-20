<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
{
?>
	<form action="index.php?p=pwchange" method="post">
		<input type="password" name="oldpw" placeholder="old password" required/>
		<br />
		<input type="password" name="newpw" placeholder="new password" required/>
		<br />
		<input type="password" name="confpw" placeholder="confirm password" required/>
		<br />
		<input type="submit" value="Changer le mot de passe">
	</form>
<?php
	if (isset($_POST["oldpw"]) && isset($_POST["newpw"]))
	{
		$userlog = $bdd->prepare("SELECT user_password FROM users WHERE user_login=?", array($_SESSION["username"]), User, true);
		$password = hash('whirlpool', $_POST["oldpw"]);
		if ($userlog->getUserPass() === $password)
		{
			$newpassword = hash('whirlpool', $_POST["newpw"]);
			if ($newpassword === $password)
			{
				echo "Mot de passe identique";
			}
			else
			{
				if ($_POST["newpw"] === $_POST["confpw"])
				{
					$bdd->prepare("UPDATE users SET user_password=:password WHERE user_login=:username",
					array("username" => $_SESSION["username"], "password" => $newpassword));
					echo "Mot de passe changé avec succès";
				}
				else
				{
					echo "Les mots de passes ne correspondent pas.";
				}
			}
		}
		else
		{
			echo "mauvais mot de passe";
		}
	}
}
else
{
?>
	<p><strong>Vous n'avez pas accès à cette page, veuillez vous connecter.</strong></p>
	<p>Vous allez être redirigé dans 5 secondes	</p>
	<p>Si la page ne se rafraichit pas automatiquement, <a href="index.php">cliquez ici.</a></p>
<?php
	header('Refresh: 5;url=http://localhost:8080/Camagru/index.php');
}
?>
