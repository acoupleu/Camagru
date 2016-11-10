<?php
require 'config/autoloader.php';
Autoloader::register();
if (!isset($bdd))
	require ("config/setup.php");
if (isset($_GET['p']))
{
	$p = $_GET['p'];
}
else
{
	$p = 'home';
}

ob_start();
if ($p === 'home')
{
	require 'pages/home.php';
}
elseif ($p === 'login')
{
	require 'pages/login.php';
}
elseif ($p === 'logout')
{
	require 'pages/logout.php';
}
elseif ($p === 'profil')
{
	require 'pages/profil.php';
}
elseif ($p === 'register')
{
	require 'pages/register.php';
}
$content = ob_get_clean();
require 'pages/templates/default.php';
?>
