<?php

// Paths etant la liste des differents chemins
$paths = array();
//$rpath = realpath(APPLICATION_PATH . '/../public/users');
$rpath = './public/users';
$paths[] = $rpath.'/caroline/spring_013/photo1.JPG';
$paths[] = $rpath.'/caroline/spring_013/photo2.JPG';
$paths[] = $rpath.'/caroline/summer_013/photo3.JPG';
$paths[] = $rpath.'/caroline/summer_013/photo4.JPG';
$paths[] = $rpath.'/caroline/winter_013/photo1.JPG';
$paths[] = $rpath.'/caroline/winter_013/photo2.JPG';
$paths[] = $rpath.'/gwenael/spring_014/photo1.JPG';
$paths[] = $rpath.'/gwenael/spring_014/photo2.JPG';
$paths[] = $rpath.'/gwenael/summer_014/photo1.JPG';
$paths[] = $rpath.'/gwenael/summer_014/photo2.JPG';
$paths[] = $rpath.'/gwenael/winter_014/photo1.JPG';
$paths[] = $rpath.'/gwenael/winter_014/photo2.JPG';
$paths[] = $rpath.'/jean-charle/spring_015/photo1.JPG';
$paths[] = $rpath.'/jean-charle/spring_015/photo2.JPG';
$paths[] = $rpath.'/jean-charle/summer_015/photo1.JPG';
$paths[] = $rpath.'/jean-charle/summer_015/photo2.JPG';
$paths[] = $rpath.'/jean-charle/winter_015/photo1.JPG';
$paths[] = $rpath.'/jean-charle/winter_015/photo2.JPG';

foreach ($paths as $path)
{
	// Je retrouve le nom du fichier avec l'extension
	$filename = basename($path);
	$info = pathinfo($filename);
	
	// Je prend le nom du fichier sans l'extension qui ell est peut etre trouvee d'apres $info['extension']
	//$filename =  basename($filename,'.'.$info['extension']);
	
	// J'essaye d'avoir tout le chemin jusqu'au dernier repertoire c-a-d sans le nom du fichier
	$dirname = dirname($path);
	
	// Je cree mon objet source qui contient l'image originale
	switch ($info['extension'])
	{
		case 'jpg':
		case 'JPG': 
			$source = imagecreatefromjpeg($path); 
			break;
		case 'png':
		case 'PNG': 
			$source = imagecreatefrompng($path); 
			break;
		case 'gif': 
		case 'GIF':
			$source = imagecreatefromgif($path); 
			break;
		default: 
			$source = imagecreatefromjpeg($path);
	}
		
	// Je prend les dimensions de l'image	
	list($width, $height) = getimagesize($path); 
	
	// VALEURS A MODIFIER - CECI EST UN EXEMPLE
	if ($width > $height)
	{
		$width_full = 800;
		$height_full = 600;
		$width_thumb = 80;
		$height_thumb = 60;
	}
	else
	{
		$width_full = 600;
		$height_full = 800;
		$width_thumb = 60;
		$height_thumb = 80;
	}

	// Creation des images de destination
	$destination_full = imagecreatetruecolor($width_full, $height_full);
	$destination_thumb = imagecreatetruecolor($width_thumb, $height_thumb);
	
	// Redimensionnement
	imagecopyresized($destination_full, $source, 0, 0, 0, 0, $width_full, $height_full, $width, $height);
	imagecopyresized($destination_thumb, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height);
	
	$dir_for_full = $dirname.'/full';
	// On verifie l'existance du repertoire qui va contenir les images (full size) - On le cree s'il n'existe pas
	if (!file_exists($dir_for_full))
		mkdir($dir_for_full, 0755);
		
	$dir_for_thumbs = $dirname.'/thumbnails';
	// On verifie l'existance du repertoire qui va contenir les images (thumbnails) - On le cree s'il n'existe pas
	if (!file_exists($dir_for_thumbs))
		mkdir($dir_for_thumbs, 0755);
	
	// Copie des images sur le disque
	$path_full = $dir_for_full.'/'.$filename;
	$path_thumb = $dir_for_thumbs.'/'.$filename;

	switch ($info['extension'])
	{
		case 'jpg':
		case 'JPG': 
			imagejpeg($destination_full, $path_full, 100);
			imagejpeg($destination_thumb, $path_thumb, 100); 
			break;
		case 'png':
		case 'PNG': 
			imagepng($destination_full, $path_full, 100);
			imagepng($destination_thumb, $path_thumb, 100);
			break;
		case 'gif': 
		case 'GIF':
			imagegif($destination_full, $path_full);
			imagegif($destination_thumb, $path_thumb);
			break;
		default:
			imagejpeg($destination_full, $path_full, 100);
			imagejpeg($destination_thumb, $path_thumb, 100); 
	}
	
	// Destruction des objets temporaires
	imagedestroy($destination_full);
	imagedestroy($destination_thumb);
	imagedestroy($source);
}

//NOT BEING USED
function fastimagecopyresampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3) {
  // Plug-and-Play fastimagecopyresampled function replaces much slower imagecopyresampled.
  // Just include this function and change all "imagecopyresampled" references to "fastimagecopyresampled".
  // Typically from 30 to 60 times faster when reducing high resolution images down to thumbnail size using the default quality setting.
  // Author: Tim Eckel - Date: 09/07/07 - Version: 1.1 - Project: FreeRingers.net - Freely distributable - These comments must remain.
  //
  // Optional "quality" parameter (defaults is 3). Fractional values are allowed, for example 1.5. Must be greater than zero.
  // Between 0 and 1 = Fast, but mosaic results, closer to 0 increases the mosaic effect.
  // 1 = Up to 350 times faster. Poor results, looks very similar to imagecopyresized.
  // 2 = Up to 95 times faster.  Images appear a little sharp, some prefer this over a quality of 3.
  // 3 = Up to 60 times faster.  Will give high quality smooth results very close to imagecopyresampled, just faster.
  // 4 = Up to 25 times faster.  Almost identical to imagecopyresampled for most images.
  // 5 = No speedup. Just uses imagecopyresampled, no advantage over imagecopyresampled.

  if (empty($src_image) || empty($dst_image) || $quality <= 0) { return false; }
  if ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
    $temp = imagecreatetruecolor ($dst_w * $quality + 1, $dst_h * $quality + 1);
    imagecopyresized ($temp, $src_image, 0, 0, $src_x, $src_y, $dst_w * $quality + 1, $dst_h * $quality + 1, $src_w, $src_h);
    imagecopyresampled ($dst_image, $temp, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $dst_w * $quality, $dst_h * $quality);
    imagedestroy ($temp);
  } else imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
  return true;
}
