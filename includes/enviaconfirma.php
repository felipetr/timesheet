<?php
$email     = $_POST['email'];
$nome = $_POST['nome'];



include 'configuracoes.php';
include 'conectar.php';


// Os arquivos do PHPMailer foram extraidos na pasta /mail

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
$responsavel = explode(' ', $_POST['nome']);
$token = md5($_POST['email']);


$corpo = '<p>Olá, <b>'.$responsavel[0].'</b>;</p>';
$corpo .= "<p>Seu cadastro no site <b>JC EPI's</b> foi efetuado com sucesso.</p>";
$corpo .= "<p>Para finalizar clique no link abaixo e cadastre sua senha:</p>";
$corpo .= "<p>".$baseurl."/redefinirsenha.php?hash=".$token."</p>";
$corpo .= "<p>A JP EPI's agradece o seu contato.</p>";

$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth   = true;
$mail->Username   = $username;
$mail->Password   = $password;
$mail->Port       = $port;
$mail->SMTPSecure = $secure;

$mail->From       = $config['email'];
$mail->FromName   = $config['titulo'];
$mail->addReplyTo($config['email'], $config['titulo']);

$mail->addAddress($config['email'], $config['titulo']);
//$mail->addAddress($_POST['email'], $_POST['nome']);

$mail->isHTML(true);
$mail->CharSet     = 'utf-8';
$mail->WordWrap    = 70;

// Exemplos de texto para o e-mail com HTML e sem.

$mail->Subject     = "Cadastro efetuado com sucesso!";
$mail->Body        = $corpo;
$mail->AltBody      = $corpo;

// Faz a validação se a mensagem foi enviada para o servidor.
$send = $mail->Send();

if($send)
  echo 'E-mail enviado com sucesso!';
else
  echo $mail->ErrorInfo;


?>