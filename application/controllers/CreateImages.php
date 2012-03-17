<?php
// Paths etant la liste des differents chemins
$paths = '';

foreach ($paths as $path)
{
	// Je retrouve le nom du fichier avec l'extension
	$filename = basename($path).PHP_EOL;
	$info = pathinfo($filename);
	
	// Je prend le nom du fichier sans l'extension qui ell est peut etre trouvee d'apres $info['extension']
	$filename =  basename($file,'.'.$info['extension']);
	
	// J'essaye d'avoir tout le chemin jusqu'au dernier repertoire c-a-d sans le nom du fichier
	$dirname = dirname($path);
	
	// Je cree mon objet source qui contient l'image originale
	if ($info['extension'] == 'jpg')
		$source = imagecreatefromjpeg(path);
	else if ($info['extension'] == 'png')
		$source = imagecreatefrompng(path);
		
	// Je prend les dimensions de l'image	
	list($width, $height) = getimagesize(path); 
	
	// VALEURS A MODIFIER - CECI EST UN EXEMPLE
	if ($width > $height)
	{
		$width_full = 800;
		$height_full = 600;
		$width_thumb = 60;
		$height_thumb = 40;
	}
	else
	{
		$width_full = 600;
		$height_full = 800;
		$width_thumb = 40;
		$height_thumb = 60;
	}

	// Creation des images de destination
	$destination_full = imagecreatetruecolor($width_full, $height_full);
	$destination_thumb = imagecreatetruecolor($width_thumb, $height_thumb);
	
	// Redimensionnement
	imagecopyresized($destination_full, $source, 0, 0, 0, 0, $width_full, $height_full, $width, $height);
	imagecopyresized($destination_thumb, $source, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height);
	
	// Copie des images sur le disque
	$path_full = $dirname.'/'.$filename.'_full.'.$info['extension'];
	$path_thumb = $dirname.'/'.$filename.'_thumb.'.$info['extension'];
	imagejpeg($destination_full, $path_full, 100);
	imagejpeg($destination_thumb, $path_thumb, 100);
	
	// Destruction des objets temporaires
	imagedestroy($destination_full);
	imagedestroy($destination_thumb);
	imagedestroy($source);
	
	// ICI FAUDRA STOCKER $path_full et $path_thumb DANS LE FICHIER XML
}
?>