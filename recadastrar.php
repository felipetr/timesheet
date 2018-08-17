<?php session_start();
if (!isset($_GET['hash'])) {
    $redirect = "./";

    header("location:$redirect");
}
include 'includes/configuracoes.php';
include 'includes/conectar.php';
$hash = $_GET['hash'];
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recadastramento de Senha - Timesheet - Gerens</title>
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
<form id="formlogin" onsubmit="recadastrar(); return false;" class="loginform">
    <img src="imagens/gerens.svg">

    <h3 class="text-center">Timesheet<br>
        <small style="color: #fff"> Recadastramento de senha</small>
    </h3>
    <div class="loginformbox">
        <div id="erromsg"></div>
        <?php
        $query = "SELECT * FROM ft_users WHERE hash = '{$hash}'";
        $result = mysqli_query($link_db, $query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 0) {
            echo '<h4 class="text-center">Usuário não encontrado.</h4>';

        } else {
            $_SESSION['ts_hash'] = $hash;
            ?>
            <div class="text-left">Nova Senha:</div>
            <input id="senha" class="form-control" type="password" name="senha" placeholder="Nova Senha" required/>
            <div class="text-left toffset15">Redigitar Nova Senha:</div>
            <input id="senha2" class="form-control" type="password" name="senha2" placeholder="Redigitar Nova Senha"
                   required/>
            <div class="text-left toffset15">
                <button class="btn btn-block btn-login">Redefinir Senha</button>
            </div>
        <?php } ?>
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
<footer class="text-center"><a target="_blank" href="http://gerens.com.br">Desenvolvido por <img
            src="imagens/assina.png"></a></footer>
<script>
    function recadastrar() {

        $('#modalalert .modal-body').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
        $('#modalalert .modal-title').html('Um momento...');


        $('#modalalert').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        var senha = $('#senha').val();
        var senha2 = $('#senha2').val();

        var erro = 'false';
        if (senha != senha2) {

            $('#modalalert .modal-title').html('Senhas não coincidem');
            $('#modalalert .modal-body').html('Por favor, tente novamente!');
            return false;

        }

        var len = $('#senha').val().length;
        if (len < 8) {
            $('#modalalert .modal-title').html('Senha muito pequena');
            $('#modalalert .modal-body').html('A senha deve ter ao menos 8 dígitos.');
            return false;

        }
        if (erro == 'false') {
            var formData = {senha: senha};
            $.ajax({
                url: "includes/recadastrar.php",
                type: "POST",
                data: formData,
                error: function () {
                    $('#modalalert .modal-title').html('Erro ao acessar o servidor');
                    $('#modalalert .modal-body').html('Por favor, tente mais tarde!');
                },
                success: function (data) {
                    if (data == 'Salvando...') {
                        $('#modalalert .modal-title').html(data);
                        $('#modalalert .modal-body').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
                        window.location = "./";

                    } else {
                        $('#modalalert .modal-title').html('Erro ao acessar o servidor');
                        $('#modalalert .modal-body').html('Por favor, tente mais tarde!');
                    }

                    $('#modalalert').modal({
                        backdrop: true,
                        keyboard: true,
                        show: true
                    });

                }


            });

        }
    }


</script>
</body>

</html>