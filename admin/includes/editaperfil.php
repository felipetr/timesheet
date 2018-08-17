<?php
session_start();

include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
include '../../includes/funcoes.php';
include 'funcoes.php';
include '../../includes/arrays.php';


$nome = $_POST['nome'];
$email = $_POST['email'];
@$senha = $_POST['senha'].'';
$sexo = $_POST['sexo'];
$id = $_SESSION['ts_adm_id'];



$query = mysqli_query($link_db, "UPDATE ft_admin SET nome = '{$nome}'  WHERE  id={$id}") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_admin SET email = '{$email}'  WHERE  id={$id}") or die("Erro " . mysqli_error($link_db));
$query = mysqli_query($link_db, "UPDATE ft_admin SET sexo = '{$sexo}'  WHERE  id={$id}") or die("Erro " . mysqli_error($link_db));





$_SESSION['ts_adm_nome'] = $nome;
$_SESSION['ts_adm_sexo'] = $sexo;


if ($_SESSION['ts_adm_avatar']=='male-default.jpg' OR $_SESSION['ts_adm_avatar']=='female-default.jpg')
{
    $female = '';
    if($_SESSION['ts_adm_sexo']=='a')
    {
        $female = 'fe';
    }
    $_SESSION['ts_adm_avatar'] = $female.'male-default.jpg';
}
echo  $baseurl.'/admin/avata/'.$_SESSION['ts_adm_avatar'];
