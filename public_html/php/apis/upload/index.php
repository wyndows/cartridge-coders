<?php

if (isset($_FILES['image']['name']))
{
	$user = $_POST['user'];
	$saveto = "/var/www/html/public_html/cartridge-coders/" . "product" . $productId. "jpg";
	move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
	$typeok = TRUE;

	switch($_FILES['image']['type'])
	{
		case "image/gif":   $src = imagecreatefromgif($saveto); break;
		case "image/jpeg":  // Both regular and progressive jpegs
		case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
		case "image/png":   $src = imagecreatefrompng($saveto); break;
		default:            $typeok = FALSE; break;
	}

	if ($typeok)
	{
		list($w, $h) = getimagesize($saveto);

		$max = 100;
		$tw  = $w;
		$th  = $h;

		if ($w > $h && $max < $w)
		{
			$th = $max / $w * $h;
			$tw = $max;
		}
		elseif ($h > $w && $max < $h)
		{
			$tw = $max / $h * $w;
			$th = $max;
		}
		elseif ($max < $w)
		{
			$tw = $th = $max;
		}

		$tmp = imagecreatetruecolor($tw, $th);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
		imageconvolution($tmp, array(array(-1, -1, -1),
			array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
		imagejpeg($tmp, $saveto);
		imagedestroy($tmp);
		imagedestroy($src);
	}
}

//showProfile($user);

echo <<<_END
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title></title>
  </head>
  <body>
   <form method='post' action='index.php' enctype='multipart/form-data'>
	<h3>upload an image</h3>
	User: <input type='text' name='user'> 
	Image: <input type='file' name='image' size='14'>
	<input type='submit' value='Save Profile'>
</form>
  </body>
</html>
_END;
?>