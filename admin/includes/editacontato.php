<?php

include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
include '../../includes/funcoes.php';
include 'funcoes.php';
include '../../includes/arrays.php';


$email = $_POST['email'];
$telefone = $_POST['telefone'];
$rua = $_POST['rua'];
$num = $_POST['num'];
$loja = $_POST['loja'];
$bairro = $_POST['bairro'];
$comp = $_POST['comp'];
$cidade = $_POST['cidade'];
$uf = $_POST['uf'];
$cep = $_POST['cep'];
$facebook = $_POST['facebook'];
$instagram = $_POST['instagram'];
$twitter = $_POST['twitter'];
$linkedin = $_POST['linkedin'];
$whatsapp = $_POST['whatsapp'];
$titulo = $_POST['titulo'];
$description = $_POST['description'];
$keywords = $_POST['keywords'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$fbimg = $_POST['fbimg'];



$query = mysqli_query($link_db, "UPDATE ft_config SET email = '{$email}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET telefone = '{$telefone}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET rua = '{$rua}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET num = '{$num}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET loja = '{$loja}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET bairro = '{$bairro}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET complemento = '{$comp}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET cidade = '{$cidade}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET uf = '{$uf}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET cep = '{$cep}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET facebook = '{$facebook}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET instagram = '{$instagram}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET twitter = '{$twitter}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET linkedin = '{$linkedin}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET whatsapp = '{$whatsapp}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET titulo = '{$titulo}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET description = '{$description}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET keywords = '{$keywords}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET lat = '{$lat}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET lng = '{$lng}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_config SET fbimg = '{$fbimg}'  WHERE  id=1") or die("Erro " . mysqli_error($link_db));

echo 'Salvo!';






