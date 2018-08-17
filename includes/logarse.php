<?php
session_start();
include 'configuracoes.php';
include 'conectar.php';

$login = $_POST['login'];
$senha = md5(md5($_POST['senha']));

$query = "SELECT * FROM ft_users WHERE login = '{$login}' OR  email = '{$login}'";
$result = mysqli_query($link_db, $query);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0)
{
    echo 'Usuário ou senha inválidos!';
    exit();
}
while ($row = mysqli_fetch_array($result)) {

    if ( $row['password'] != $senha)
    {
        echo 'Usuário ou senha inválidos!';
        exit();
    }



    $_SESSION['ts_nome'] = $row['name'];
    $_SESSION['ts_hash'] = $row['hash'];
    $_SESSION['ts_sexo'] = $row['sexo'];
    $_SESSION['ts_id'] = $row['id'];

    echo 'Redirecionando...';
}


?>
