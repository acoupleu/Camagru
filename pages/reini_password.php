<?php
require 'tools.php';
$username = $_GET['log'];
$key = $_GET['key'];

$userinfo = $bdd->prepare("SELECT reini_key,reini_done FROM users WHERE user_login LIKE :username ", array("username" => $username), User, true);
if($userinfo !== false)
{
	$reini_key = $userinfo->getReiniKey();
	$reini_done = $userinfo->isReiniDone();
}
if($reini_done == '1')
{
?>
	<div class="validation">
		<p><strong>Votre mot de passe a été modifié !</strong></p>
		<p>Vous allez être redirigé dans 5 secondes	</p>
		<p>Si la page ne se rafraichit pas automatiquement, <a href="index.php">cliquez ici.</a></p>
	</div>
<?php
	header('Refresh: 5;url=http://localhost:8080/Camagru/index.php');
}
else
{
	if($key == $reini_key)
	{
?>
		<form action="index.php?p=pwreini&log=<?php echo $username?>&key=<?php echo $key?>" method="post">
			<input type="password" name="newpw" placeholder="new password" required/>
			<br />
			<input type="password" name="confpw" placeholder="confirm password" required/>
			<br />
			<input type="submit" value="Changer le mot de passe">
		</form>
<?php
		if (isset($_POST["newpw"]) && isset($_POST["confpw"]))
		{
			if (isSecured($_POST["newpw"]))
			{
				if ($_POST["newpw"] === $_POST["confpw"])
				{
					$password = hash('whirlpool', $_POST["newpw"]);
					$bdd->prepare("UPDATE users SET reini_done = 1, user_password=:password WHERE user_login=:username",
					array("username" => $username, "password" => $password));
					header('Location: index.php?p=pwreini&log=' . $username . '&key=' . $key);
				}
				else
				{
					echo "Les mots de passes ne correspondent pas.";
				}
			}
			else
			{
				echo "Votre mot de passe doit contenir au moins 8 caractères et être composé de lettres ET de chiffres. Veuillez en essayer un autre.";
			}
		}
	}
	else
	{
?>
		<div class="validation">
			<p><strong>Erreur ! Votre mot de passe ne peut être changé...</strong></p>
			<p>Vous allez être redirigé dans 5 secondes	</p>
			<p>Si la page ne se rafraichit pas automatiquement, <a href="index.php">cliquez ici.</a></p>
		</div>
<?php
		header('Refresh: 5;url=http://localhost:8080/Camagru/index.php');
	}
}
?>
