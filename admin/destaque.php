<?php
include '../includes/configuracoes.php';
include '../includes/conectar.php';

$tabela = 'ft_'.$_POST['tabela'];
$id = $_POST['id'];
$status = intval($_POST['status']);

$query = mysqli_query($link_db, "UPDATE {$tabela} SET destaque = {$status}  WHERE  id={$id}") or die("Erro " . mysqli_error($link_db));

if ($status == 0)
{
	echo 'des';
}
echo 'ativado';
?>