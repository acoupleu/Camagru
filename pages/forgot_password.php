<?php
if (!isset($_SESSION["connect"]))
{
?>
	<h1>Vous avez oublié votre mot de passe ?</h1>
	<p>Veuillez compléter les informations suivantes</p>
	<form action="index.php?p=pwforgot" method="post">
		<input type="text" name="username" placeholder="username" required/>
		<input type="text" name="email" placeholder="email address" required/>
		<input type="submit" value="S'enregister">
	</form>
<?php
	if (isset($_POST["username"]) && isset($_POST["email"]))
	{
		$username = $_POST["username"];
		$email = $_POST["email"];
		$userlog = $bdd->prepare("SELECT user_login, user_email FROM users WHERE user_login=?", array($username), User, true);
		if ($userlog != null)
		{
			if ($userlog->getUserMail() == $email)
			{
				$key = sha1($username.$email.time());
				$bdd->prepare("UPDATE users SET reini_done = 0, reini_key = :key WHERE user_login LIKE :username ",
				array("key" => $key, "username" => $username));
				$userlog = new User($username, null, $email, $key);
				$userlog->sendResetMail();
				echo "Un mail vous a été envoyé";
			}
			else
			{
				echo "Mauvais email";
			}
		}
		else
		{
			echo "Votre login n'existe pas";
		}
		$userlog = null;
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
