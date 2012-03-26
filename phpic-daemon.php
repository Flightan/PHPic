<?php

//Recherche des utilisateurs
//$path_users = realpath(APPLICATION_PATH . '/../public/users');
$path_users = realpath('./public/users/');

function getUserList ($dir)
{
	$users = array();

	while (false !== ($user_rep = readdir($dir)))
	{
		if ($user_rep != "." && $user_rep != "..")
		{
			if (is_dir($path_users.'/'.$user_rep))
			{
				$users[] = $user_rep;
			}
		}
	}
	return $users;
}

function prettySave ($simpleXML, $path)
{
	$dom = dom_import_simplexml($simpleXML)->ownerDocument;
	$dom->formatOutput = true;
	$dom->save($path);
}

function parseAlbumXML ($xml_album_path)
{
	$xml_album = simplexml_load_file($xml_album_path);
	foreach($xml_album->children() as $k=>$item)
	{
		if($k == "album")
		{
			$exists_albums[] = $item['title'][0];
		}
	}
	$suppr_album_path = array();
	//Parcour des dossier
	while (false !== ($album_rep = readdir($dir_user)))
	{
		if ($album_rep != "." && $album_rep != "..")
		{
			if (is_dir($user_path . "/" . $album_rep))
			{
				$suppr_album_path[] = $album_rep;
				if (in_array($album_rep, $exists_albums)) {
					//L'album exist déjà
					continue;
				}
				else {
					//add album dans le xml
					$new_album = $xml_album->addChild('album');
					$new_album->addAttribute('title', $album_rep);
					$new_album->addAttribute('scope', "public");
					prettySave($xml_album, $xml_album_path);
				}
			}
		}
	}
	//Comparaison des dossiers et du xml pour la suppression d'album
	foreach ($exists_albums as $suppr_alb)
	{
		if (!in_array($suppr_alb, $suppr_album_path))
		{
			foreach($xml_album->children() as $k=>$item)
			{
				if(($k == "album") && ($item['title'][0] == $suppr_alb))
				{
					$node = $xml_album->xpath("/collection/album[@title='" . $suppr_alb ."']");
					$suppNode = dom_import_simplexml($node[0]);
					$suppNode->parentNode->removeChild($suppNode);
					prettySave($xml_album, $xml_album_path);
					unset($exists_albums[array_search($suppr_alb, $exists_albums)]);
				}
			}
		}
	}
	//Parcour de chaque album
	foreach($exists_albums as $al)
	{
		$album_path = $user_path . "/" . $al;
		if ($dir_album = opendir($album_path))
		{
			$xml_photo_path = $album_path . "/photo.xml";
			//Test l'existance du photo.xml de l'album
			if (file_exists($xml_photo_path))
			{
				$xml_photo = simplexml_load_file($xml_photo_path);
				$exists_photo = array();
				//Parcours du xml pour recuperer les photo éxistante
				foreach($xml_photo->children() as $k=>$item)
				{
					if($k == "picture")
					{
						$exists_photo[] = $item['url'][0];
					}
				}
				//Array des chemins pour la création des miniatures
				$thumbnail_paths = array();
				$suppr_photo_path = array();
				//Recuperation des chemin des photos
				while (false !== ($photo_rep = readdir($dir_album)))
				{
					if ($photo_rep != "." && $photo_rep != "..")
					{
						if (is_dir($album_path . "/" . $photo_rep))
						{
							continue;
						} else {
							if ($photo_rep != "photo.xml") {
								$suppr_photo_path[] = $photo_rep;
								if (in_array($photo_rep, $exists_photo))
								{
									//La photo éxiste déjà
									continue;
								} else {
									//add photo dans la liste des chemins pour les miniature
									$new_photo = $xml_photo->addChild('picture');
									$new_photo->addAttribute('url', $photo_rep);
									prettySave($xml_photo, $xml_photo_path);
									$thumbnail_paths[] = $album_path . "/" . $photo_rep;
								}
							}
						}
					}
				}
				//Comparaison des fichier et du photo.xml pour la suppression
				foreach ($exists_photo as $suppr)
				{
					if (!in_array($suppr, $suppr_photo_path))
					{
						foreach($xml_photo->children() as $k=>$item)
						{
							if(($k == "picture") && ($item['url'][0] == $suppr))
							{
								$node = $xml_photo->xpath("/album/picture[@url='" . $suppr ."']");
								$suppNode = dom_import_simplexml($node[0]);
								$suppNode->parentNode->removeChild($suppNode);
								prettySave($xml_photo, $xml_photo_path);
							}
						}
					}
				}
				//Call miniature fonction param = $thumbnail_paths
					
				foreach ($thumbnail_paths as $path)
				{
					// Je retrouve le nom du fichier avec l'extension
					$filename = basename($path);
					$info = pathinfo($filename);

					// Je prend le nom du fichier sans l'extension qui ell est peut etre trouvee d'apres $info['extension']
					//$filename =  basename($filename,'.'.$info['extension']);

					// J'essaye d'avoir tout le chemin jusqu'au dernier repertoire c-a-d sans le nom du fichier
					$dirname = dirname($path);

					// Je cree mon objet source qui contient l'image originale
					switch (strtolower($info['extension']))
					{
						case 'jpg':
						case 'jpeg':
							$source = imagecreatefromjpeg($path);
							break;
						case 'png':
							$source = imagecreatefrompng($path);
							break;
						case 'gif':
							$source = imagecreatefromgif($path);
							break;
						default:
							$source = imagecreatefromjpeg($path);
					}

					// Je prend les dimensions de l'image
					list($width, $height) = getimagesize($path);

						
					if ($width > $height)
					{
						$width_full = 800;
						$height_full = 600;
						$width_thumb = 220;
						$height_thumb = 165;
						$cropWidth_thumb = 220;
						$cropHeight_thumb = 165;
					}
					else
					{
						$width_full = 600;
						$height_full = 800;
						$width_thumb = 250;
						$height_thumb = 330;
						$cropWidth_thumb = 220;
						$cropHeight_thumb = 165;
					}

					// Creation des images de destination
					$destination_full = imagecreatetruecolor($width_full, $height_full);
					$destination_thumb = imagecreatetruecolor($cropWidth_thumb, $cropHeight_thumb);

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

					switch (strtolower($info['extension']))
					{
						case 'jpg':
						case 'jpeg':
							imagejpeg($destination_full, $path_full, 100);
							imagejpeg($destination_thumb, $path_thumb, 100);
							break;
						case 'png':
							imagepng($destination_full, $path_full, 100);
							imagepng($destination_thumb, $path_thumb, 100);
							break;
						case 'gif':
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

			} else {
				//Ajout de l'xml photo si il n'éxiste pas
				$root_node = "<album></album>";
				$new_xml = new SimpleXMLElement($root_node);
				$new_xml->AddAttribute('theme', 'nature');
				$new_xml->AddAttribute('display', 'compact');
				prettySave($xml_photo, $xml_photo_path);
			}
		}
	}
}

if ($dir = opendir($path_users))
{
	$users = getUserList($dir);

	// Parcour des dossier utilisateur
	foreach($users as $us)
	{
		$user_path = $path_users.'/'.$us;
		if ($dir_user = opendir($user_path))
		{
			$xml_album_path = $user_path . "/album.xml";
			$exists_albums = array();
			//Test si le xml album exist, parcour du xml
			if (file_exists($xml_album_path))
			{
				parseAlbumXML($xml_album_path);
			} else {
				$root_node = "<collection></collection>";
				$new_xml = new SimpleXMLElement($root_node);
				prettySave($xml_album, $xml_album_path);
			}
		}
	}
}