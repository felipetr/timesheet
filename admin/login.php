<?php session_start();
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include '../includes/arrays.php';
if (isset($_SESSION['nome'])) {
    $redirect = $baseurl.'/admin';

    header("location:$redirect");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Timesheet - Admin - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon shortcut" type="image/x-icon" href="<?php echo $baseurl; ?>/admin/imgs/favicon.png"/>
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/font-awesome.css">
    <link href="<?php echo $baseurl; ?>/admin/css/jquery.bxslider.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/prettify.css">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/felipetravassos.css">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/login.css">


    <script src="<?php echo $baseurl; ?>/admin/js/jquery.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/jquery.bxslider.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/prettify.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/jquery.nicescroll.min.js"></script>
    <script> var baseurl = '<?php echo $baseurl; ?>';</script>
    <script src="<?php echo $baseurl; ?>/admin/js/login.js"></script>

    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <meta name="generator" content="Felipe Travassos"/>
</head>
<body>
<form id="formlogin" onsubmit="logarse(baseurl); return false;" class="loginform">
    <img src="imgs/gerens.svg">
	<br><br>
    <div id="erromsg"></div>
    <input id="email" type="text" name="email" placeholder="Login ou Email" class="form-control" required/>
	<br>
    <input id="senha" type="password" name="senha" placeholder="Senha" class="form-control" required/>
	<br>
    <button class="btn btn-block btn-info" style="cursor:pointer;">Entrar</button>
<div class="text-left" style="font-size: 18px">
    <a href="<?php echo $baseurl; ?>"><< Voltar ao Site</a>
    <a href="<?php echo $baseurl; ?>/admin/recuperasenha" style="float: right">Esqueci a Senha</a>
    </div>
</form>


<div class="modal fade" id="modalalert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

</body>

</html>

