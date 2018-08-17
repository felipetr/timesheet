<?php
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
include '../../includes/funcoes.php';
include 'funcoes.php';
include '../../includes/arrays.php';


$id = $_POST['id'];


$query = mysqli_query($link_db, "UPDATE ft_orcamentos SET visualizado = 2  WHERE  id={$id}") or die("Erro " . mysqli_error($link_db));