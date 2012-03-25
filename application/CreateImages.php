<?php
// Paths etant la liste des differents chemins
$paths = array();
$rpath = realpath(APPLICATION_PATH . '/../public/users');
$paths[] = $rpath.'/caroline/spring_013/photo1.JPG';
$paths[] = $rpath.'/caroline/spring_013/photo2.JPG';

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
	if ($info['extension'] == 'jpg' || $info['extension'] == 'JPG')
		$source = imagecreatefromjpeg($path);
	else if ($info['extension'] == 'png' || $info['extension'] == 'PNG')
		$source = imagecreatefrompng($path);
	else
		$source = imagecreatefromjpeg($path);
		
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
	imagejpeg($destination_full, $path_full, 100);
	imagejpeg($destination_thumb, $path_thumb, 100);
	
	// Destruction des objets temporaires
	imagedestroy($destination_full);
	imagedestroy($destination_thumb);
	imagedestroy($source);
}
?>