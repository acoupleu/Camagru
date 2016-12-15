<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
{
?>
<script src="javascript/oXHR.js"></script>
<script src="javascript/webcam.js"></script>
<div id="photomaton">
<div class="main-frame">
	<p id="support-notice">Your browser does not support Ajax uploads :-(<br/>The form will be submitted as normal.</p>
	<form action="/" method="post" enctype="multipart/form-data" id="form-id">
		<p><input id="file-id" type="file" name="our-file" />
		<input type="button" value="Upload" id="upload-button-id" disabled="disabled" /></p>
		<p><label>Some other field: <input name="other-field" type="text" id="other-field-id" /></label></p>
		<p><input type="submit" value="Submit" /></p>
	</form>
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
</div>
<div class="side-frame">
</div>
</div>
<div id="overlay"></div>
<script src="javascript/imgManagement.js"></script>
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
