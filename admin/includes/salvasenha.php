<?php
session_start();
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';

$senha = md5(md5($_POST['senha']));
$iduser = $_POST['iduser'];
$hash = $_POST['hash'];



$query = "SELECT * FROM ft_admin WHERE id = '{$iduser}' AND senha = '{$hash}'" or die("Erro.." . mysqli_error($link_db));


$result = mysqli_query($link_db, $query);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0)
{
    echo 'erro';
    exit();
}


$query = mysqli_query($link_db, "UPDATE ft_admin SET senha = '{$senha}'  WHERE  id= '{$iduser}' ") or die("Erro " . mysqli_error($link_db));




echo 'Senha Alterada';

?>