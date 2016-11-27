<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
{
?>
<script src="javascript/oXHR.js"></script>
<script src="javascript/webcam.js"></script>
<script src="javascript/imgManagement.js"></script>
<div class="main-frame">
	<div>
		<table class="photomaton">
			<tr>
				<td onclick="setImage('none');" class="photo none"></td>
				<td onclick="setImage('bonnet');" class="photo"><img class="miniature" src="img/bonnet.png"></td>
				<td onclick="setImage('ashe');" class="photo"><img class="miniature" src="img/ashe.png"></td>
				<td onclick="setImage('kyouko');" class="photo"><img class="miniature" src="img/kyouko.png"></td>
				<td onclick="setImage('ironman');" class="photo"><img class="miniature" src="img/ironman.png"></td>
			</tr>
		</table>
	</div>
	<img id="filter">
	<div class="camera">
		<video id="video">Video stream not available.</video>
		<br />
		<button id="printbutton">Prendre une photo</button>
		<br />
		<div class="output">
			<img id="photo">
		</div>
		<canvas id="canvas"></canvas>
	</div>
</div>
<div class="side-frame">
</div>
<script>
	addgallery();
</script>
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
