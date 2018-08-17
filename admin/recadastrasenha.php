<?php session_start();
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include '../includes/arrays.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Timesheet - Admin - Alteração de Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon shortcut" type="image/x-icon" href="<?php echo $baseurl; ?>/admin/imgs/favicon.png"/>
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/bootstrap.min.css">
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

<form onsubmit="recadastrasenha(baseurl); return false;" id="formreenviasenha" class="loginform">
    <img src="imgs/gerens.svg">
	<br><br>
    <div id="erromsg"></div>
    <?php
    $usuario = 0;
    $hash=$_GET['hash'];
    $userid=$_GET['user'];
    $queryint = "SELECT * FROM ft_admin WHERE id = '{$userid}'" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);

    while ($user = mysqli_fetch_array($queryint)) {
        if ($user['senha']==$hash)
        {
        $usuario++;
        }
    }
    if (!$usuario)
    {?>
        <h4 class="text-center alert alert-danger">Usuário não encontrado!</h4>
       <?php

    }else{
    ?>
    <input id="senha" type="password" name="" class="form-control" placeholder="Nova Senha" required/>
	<br>
    <input id="senha2" type="password" name="" class="form-control" placeholder="Confirmar Nova Senha" required/>
	<br>
    <input type="hidden" id="iduser" value="<?php echo $userid; ?>">
    <input type="hidden" id="hash" value="<?php echo $hash; ?>">
    <button   class="btn btn-block btn-info" >Alteração de Senha</button>
    <?php } ?>
<div class="text-left" style="font-size: 18px">
    <a href="<?php echo $baseurl; ?>"><< Voltar ao Site</a>
    <a href="<?php echo $baseurl; ?>/admin/login" style="float: right">Logar-se</a>
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

