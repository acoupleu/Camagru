<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
{
?>
	<a href="index.php?p=pwchange">Changer le mot de passe</a>
<?php
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
