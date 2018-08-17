<?php session_start();

if (!isset($_SESSION['ts_nome'])) {
    $redirect = "login.php";

    header("location:$redirect");
}

if (isset($_SESSION['ts_clienteslug'])) {
    $redirect = "sessao.php";

    header("location:$redirect");
}
include 'includes/configuracoes.php';
include 'includes/conectar.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Timesheet - Gerens</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <link rel="icon shortcut" type="image/x-icon" href="imagens/favicon.png"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-1.12.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
<div class="headerc">
    <header class="text-left">
        <img src="imagens/logob.png"> Timesheet

        <div class="perfil">
            Bem Vind<?php echo $_SESSION['ts_sexo']; ?>, <b><?php echo $_SESSION['ts_nome']; ?></b>
            <a class="profile" href="recadastrar?hash=<?php echo $_SESSION['ts_hash']; ?>" data-toggle="tooltip"
               data-placement="bottom" title="Alterar Senha"><i
                    class="fa fa-key" aria-hidden="true"></i></a>
            <a class="profile" href="logout" data-toggle="tooltip" data-placement="bottom" title="Sair"><i
                    class="fa fa-sign-out" aria-hidden="true"></i></a>

        </div>
    </header>

    <div class="conteudo" style="position: relative">
        <h2>Iniciar Sessão</h2>
        <button  onclick="notifyMe('Olá <?php echo $_SESSION['ts_nome']; ?>,', 'imagens/alerticon.png', 'Bem-Vind<?php echo $_SESSION['ts_sexo']; ?> ao Gerens Timesheet', 0);" id="ativanotifica" style="position: absolute; left: 15px; top: 15px;" onclick="fechasessao()" class="btn btn-warning">
            Ativar Notificações
        </button>
        <div class="row clientesb text-center">
            <?php

            $query = "SELECT * FROM ft_cliente ORDER BY slug";
            $result = mysqli_query($link_db, $query);
            while ($cliente  = mysqli_fetch_array($result)) { ?>
                <div class="col-lg-1 col-md-2 col-sm-3 col-xs-6">
                    <div class="clientebox" onclick="iniciacliente('<?php echo $cliente['slug']; ?>','<?php echo $cliente['nome']; ?>')">
                        <img src="imagens/inv.png" style="background-image: url('<?php
                        $imgpath = 'imagens/nophoto.jpg';
                        if ($cliente['logo'])
                        {
                            $imgpath = 'admin/uploads/'.$cliente['logo'];
                        }
                        echo $imgpath;
                        ?>')">
                        <div><?php echo $cliente['nome']; ?></div>
                    </div>
                </div>


                <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="confirmamodal" tabindex="-1" role="dialog" aria-labelledby="confirmamodal">
    <div class="modal-dialog modal-sm" role="document">
        <form class="modal-content" method="post" action="sessao">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tem certeza que quer começar uma sessão para o cliente <span></span>?</h4>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="slug" id="slug">
                <button type="button" class="btn btn-default" style="float: left" data-dismiss="modal">Não</button>
                <button class="btn btn-default">Sim</button>
            </div>
        </form>
    </div>
</div>
<audio id="chatAudio">
    <source src="audio/notifica.ogg" type="audio/ogg">
    <source src="audio/notifica.mp3" type="audio/mpeg">
    <source src="audio/notifica.wav" type="audio/wav">
</audio>
<div class="modal fade bs-example-modal-sm" id="aindamodal" tabindex="-1" role="dialog"
     aria-labelledby="aindamodal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" method="post" action="sessao">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Você não está em nenhuma sessão!</h4>
            </div>
            <div class="modal-body text-center">
                Por favor, entre em uma sessão.
            </div>

            <div class="modal-footer text-center">
                <input type="hidden" name="slug" id="slug">

                <button id="agoravai" style="display: none;" onclick="$('#sim').click();"></button>

                <button type="button" id="sim" data-dismiss="modal" class="btn btn-default">OK</button>

            </div>
        </div>
    </div>
</div>
<footer class="text-center"><a target="_blank" href="http://gerens.com.br">Desenvolvido por <img
            src="imagens/assina.png"></a></footer>
<script>

    $(function(){
        notifyMe('Olá <?php echo $_SESSION['ts_nome']; ?>,', 'imagens/alerticon.png', 'Bem-Vind<?php echo $_SESSION['ts_sexo']; ?> ao Gerens Timesheet', 0);
        $('#chatAudio')[0].play();
        setInterval(function () {
            notifyMe('Você não está em nenhuma sessão!', 'imagens/alerticon.png', 'Por favor, entre em uma sessão.', 0);
            $('#aindamodal').modal('show');
            $('#chatAudio')[0].play();
        }, 300000);
    });


    function notifyMe(titulo, imagem, texto, zerar) {
        // Let's check if the browser supports notifications
        if (!("Notification" in window)) {
            $('#notificacao').html('<h3 class="alert alert-danger text-center">Seu navegador não permite notificação!</h3>');
        }

        // Let's check if the user is okay to get some notification
        else if (Notification.permission === "granted") {

            // If it's okay let's create a notification
            var options = {
                body: texto,
                icon: imagem,
                dir: "ltr"

            };
            var notification = new Notification(titulo, options);
            notification.onshow = function(event) {
                event.preventDefault();
                $('#ativanotifica').remove();

            };
            if (zerar) {
                notification.onclick = function (event) {
                    event.preventDefault(); // prevent the browser from focusing the Notification's tab
                    contagem = 0;
                }
            }
        }
        // Otherwise, we need to ask the user for permission
        // Note, Chrome does not implement the permission static property
        // So we have to check for NOT 'denied' instead of 'default'
        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
                // Whatever the user answers, we make sure we store the information
                if (!('permission' in Notification)) {
                    Notification.permission = permission;
                }

                // If the user is okay, let's create a notification

                if (permission === "granted") {
                    var options = {
                        body: texto,
                        icon: imagem,
                        dir: "ltr"

                    };
                    var notification = new Notification(titulo, options);
                    notification.onshow = function(event) {
                        event.preventDefault();
                        $('#ativanotifica').remove();

                    };
                    if (zerar) {
                        notification.onclick = function (event) {
                            event.preventDefault(); // prevent the browser from focusing the Notification's tab
                            contagem = 0;
                        }
                    }

                }
            });

        }



        // At last, if the user already denied any notification, and you
        // want to be respectful there is no need to bother them any more.
    }


function iniciacliente(slug, nome)
{
    $('.modal-title span').html(nome);
    $('.modal-footer input').val(slug);
    $('#confirmamodal').modal('show');
}


</script>
</body>
</html>