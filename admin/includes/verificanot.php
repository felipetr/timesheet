<?php
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';








$msg = 'false';

$queryint = "SELECT * FROM ft_orcamentos WHERE visualizado = 0" or die("Erro.." . mysqli_error($link_db));

$queryint = mysqli_query($link_db, $queryint);

$total = mysqli_num_rows($queryint);

if ($total != 0)
{

	$msg = 	$total;


}

echo $msg;
?>