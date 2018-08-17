<?php session_start();
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
//include 'funcoes.php';
//include '../../includes/arrays.php';
$login = $_POST['email'];
$senha = md5(md5($_POST['senha']));
$query = "SELECT * FROM ft_admin WHERE login = '$login' OR  email = '$login'";
$result = mysqli_query($link_db, $query);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0)
{
    echo 'Usuário ou senha inválidos!';
    exit();
}
while ($row = mysqli_fetch_array($result)) {

    if ( $row['senha'] != $senha)
    {
        echo 'Usuário ou senha inválidos!';
        exit();
    }
    if ( $row['ativo'] == 0)
    {
        echo 'Usuário inativo! Entre em contato com um administrador.';
        exit();
    }


    if ($row['avatar']=='')
    {
        $female = '';
        if($row['sexo']=='a')
        {
            $female = 'fe';
        }
        $row['avatar'] = $female.'male-default.jpg';
    }

    $_SESSION['ts_adm_nome'] = $row['nome'];
    $_SESSION['ts_adm_nivel'] = $row['nivel'];
    $_SESSION['ts_adm_sexo'] = $row['sexo'];
    $_SESSION['ts_adm_avatar'] = $row['avatar'];
    $_SESSION['ts_adm_id'] = $row['id'];

}