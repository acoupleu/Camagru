<?php

function rrmdir($src) {
	$dir = opendir($src);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			$full = $src . '/' . $file;
			if ( is_dir($full) ) {
				rrmdir($full);
			}
			else {
				unlink($full);
			}
		}
	}
	closedir($dir);
	rmdir(TARGET);
}

define('TARGET', './img/');
define('MAX_SIZE', 10000000);
define('WIDTH_MAX', 500);
define('HEIGHT_MAX', 375);


$tabExt = array('png');
$infosImg = array();

$extension = '';
$message = '';
$nomImage = '';


if( is_dir(TARGET) ) {
	rrmdir(TARGET);
}

if( !mkdir(TARGET, 0755) ) {
	exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
}

if(!empty($_POST))
{
	if( !empty($_FILES['fichier']['name']) )
	{
		$extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
		if(in_array(strtolower($extension),$tabExt))
		{
			$infosImg = getimagesize($_FILES['fichier']['tmp_name']);
			if($infosImg[2] >= 1 && $infosImg[2] <= 14)
			{
				if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
				{
					if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
					{
						$nomImage = 'imgtmp.'. $extension;
						if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
						{
							$message = '1';
						}
						else {
							$message = '2';
						}
					}
					else {
						$message = '3';
					}
				}
				else {
					$message = '4';
				}
			}
			else {
				$message = '5';
			}
		}
		else {
			$message = '6';
		}
	}
	else {
		$message = '7';
	}
}

header('Location: http://localhost:8080/Camagru/index.php?p=mount&msg=' . $message);
?>
