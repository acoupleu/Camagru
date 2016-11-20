<?php
if (!isset($_SESSION["connect"]))
{
?>
	<form action="index.php?p=register" method="post">
		<input type="text" name="username" placeholder="Ex : jean59" required/>
		<input type="password" name="password" placeholder="password" required/>
		<input type="text" name="email" placeholder="Ex : jean59@gmail.com" required/>
		<input type="submit" value="S'enregister">
	</form>
<?php
	if (isset($_POST["username"]) && isset($_POST["password"])) {
		$username = $_POST["username"];
		$password = hash('whirlpool', $_POST["password"]);
		$email = $_POST["email"];
		$key = md5(microtime(TRUE)*100000);
		$userlog = $bdd->prepare("SELECT user_login FROM users WHERE user_login=?", array($username), User, true);
		if ($userlog == null) {
			$bdd->prepare("INSERT INTO users(user_login, user_password, user_email, user_key)
			VALUES (:username,
					:password,
					:email,
					:user_key)",
			array(	"username" => $username,
					"password" => $password,
					"email" => $email,
					"user_key" => $key), null);
			$userlog = new User($username, $password, $email, $key);
			$userlog->sendMail();
			$userlog = null;
			header('Location: index.php?p=login');
		}
		else {
			echo "deja enregistre, desole, degage";
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
