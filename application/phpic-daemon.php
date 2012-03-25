<?php

/*while (true)
{*/
	//Parcour des dossier pour ajout des photo/album sur le site, suite a une upload.
	//parcour de dossier utilisateur
	//traitement xml user, retour liste album, vérification album a ajouté
	//parcour dosier album
	//traitement xml album, retour liste de photo, vérification photo a ajouté	$xml = simplexml_load_file("album.xml");
	
	if ($dir = opendir("users/"))
	{
		$users = array();
		while (false !== ($user_rep = readdir($dir)))
		{
			if ($user_rep != "." && $user_rep != "..")
			{
				if (is_dir("users/" . $user_rep))
				{
					$users[] = $user_rep;
				}
			}
		}
		foreach($users as $us)
		{
			$user_path = "users/" . $us;
			if ($dir_user = opendir($user_path))
			{
				echo "USER: " . $us . "<br>";
				$xml_album_path = $user_path . "/album.xml";			
				$xml_album = simplexml_load_file($xml_album_path);
				$exists_albums = array();
				if ($xml_album != false)
				{
					foreach($xml_album->children() as $k=>$item)
					{
						if($k == "album")
						{
							$exists_albums[] = $item['title'][0];
						}
					}
					echo "ALREADY ALBUMS: " . print_r($exists_albums) . "<br>";
					//$albums = array();
					while (false !== ($album_rep = readdir($dir_user)))
					{
						if ($album_rep != "." && $album_rep != "..")
						{
							if (is_dir($user_path . "/" . $album_rep))
							{
								if (in_array($album_rep, $exists_albums)) {
									echo "album: " . $album_rep . " already exist<br>";
									continue;
								}
								else {
									//add album
									echo "add album: " . $album_rep . "<br>";
								}
							}
						}
					}
					foreach($exists_albums as $al)
					{
						$album_path = $user_path . "/" . $al;
						if ($dir_album = opendir($album_path))
						{
							$xml_photo_path = $album_path . "/photo.xml";
							$xml_photo_path = utf8_encode($xml_photo_path);
							$xml_photo = simplexml_load_file($xml_photo_path);
							$exists_photo = array();
							foreach($xml_photo->children() as $k=>$item)
							{
								if($k == "picture")
								{
									$exists_photo[] = $item['url'][0];
								}
							}
							while (false !== ($photo_rep = readdir($dir_album)))
							{
								if ($photo_rep != "." && $photo_rep != "..")
								{
									if (is_dir($dir_album . "/" . $photo_rep))
									{
										continue;
									} else {
										if ($photo_rep != "photo.xml") {
											if (in_array($photo_rep, $exists_photo))
											{
												echo "photo: " . $photo_rep . " already exist<br>";
												continue;
											} else {
												//add photo
												echo "add photo: " . $photo_rep . " in " . $al . "<br>";
											}
										}
									}
								}
							}
						}
					}
				} else {
					while (false !== ($album_rep = readdir($dir_user)))
					{
						if ($album_rep != "." && $album_rep != "..")
						{
							if (is_dir($user_path . "/" . $album_rep))
							{
								//add album
								echo "Ajouter l'album: " . $album_rep . "<br>";
							}
						}
					}
				}
			}
		}		
	}
	
	
	
	//
	/*sleep (30);
}*/

?>