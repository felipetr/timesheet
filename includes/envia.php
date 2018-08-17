<?php
session_start();
include 'conectar.php';

$email = $_POST['email'];


$query = "SELECT * FROM ft_users WHERE email = '{$email}''";
$result = mysqli_query($link_db, $query);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0)
{
    echo 'Usuário ou senha inválidos!';
    exit();
}
while ($row = mysqli_fetch_array($result)) {

    $hash = $row['hash'];
    $nome = $row['name'];
    $usemail = $row['email'];


    $noreply = 'gestaoweb@stoledo.com.br';

    $titulo = 'Recuperação de Senha';
$corpo ='<p>Ola, '.$nome.'</p>';
$corpo .='Foi solicitada a recuperaçao da senha de uma conta ligada aa seu email!<br>';
$corpo .='Acesse o link abaixo para redefinir sua senha:';
$corpo .='<p>http://gerens.com/timesheet/recadastrar.php?hash='.$hash.'</p>';
$corpo .='<p>Caso você não tenha solicitado essa recuperação, favor ignorar esta mensagem</p>';
$corpo .='<p>Equipe Gerens</p>';



$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: ".$noreply."\r\n"; // remetente
$headers .= "Return-Path: ".$noreply."\r\n"; // return-path


@$envio = mail($usemail, $titulo, $corpo, $headers);

    if ($envio)
    {
        echo 'Email Enviado';
    }
    else
    {
        echo 'Email nenviado';
    }
}



?>
