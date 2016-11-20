<?php
$username = $_GET['log'];
$key = $_GET['key'];

$userinfo = $bdd->prepare("SELECT user_key,actif FROM users WHERE user_login LIKE :username ", array("username" => $username), User, true);
if($userinfo !== false)
{
	$user_key = $userinfo->getUserKey();
	$actif_user = $userinfo->isUserActif();
}
if($actif_user == '1')
{
?>
	<div class="validation">
		<p><strong>Votre compte est déjà actif !</strong></p>
		<p>Vous allez être redirigé dans 5 secondes	</p>
		<p>Si la page ne se rafraichit pas automatiquement, <a href="index.php">cliquez ici.</a></p>
	</div>
<?php
	header('Refresh: 5;url=http://localhost:8080/Camagru/index.php');
}
else
{
	if($key == $user_key)
	{
		$bdd->prepare("UPDATE users SET actif = 1 WHERE user_login LIKE :username ", array("username" => $username));
?>
		<div class="validation">
			<p><strong>Votre compte a bien été activé !</strong></p>
			<p>Vous allez être redirigé dans 5 secondes	</p>
			<p>Si la page ne se rafraichit pas automatiquement, <a href="index.php">cliquez ici.</a></p>
		</div>
<?php
		header('Refresh: 5;url=http://localhost:8080/Camagru/index.php');
	}
	else
	{
?>
		<div class="validation">
			<p><strong>Erreur ! Votre compte ne peut être activé...</strong></p>
			<p>Vous allez être redirigé dans 5 secondes	</p>
			<p>Si la page ne se rafraichit pas automatiquement, <a href="index.php">cliquez ici.</a></p>
		</div>
<?php
		header('Refresh: 5;url=http://localhost:8080/Camagru/index.php');
	}
}
?>
