<?php session_start();
if (isset($_SESSION['ts_nome'])) {
    $redirect = "./";

    header("location:$redirect");
}
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperação de Senha - Timesheet - Gerens</title>
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
    <script> var baseurl = '<?php echo $baseurl; ?>';</script>
    <script src="js/login.js"></script>

    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <meta name="generator" content="S. Toledo"/>
</head>
<body>
<form id="formlogin" onsubmit="logarse(baseurl); return false;" class="loginform">
    <img src="imagens/gerens.svg">

    <h3 class="text-center">Timesheet<br> <small style="color: #fff"> Recuperação de senha </small></h3>
    <div class="loginformbox">
        <div id="erromsg"></div>
        <div class="text-left">Email:</div>
        <input id="email" class="form-control" type="email" name="email" placeholder="Email" required/>
        <div class="text-left toffset15"><button class="btn btn-block btn-login">Enviar</button></div>

    </div>
    <div class="text-center" style="font-size: 18px">
        <a href="login"><i class="fa fa-arrow-left" aria-hidden="true"></i> Logar-se</a>
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
<footer class="text-center"> <a target="_blank" href="http://gerens.com.br">Desenvolvido por <img src="imagens/assina.png"></a></footer>
<script>
    function reenvia() {

        $('#modalalert .modal-body').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
        $('#modalalert .modal-title').html('Enviando...');


        $('#modalalert').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        var email = $('#email').val();



            var formData = {email: email};
            $.ajax({
                url: "includes/enviahash.php",
                type: "POST",
                data: formData,
                error: function () {
                    $('#modalalert .modal-title').html('Erro ao acessar o servidor');
                    $('#modalalert .modal-body').html('Por favor, tente mais tarde!');
                },
                success: function (data) {
                    if (data == 'Email Enviado') {
                        $('#modalalert .modal-title').html(data);
                        $('#modalalert .modal-body').html('Cheque a caixa de entrada da conta <b>'+email+'</b> para redefinir sua senha. Pode demorar alguns minutos. Lembre-se de checar a caixa de spam!');


                    } else {
                        $('#modalalert .modal-title').html('Usuário nao encontrado');
                        $('#modalalert .modal-body').html('Tem certeza que esse é o email cadastrado?');
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