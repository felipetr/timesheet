<?php
session_start();
include 'configuracoes.php';
include 'conectar.php';

$senha = md5($_POST['senha']);
$token = $_POST['token'];







$query = "SELECT * FROM ft_usuario WHERE token = '{$token}'" or die("Erro.." . mysqli_error($link_db));


$result = mysqli_query($link_db, $query);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0)
{
    echo 'erro';
    exit();
}

$query = mysqli_query($link_db, "UPDATE ft_usuario SET senha = '{$senha}'  WHERE  token= '{$token}' ") or die("Erro " . mysqli_error($link_db));
echo 'Senha Alterada';

?>