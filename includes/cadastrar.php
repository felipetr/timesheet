<?php
include 'configuracoes.php';
include 'conectar.php';
include 'funcoes.php';
$razao = $_POST['razao'];
$cnpj = $_POST['cnpj'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$responsavel = $_POST['responsavel'];
$cep = $_POST['cep'];
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];

if (!valida_cnpj($cnpj) ) {
    echo 'cnpje';
    exit();
}



$token = md5($email);

$senhalimpa = rand_string(8);


$senha = md5($senhalimpa);


$querycat = "SELECT * FROM ft_usuario" or die("Erro.." . mysqli_error($link_db));
$slug = $_POST['razao'];

function ft_slug($text)
{

    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text))
    {
        return 'n-a';
    }
    return $text;
}

$slug = ft_slug($_POST['razao']);

$queryint = "SELECT * FROM ft_usuario WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);

if ($rowcount > 0) {
    $slug .= '-' . $rowcount;
}

$resultcat = mysqli_query($link_db, $querycat);

while ($usuario = mysqli_fetch_array($resultcat)) {
    if ($usuario['cnpj'] == $cnpj) {
        echo 'cnpj';
        exit();
    }

    if ($usuario['email'] == $email) {
        echo 'email';
        exit();
    }


}



$sql = "INSERT INTO ft_usuario (
               razao,
               cnpj,
               email,
               slug,
               telefone,
               responsavel,
               cep,
               logradouro,
               numero,
               complemento,
               bairro,
               cidade,
               estado,
               senha,
               token,
               cadastradodesde
            )
            VALUES
            (
               '{$razao}',
               '{$cnpj}',
               '{$email}',
               '{$slug}',
               '{$telefone}',
               '{$responsavel}',
               '{$cep}',
               '{$logradouro}',
               '{$numero}',
               '{$complemento}',
               '{$bairro}',
               '{$cidade}',
               '{$estado}',
               '{$senha}',
               '{$token}',
               now()
            )" or die("Erro.." . mysqli_error($link_db));
$result = mysqli_query($link_db, $sql);





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

$msg = 'Olá, '.$_POST['responsavel'].'<br><br>';

$msg .= 'Seu cadastro no site da <b>JC EPI\'s</b> foi realizado com sucesso.';
$msg .= 'Para finalizar o cadastro e cadastrar a sua senha, acesse o link abaixo:<br><br>';
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

$mail->addAddress($_POST['email'], $_POST['razao']);

$mail->addReplyTo($config['email'], $config['titulo']);

$mail->isHTML(true);
$mail->CharSet     = 'utf-8';
$mail->WordWrap    = 70;

// Exemplos de texto para o e-mail com HTML e sem.

$mail->Subject     = 'Cadastro efetuado com sucesso';
$mail->Body        = $msg;
$mail->AltBody      = $msg;

// Faz a validação se a mensagem foi enviada para o servidor.
$send = $mail->Send();

if($send)
    echo 'E-mail enviado com sucesso!';
else
    echo $mail->ErrorInfo;

?>