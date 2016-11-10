<?php
session_start();
if (isset($_SESSION["connect"]) === true) {
	echo $_SESSION["username"]." tu es deja connecte";
	exit(0);
}
if (isset($_POST["username"]) && isset($_POST["password"])) {
	$username = $_POST["username"];
	$password = hash('whirlpool', $_POST["password"]);
	$email = $_POST["email"];
	$userlog = $bdd->query("SELECT user_login FROM users WHERE user_login='" . $username . "'", User)[0];
	if ($userlog == null) {
		$bdd->query("INSERT INTO users(user_login, user_password, user_email) VALUES ('" . $username . "', '" . $password . "', '" . $email . "')", null);
		$userlog = new User($username, $password, $email);
		$userlog->sendMail();
		$userlog = null;
		header('Location: index.php?p=login');
	}
	else {
		echo "deja enregistre, desole, degage";
	}
}

?>
<form action="index.php?p=register" method="post">
	<input type="text" name="username" placeholder="Ex : jean59" required/>
	<input type="password" name="password" placeholder="password" required/>
	<input type="text" name="email" placeholder="Ex : jean59@gmail.com" required/>
	<input type="submit" value="S'enregister">
</form>
