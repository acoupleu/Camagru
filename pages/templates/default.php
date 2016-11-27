<html>
<head>
	<title>Camagru</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
		<ul class="header">
			<li>
				<a href="index.php">Accueil</a>
			<?php
			if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
			{
			?>
				<a href="index.php?p=gallery">Ma galerie</a>
				<a href="index.php?p=mount">Montage</a>
			<?php
			}
			?>
			</li>
			<li class="navbar-left">
			<?php
			if (!isset($_SESSION["connect"]) && !isset($_SESSION["username"]))
			{
			?>
				<a href="index.php?p=login">Se connecter</a>
				<a href="index.php?p=register">S'enregister</a>
			<?php
			}
			else {
			?>
				<a href="index.php?p=profil"><?php echo $_SESSION["username"];?></a>
				<a href="index.php?p=logout">Deconnecter</a>
			<?php
			}
			?>
			</li>
		</ul>

		<?= $content; ?>

<footer>
		Camagru ©acoupleu
</footer>
</body>
</html>
