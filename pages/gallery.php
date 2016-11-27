<?php
if (isset($_SESSION["connect"]) && isset($_SESSION["username"]))
{
	$tot_image = $bdd->prepare("SELECT COUNT(photo) AS nb FROM photos WHERE user_login=:username", array("username" => $_SESSION["username"]), null, true);
	$tot_image = $tot_image->nb;
	$imgopt = '<div class="imgopt"><span id="like"><img src="img/nolike.png" title="' . "J'aime" . '"></span>';
	$imgopt .= '<span onclick="deleteImg(this);" id="delete"><img src="img/delete.png" title="Supprimer"></span></div>';
?>
	<script src="javascript/oXHR.js"></script>
	<script src="javascript/galleryManagement.js"></script>
	<div id="gallery" class="gallery">
		<?php foreach($bdd->prepare("SELECT photo FROM photos WHERE user_login=:username ORDER BY date_creation DESC LIMIT 0,20",
									array("username" => $_SESSION["username"]), Article) as $post):?>
			<div class="photogallery"><?php echo $post->getImage();echo $imgopt;?></div>
		<?php endforeach;?>
	</div>
	<script type="text/javascript"> var tot_image = '<?php echo $tot_image?>';</script>
	<script src="javascript/infscroll.js"></script>
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
