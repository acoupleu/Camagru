<?php
session_start();
function base64_encode_img ($file_name, $file_type)
{
	if ($file_name)
	{
		$image = fread(fopen($file_name, "r"), filesize($file_name));
		return 'data:image/' . $file_type . ';base64,' . base64_encode($image);
	}
}


$img = $_POST["img"];
$filtre = $_POST["filtre"];

if ($_POST["with"] === 'cam')
{
	define('UPLOAD_DIR', '../img/');
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);

	$image1 = imagecreatefrompng($file);
	unlink($file);
}
else
{
	$image1 = imagecreatefrompng('img/imgtmp.png');
}
$image2 = imagecreatefrompng('../img/' . $filtre . '.png');
switch ($filtre)
{
	case 'bonnet':
		imagecopy($image1, $image2, 0, 0, 0,0, 475, 370);
		break;
	case 'ashe':
		imagecopy($image1, $image2, 0, 0, 0, 0, 500, 320);
		break;
	case 'kyouko':
		imagecopy($image1, $image2, 0, 0, 0,0, 495, 340);
		break;
	case 'ironman':
		imagecopy($image1, $image2, 0, 0, 0, 0, 500, 450);
		break;
}
imagepng($image1, 'image.png');

imagedestroy($image1);
imagedestroy($image2);

$image = base64_encode_img('image.png','png');
unlink('image.png');
echo $image;
?>
