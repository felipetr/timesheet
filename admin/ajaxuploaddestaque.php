<?php
session_start();
ini_set('display_errors', 1);
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include 'includes/funcoes.php';
include '../includes/arrays.php';
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
$path = 'uploads/'; // upload directory
$imagem = '0';
if(isset($_FILES['image']))
{
	$img = $_FILES['image']['name'];
	$tmp = $_FILES['image']['tmp_name'];
$getextensao = explode('.',$img);
	$extensao = end($getextensao);



	// get uploaded file's extension
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

	// can upload same image using rand function
	$final_image = date("Ymdhis").rand(1000,1000000).'.'.$extensao;

	// check's valid format
	if(in_array($ext, $valid_extensions))
	{
		$path = $path.strtolower($final_image);

		if(move_uploaded_file($tmp,$path))
		{
			$erro = 'sucesso';
			$imagem = strtolower($final_image);

		}
	}
	else
	{

	}
}

echo trim($imagem);

?>