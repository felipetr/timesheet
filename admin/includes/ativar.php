<?php
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';

$status = $_POST['status'];
$tabela = $_POST['tabela'];
$id = $_POST['id'];

$sql = "UPDATE ft_".$tabela." SET ativo = '{$status}'  WHERE  id={$id}";
$query = mysqli_query($link_db, $sql) or die("Erro " . mysqli_error($link_db));

?>