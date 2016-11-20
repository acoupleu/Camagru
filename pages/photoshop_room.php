<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
{
	$img = $_POST["img"];
	var_dump($img);
?>
	<script src="oXHR.js"></script>
	<script src="webcam.js"></script>
	<div class="camera">
		<video id="video">Video stream not available.</video>
		<img id="filtreactive" src="">
		<br />
		<button id="startbutton">Prendre une photo</button>
		<br />
		<div class="output">
			<img id="photo" alt="The screen capture will appear in this box.">
		</div>
		<canvas id="canvas"></canvas>
	</div>
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
