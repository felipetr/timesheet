<?php session_start();
if (isset($_SESSION['ts_nome'])) {
    $redirect = "./";

    header("location:$redirect");
}
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Timesheet - Gerens</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon shortcut" type="image/x-icon" href="imagens/favicon.png"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link href="css/jquery.bxslider.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/prettify.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="js/jquery.js"></script>
    <script src="js/jquery.bxslider.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/prettify.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/login.js"></script>

    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <meta name="generator" content="S. Toledo"/>
</head>
<body>
<form id="formlogin" onsubmit="logarse(); return false;" class="loginform">
    <img src="imagens/gerens.svg">

    <h3 class="text-center">Timesheet</h3>

    <div class="loginformbox">
        <div id="erromsg"></div>
        <div class="text-left">Login ou Email:</div>
        <input id="email" class="form-control" type="text" name="email" placeholder="Login ou Email" required/>

        <div class="text-left toffset15">Senha:</div>
        <input id="senha" class="form-control" type="password" name="senha" placeholder="Senha" required/>

        <div class="text-left toffset15">
            <button class="btn btn-block btn-login">Entrar</button>
        </div>

    </div>
    <div class="text-center" style="font-size: 18px">
        <a href="recupera">Esqueci a Senha</a>
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
<footer class="text-center"><a target="_blank" href="http://gerens.com.br">Desenvolvido por <img
            src="imagens/assina.png"></a></footer>
<script>
    function logarse() {


        $('#modalalert .modal-body').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
        $('#modalalert .modal-title').html('Conectando...');


        $('#modalalert').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        var login = $('#email').val();
        var senha = $('#senha').val();
        var formData = {login: login, senha: senha};
        $.ajax({
            url: "includes/logarse.php",
            type: "POST",
            data: formData,
            error: function () {
                $('#modalalert .modal-title').html('Erro ao acessar o servidor');
                $('#modalalert .modal-body').html('Por favor, tente mais tarde!');
            },
            success: function (data) {
                if (data == 'Redirecionando...')
                {
                    $('#modalalert .modal-title').html(data);
                    $('#modalalert .modal-body').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
                    window.location="./";

                }else {
                    $('#modalalert .modal-title').html(data);
                    $('#modalalert .modal-body').html('Tente novamente ou tente recuperar a senha clicando <a href="recupera">aqui</a>');
                }

                $('#modalalert').modal({
                    backdrop: true,
                    keyboard: true,
                    show: true
                });

            }


        });


    }


</script>
</body>

</html>