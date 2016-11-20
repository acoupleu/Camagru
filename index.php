<?php
require 'config/autoloader.php';
Autoloader::register();
session_start();
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
elseif ($p === 'mount')
{
	require 'pages/photoshop_room.php';
}
elseif ($p === 'register')
{
	require 'pages/register.php';
}
elseif ($p === 'validation')
{
	require 'pages/validation.php';
}
elseif ($p === 'pwchange')
{
	require 'pages/change_password.php';
}
elseif ($p === 'pwforgot')
{
	require 'pages/forgot_password.php';
}
elseif ($p === 'pwreini')
{
	require 'pages/reini_password.php';
}
else
{
	require 'pages/home.php';
}

$content = ob_get_clean();
require 'pages/templates/default.php';
?>
