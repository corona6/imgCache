<?php

	// ファイル名を取得
	$imgFile = $_GET['f'];

	// 変換する画像の横幅
	$w = $_GET['w'];
	// 変換する画像の高さ	
	$h = $_GET['h'];
	// 変換する画像の画質
	$q = $_GET['q'];

	$foo = explode('/', $imgFile);

	$findimg = "./cache/".$foo[4].".jpeg";

	// cacheフォルダに画像があるかどうか探す
	if(file_exists($findimg)) {
		header("Content-Type: image/jpeg");
		readfile($findimg);
		// あれば停止し出力
		exit();
	}

	$imageInfo = getimagesize($imgFile);
	$mimeType = image_type_to_mime_type($imageInfo[2]);

	switch ($mimeType) {
		case 'image/jpg' :
		case 'image/jpeg' :
			$imageID = imagecreatefromjpeg($imgFile);
			break;
		case 'image/gif' :
			$imageID = imagecreatefromgif($imgFile);
			break;
		case 'image/png' :
			$imageID = imagecreatefrompng($imgFile);
			break;
		default ;
			die('Error : This file cannot convert.');
			break;
	}

	$width = ImageSX($imageID); 
	$height = ImageSY($imageID); 

	$new_width = $w;
	$rate = $new_width / $width; 
	$new_height = $rate * $height;

	$new_image = ImageCreateTrueColor($new_width, $new_height);

	ImageCopyResampled($new_image,$imageID,0,0,0,0,$new_width,$new_height,$width,$height);

	$foo = explode('/', $imgFile);

	$ppsj = "./cache/".$foo[4].".jpeg";

	// 出力	
	header("Content-Type: image/jpeg");
	imagejpeg($new_image, $ppsj, $q);
	imagejpeg($new_image, null, $q);

?>

