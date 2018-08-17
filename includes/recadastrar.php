<?php
session_start();
include 'configuracoes.php';
include 'conectar.php';

$senha = md5(md5($_POST['senha']));
$hash = $_SESSION['ts_hash'];


$query = mysqli_query($link_db, "UPDATE ft_users SET password = '{$senha}'  WHERE  hash='{$hash}'") or die("Erro " . mysqli_error($link_db));

$newhash = md5($_POST['senha'].date("Y-m-d H:i:s"));


$_SESSION['ts_hash'] = $newhash;

$query = mysqli_query($link_db, "UPDATE ft_users SET hash = '{$newhash}'  WHERE  hash='{$hash}'") or die("Erro " . mysqli_error($link_db));

echo 'Salvando...';
?>
