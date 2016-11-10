<?php
session_start();
if (isset($_SESSION["connect"]) === true) {
	echo "tu es deja connecte ".$_SESSION["username"];
	exit(0);
}
if (isset($_POST["username"]) && isset($_POST["password"])) {
	$username = $_POST["username"];
	$userlog = $bdd->query("SELECT user_login, user_password, user_email FROM users WHERE user_login='" . $username . "'", User)[0];
	if ($userlog != null) {
		$password = hash('whirlpool', $_POST["password"]);
		if ($userlog->getUserPass() === $password) {
			$_SESSION["connect"] = true;
			$_SESSION["username"] = $username;
			header('Location: index.php');
		}
		else {
			echo "mauvais mot de passe";
		}
	}
	else {
		echo "Tu ne t'es pas enregistre ou mauvais mot de passe / username.";
	}
}

?>
<form action="index.php?p=login" method="post">
	<input type="text" name="username" placeholder="username" required/>
	<input type="password" name="password" placeholder="password" required/>
	<input type="submit" value="Se connecter">
</form>
