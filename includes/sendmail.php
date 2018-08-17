
<?php
include 'configuracoes.php';
include 'conectar.php';

$nome = $_POST['nome'];
$remetente = $_POST['email'];
$destinatario = $config['email'];
$servico = $_POST['servico'];

@$socio = $_POST['socio'];
if ($socio) {
    $queryint = "SELECT * FROM ft_socios WHERE slug =  '{$socio}'" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    while ($servico = mysqli_fetch_array($queryint)) {
        $destinatario = $servico['email'];
    }
}
@$telefone = $_POST['telefone'];
$msg = $_POST['mensagem'];
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\n";
$headers .= "From: Gerens <naoresponda@gerens.com.br>\r\n"; // remetente
$headers .= "Return-Path: " . $nome . " <" . $remetente . ">\r\n"; // return-path
$assunto = "Contato do Site";
$mensagem = '<h1>Contato do Site</h1>';
if ($servico){
$mensagem = '<b>Vindo da página de '.$servico.'</b><br>';
    }
$mensagem .= '<b>Nome: </b>' . $nome . '<br>';
$mensagem .= '<b>Email: </b>' . $remetente . '<br>';
if ($telefone) {
    $mensagem .= '<b>Telefone: </b>' . $telefone . '<br>';
}
$mensagem .= '<b>Mensagem: </b><p>' . $msg . '</p>';
$envio = mail($destinatario, $assunto, $mensagem, $headers);
if ($envio) {
    echo 'Mensagem enviada com sucesso.';
} else {
    echo 'Erro no envio da mensagem. Por favor, tente mais tarde.';
} ?>