<?php

session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
	$redirect = "login";

	header("location:$redirect");
}

include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
include 'funcoes.php';

$linkatual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$linkatual = str_replace('.php', '', $linkatual);
$confirmabarra = substr($linkatual, -1);
if ($confirmabarra == '/') {
	$linkatual = substr($linkatual, 0, -1);
}
$arraylink = explode('/', $linkatual);

$pagslug = end($arraylink);
$funcao = 'novapag';

$queryint = "SELECT * FROM ft_paginas WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
	$titulo = 'Nova Página';
	if ($pagslug != 'nova') {
		$redirect = $baseurl . '/admin/pagina.php/nova';
		header("location:$redirect");
		exit();
	}
}
while ($row = mysqli_fetch_array($queryint)) {


	$pagina = $row;
	$titulo = 'Editar Página';
	$funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/paginas/"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-plus"></i> Salvar</a>';
$ativo = '1';
include 'includes/header.php';


?>

<div class="contentbox">
	<h2 class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h2>
</div>
<?php include 'includes/footer.php';


if ($_POST['titulo']) {

	$titulo = $_POST['titulo'];
	$conteudo = $_POST['conteudo'];
	$slug = ft_slug($titulo);



	$queryint = "SELECT * FROM ft_paginas WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

	$queryint = mysqli_query($link_db, $queryint);
	$rowcount = mysqli_num_rows($queryint);



	if($rowcount > 0)
	{
		$slug .= '-'.$rowcount;
	}

	$erro = 'Erro ao salvar! Tente novamente mais tarde!';

	$sql = "INSERT INTO ft_paginas (
               titulo,
               conteudo,
               slug
            )
            VALUES
            (
               '$titulo',
               '$conteudo',
               '$slug'
            )" or die("Erro.." . mysqli_error($link_db));
	$result = mysqli_query($link_db, $sql);

	$erro = $sql;
	if ($result)
	{?>
		<META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/pagina.php/<?php echo $slug; ?>">
		<?php
	}
}
?>



