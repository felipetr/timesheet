<?php
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
include '../../includes/funcoes.php';
include 'funcoes.php';
include '../../includes/arrays.php';


$titulo = $_POST['nome'];
$id = $_POST['id'];


$query = mysqli_query($link_db, "UPDATE ft_banners_categoria SET nome = '{$titulo}'  WHERE  id={$id}") or die("Erro " . mysqli_error($link_db));



echo $titulo;

