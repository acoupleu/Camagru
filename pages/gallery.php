<?php
require 'tools.php';

$tot_image = $bdd->query("SELECT COUNT(photo) AS nb FROM photos", null, true);
$tot_image = $tot_image->nb;
?>
<script src="javascript/oXHR.js"></script>
<div id="overlayGal"></div>
<div id="gallery" class="gallery">
	<?php foreach($bdd->prepare("SELECT photo FROM photos ORDER BY date_creation DESC LIMIT 0,10",
								array("username" => $_SESSION["username"]), Article) as $post):?>
<div class="photogallery"><a href="pages/photo.php"><?php echo $post->getImage();?></a>
	<?php if (isset($_SESSION["connect"]))
		{
			echo isLiked($post->getUrlImage(), $_SESSION["username"], $bdd); echo '</div>';
		}?>
</div><?php endforeach;?>
</div>
<script type="text/javascript">
	var tot_image = '<?php echo $tot_image?>';
	var page = '<?php echo $_GET["p"]?>'
</script>
<script src="javascript/infscroll.js"></script>
<script src="javascript/galleryManagement.js"></script>
<script>createLightboxCom();</script>
