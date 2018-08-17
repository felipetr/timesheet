<?php
session_start();
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include 'includes/funcoes.php';
include '../includes/arrays.php';
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
$path = 'avatar/'; // upload directory
$imagem = '';
$erro = 'Erro ao enviar imagem!';
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
			$id_user = $_SESSION['ts_adm_id'];
			$_SESSION['ts_adm_avatar'] = $imagem;
			$query = mysqli_query($link_db, "UPDATE ft_admin SET avatar = '$imagem'  WHERE  id='$id_user'") or die("Erro " . mysqli_error($link_db));
		}
	}
	else
	{

	}
}

echo '<div id="mensagem">'.$erro.'</div>';
echo '<div id="imagem">'.$baseurl.'/admin/avatar/'.$imagem.'</div>';

?>