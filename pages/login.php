<?php
if (!isset($_SESSION["connect"]))
{
?>
	<form action="index.php?p=login" method="post">
		<input type="text" name="username" placeholder="username" required/>
		<input type="password" name="password" placeholder="password" required/>
		<input type="submit" value="Se connecter">
	</form>
	<a href="index.php?p=pwforgot">Mot de passe oublié ?</a>
<?php
	if (isset($_POST["username"]) && isset($_POST["password"]))
	{
		$username = $_POST["username"];
		$userlog = $bdd->prepare("SELECT user_login, user_password, actif FROM users WHERE user_login LIKE ?", array($username), User, true);
		if ($userlog != null)
		{
			$password = hash('whirlpool', $_POST["password"]);
			if ($userlog->getUserPass() === $password)
			{
				if ($userlog->isUserActif())
				{
					$_SESSION["connect"] = true;
					$_SESSION["username"] = $username;
					header('Location: index.php');
				}
				else
				{
					echo "Votre compte n'est pas encore activé";
				}
			}
			else
			{
				echo "mauvais mot de passe";
			}
		}
		else
		{
			echo "Tu ne t'es pas enregistre ou mauvais mot de passe / username.";
		}
	}
}
else
{
?>
	<p><strong>Vous êtes déjà connecté <?php echo $_SESSION["username"];?>.</strong></p>
	<p>Vous allez être redirigé dans 5 secondes	</p>
	<p>Si la page ne se rafraichit pas automatiquement, <a href="index.php">cliquez ici.</a></p>
<?php
	header('Refresh: 5;url=http://localhost:8080/Camagru/index.php');
}
?>
