<?php
if (!isset($config)){
  $config = include 'config/config.php';
  //TODO switch to array
  extract($config, EXTR_OVERWRITE);
}
include 'include/utils.php';

if ($_SESSION['ts_RF']["verify"] != "RESPONSIVEfilemanager")
{
	response(trans('forbiden').AddErrorLocation(), 403)->send();
	exit;
}

include 'include/mime_type_lib.php';

if (isset($_POST['path']))
{
   $storeFolder = $_POST['path'];
   $storeFolderThumb = $_POST['path_thumb'];
}
else
{
   $storeFolder = $current_path.$_POST["fldr"]; // correct for when IE is in Compatibility mode
   $storeFolderThumb = $thumbs_base_path.$_POST["fldr"];
}

$path_pos  = strpos($storeFolder,$current_path);
$thumb_pos = strpos($storeFolderThumb,$thumbs_base_path);

if ($path_pos!==0
	|| $thumb_pos !==0
	|| strpos($storeFolderThumb,'../',strlen($thumbs_base_path)) !== FALSE
	|| strpos($storeFolderThumb,'./',strlen($thumbs_base_path)) !== FALSE
	|| strpos($storeFolder,'../',strlen($current_path)) !== FALSE
	|| strpos($storeFolder,'./',strlen($current_path)) !== FALSE )
{
	response(trans('wrong path'.AddErrorLocation()))->send();
	exit;
}

$path = $storeFolder;
$cycle = TRUE;
$max_cycles = 50;
$i = 0;
while ($cycle && $i < $max_cycles)
{
	$i++;
	if ($path == $current_path) $cycle = FALSE;
	if (file_exists($path."config.php"))
	{
		require_once $path."config.php";
		$cycle = FALSE;
	}
	$path = fix_dirname($path).'/';
}


if ( ! empty($_FILES))
{
	$info = pathinfo($_FILES['file']['name']);
	$mime_type = get_file_mime_type($_FILES['file']['tmp_name']);
	$extension = get_extension_from_mime($mime_type);

	if($extension==='' || $extension=='so'){
		$extension = $info['extension'];
	}

	$extensao = 'erro';
	if ($extension == 'jpeg' || $extension == 'png' || $extension == 'gif' || $extension == 'jpg')
	{
		$extensao = 'valeu';
	}
	if ($extensao == 'valeu')
	{
	if (in_array(fix_strtolower($extension), $ext))
	{
		$tempFile = $_FILES['file']['tmp_name'];
		$targetPath = $storeFolder;
		$targetPathThumb = $storeFolderThumb;
		$_FILES['file']['name'] = fix_filename($info['filename'].".".$extension,$transliteration,$convert_spaces, $replace_with);
		// LowerCase
		if ($lower_case)
		{
			$_FILES['file']['name'] = fix_strtolower($_FILES['file']['name']);
		}
	 	// Gen. new file name if exists
		if (file_exists($targetPath.$_FILES['file']['name']))
		{
			$i = 1;
			$info = pathinfo($_FILES['file']['name']);

			// append number
			while(file_exists($targetPath.$info['filename']."_".$i.".".$extension)) {
				$i++;
			}
			$_FILES['file']['name'] = $info['filename']."_".$i.".".$extension;
		}
		function gen_slug($str){
			# special accents
			$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
			$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
			return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
		}

		$slug = gen_slug($info['filename']);

		$rename = $slug.date('YmdHis').'.'.$extension;
		$targetFile =  $targetPath. $rename;
		$targetFileThumb =  $targetPathThumb. $rename;

		// check if image (and supported)
		if (in_array(fix_strtolower($extension),$ext_img)) $is_img=TRUE;
		else $is_img=FALSE;

		if (!checkresultingsize($_FILES['file']['size'])) {
			response(sprintf(trans('max_size_reached'),$MaxSizeTotal).AddErrorLocation(), 406)->send();
			exit;
		}

		// upload
		move_uploaded_file($tempFile,$targetFile);
		chmod($targetFile, 0755);

		if ($is_img)
		{
			$memory_error = FALSE;
			if ( ! create_img($targetFile, $targetFileThumb, 122, 91))
			{
				$memory_error = FALSE;
			}
			else
			{
				// TODO something with this long function baaaah...
				if( ! new_thumbnails_creation($targetPath,$targetFile,$_FILES['file']['name'],$current_path,$relative_image_creation,$relative_path_from_current_pos,$relative_image_creation_name_to_prepend,$relative_image_creation_name_to_append,$relative_image_creation_width,$relative_image_creation_height,$relative_image_creation_option,$fixed_image_creation,$fixed_path_from_filemanager,$fixed_image_creation_name_to_prepend,$fixed_image_creation_to_append,$fixed_image_creation_width,$fixed_image_creation_height,$fixed_image_creation_option))
				{
					$memory_error = FALSE;
				}
				else
				{
					$imginfo = getimagesize($targetFile);
					$srcWidth = $imginfo[0];
					$srcHeight = $imginfo[1];

					// resize images if set
					if ($image_resizing)
					{
						if ($image_resizing_width == 0) // if width not set
						{
							if ($image_resizing_height == 0)
							{
								$image_resizing_width = $srcWidth;
								$image_resizing_height = $srcHeight;
							}
							else
							{
								$image_resizing_width = $image_resizing_height*$srcWidth/$srcHeight;
							}
						}
						elseif ($image_resizing_height == 0) // if height not set
						{
							$image_resizing_height = $image_resizing_width*$srcHeight/$srcWidth;
						}

						// new dims and create
						$srcWidth = $image_resizing_width;
						$srcHeight = $image_resizing_height;
						create_img($targetFile, $targetFile, $image_resizing_width, $image_resizing_height, $image_resizing_mode);
					}

					//max resizing limit control
					$resize = FALSE;
					if ($image_max_width != 0 && $srcWidth > $image_max_width && $image_resizing_override === FALSE)
					{
						$resize = TRUE;
						$srcWidth = $image_max_width;

						if ($image_max_height == 0) $srcHeight = $image_max_width*$srcHeight/$srcWidth;
					}

					if ($image_max_height != 0 && $srcHeight > $image_max_height && $image_resizing_override === FALSE){
						$resize = TRUE;
						$srcHeight = $image_max_height;

						if ($image_max_width == 0) $srcWidth = $image_max_height*$srcWidth/$srcHeight;
					}

					if ($resize) create_img($targetFile, $targetFile, $srcWidth, $srcHeight, $image_max_mode);
				}
			}

			// not enough memory
			if ($memory_error)
			{
				unlink($targetFile);
				response(trans("Not enought Memory").AddErrorLocation(), 406)->send();
				exit();
			}
		}
		echo $rename;
	} }
	else // file ext. is not in the allowed list
	{
		response(trans("Error_extension").AddErrorLocation(), 406)->send();
		exit();
	}
}
else // no files to upload
{
	response(trans("no file").AddErrorLocation(), 405)->send();
	exit();
}

// redirect
if (isset($_POST['submit']))
{
	$query = http_build_query(array(
		'type'	  	=> $_POST['type'],
		'lang'	  	=> $_POST['lang'],
		'popup'			=> $_POST['popup'],
		'field_id'  => $_POST['field_id'],
		'fldr'	  	=> $_POST['fldr'],
	));

	header("location: dialog.php?" . $query);
}
