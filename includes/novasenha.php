<?php
include 'configuracoes.php';
include 'conectar.php';
include 'funcoes.php';

$cnpj = $_POST['cnpj'];
$email = $_POST['email'];

$today = date("YmdHis");


$user = 'none';

$query = "SELECT * FROM ft_usuario WHERE  email  = '$email' OR  cnpj  = '$cnpj'" or die("Erro.." . mysqli_error($link_db));
$result = mysqli_query($link_db, $query);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0)
{
        echo 'Usuário não encontrado!';
    exit();
}


while ($row = mysqli_fetch_array($result)) {
    $user = $row;
}

$token = md5($today.$user['senha']);

$query = mysqli_query($link_db, "UPDATE ft_usuario SET token = '{$token}'  WHERE  id = '{$user['id']}' ") or die("Erro " . mysqli_error($link_db));






require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';

$mail = new PHPMailer();
$mail->setLanguage('pt');

//Variaveis de configuração do servidor do GMAIL

$host     = $config['smtp_host'];

$username = $config['smtp_user'];
$password = $config['smtp_pass'];
$port     = intval($config['smtp_port']);
$secure   = 'tls';

$msg = 'Olá, '.$user['responsavel'].'.<br><br>';

$msg .= 'Foi solicitada a recuperação de uma conta ligada a este email no site da <b>JC EPI\'s</b>.';
$msg .= 'Para gerar uma nova senha, acesse o link abaixo:<br><br>';
$msg .= $baseurl.'/redefinirsenha.php?hash='.$token;
$msg .= "<br><br>Atenciosamente, Equipe JC EPI's";







$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth   = true;
$mail->Username   = $username;
$mail->Password   = $password;
$mail->Port       = $port;
$mail->SMTPSecure = $secure;

$mail->From       = 'naoresponda@jcepis.com.br';
$mail->FromName   = 'JC EPIS';

$mail->addAddress($user['email'], $user['razao']);

$mail->addReplyTo($config['email'], $config['titulo']);

$mail->isHTML(true);
$mail->CharSet     = 'utf-8';
$mail->WordWrap    = 70;

// Exemplos de texto para o e-mail com HTML e sem.

$mail->Subject     = 'Recuperação de senha';
$mail->Body        = $msg;
$mail->AltBody      = $msg;

// Faz a validação se a mensagem foi enviada para o servidor.
$send = $mail->Send();

if($send)
    echo 'E-mail enviado com sucesso!';
else
    echo $mail->ErrorInfo;

?>