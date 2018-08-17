<?php
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';

$id = $_POST['id'];
$tabela = 'ft_'.$_POST['tabela'];
$tabela = str_replace('#','_',$tabela);

$query = "DELETE FROM {$tabela} WHERE id='{$id}'" or die("Erro.." . mysqli_error($link_db));
$result = mysqli_query($link_db, $query);

echo $tabela;
?>
