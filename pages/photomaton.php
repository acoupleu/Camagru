<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
{
?>
<script src="javascript/oXHR.js"></script>
<script src="javascript/webcam.js"></script>
<div id="photomaton">
<div class="main-frame">
	<form>
		<select id="camImport" onchange="camOrImport(value);" name="choice" size="1">
		<optgroup label="Selectionnez un mode de capture">
		<option value="import">Importer une image</option>
		<option value="cam">Camera</option>
		</select>
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
		<div id="upload-div">
			<form enctype="multipart/form-data" action="./pages/upload.php" method="post">
				<fieldset>
				<legend>Uploader une image</legend>
				<p>
					Votre image doit être en format png et de la taille 500*375
					<br/>
					<br/>
					<label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
					<input name="fichier" type="file" id="fichier_a_uploader" />
					<br/>
					<input type="submit" name="submit" value="Uploader" />
				</p>
			</fieldset>
			</form>
		</div>
	</div>
	<img id="filter">
<?php
	if (file_exists('pages/img/imgtmp.png'))
	{
?>
	<div id="uploaded-div">
		<img id="uploaded-photo" src="pages/img/imgtmp.png"/>
	</div>
<?php } ?>
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
	if (file_exists('pages/img/imgtmp.png'))
	{
?>
	<script>
		window.allowFilter = true;
		createButtons('image');
	</script>
<?php
	}
	if (isset($_GET['msg']))
	{
?>
		<script>
			errorUpload('<?php echo $_GET["msg"]; ?>');
		</script>
<?php
	}
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
