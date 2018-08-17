<?php session_start();
include 'includes/configuracoes.php';
include 'includes/conectar.php';
if (!isset($_SESSION['ts_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}

date_default_timezone_set('America/Recife');

if (!isset($_SESSION['ts_clienteslug'])) {
    if (!isset($_POST['slug'])) {

        $redirect = "./";

        header("location:$redirect");
    } else {

        $_SESSION['ts_clienteslug'] = $_POST['slug'];
        $slug = $_SESSION['ts_clienteslug'];
        $query = "SELECT * FROM ft_cliente WHERE slug = '{$slug}'";
        $result = mysqli_query($link_db, $query);
        while ($cliente = mysqli_fetch_array($result)) {
            $clienteid = $cliente['id'];
            $_SESSION['ts_clienteid'] = $clienteid;
        }
        $clienteid = $_SESSION['ts_clienteid'];

        $_SESSION['ts_datainicio'] = date('d/m/Y \à\s H:i:s');
        $_SESSION['ts_datainiciodb'] = date("Y-m-d H:i:s");
        $userid = $_SESSION['ts_id'];
        $datainicio = $_SESSION['ts_datainiciodb'];

        $sql = "INSERT INTO ft_horas (
               iduser,
               idcliente,
               dataentrada,
               datasaida
            )
            VALUES
            (
               '$userid',
               '$clienteid',
               '$datainicio',
               '$datainicio'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);
        if (!$result) {
            echo mysqli_error($link_db);
        }

        $query = "SELECT * FROM ft_horas WHERE dataentrada = '{$datainicio}' ";
        $result = mysqli_query($link_db, $query);
        while ($hora = mysqli_fetch_array($result)) {
            $_SESSION['ts_horaid'] = $hora['id'];
        }

    }
}
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

    <div class="conteudo" style="position: relative;">

        <button style="position: absolute; right: 15px; top: 15px;" onclick="fechasessao()" class="btn btn-danger">
            Fechar Sessão
        </button>
        <button  onclick="notifyMe('Olá <?php echo $_SESSION['ts_nome']; ?>,', 'imagens/alerticon.png', 'Bem-Vind<?php echo $_SESSION['ts_sexo']; ?> ao Gerens Timesheet', 0);" id="ativanotifica" style="position: absolute; left: 15px; top: 15px;" onclick="fechasessao()" class="btn btn-warning">
            Ativar Notificações
        </button>
        <h2>Sessão iniciada</h2>
        <div id="notificacao"></div>


        <?php
        $slug = $_SESSION['ts_clienteslug'];
        $query = "SELECT * FROM ft_cliente WHERE slug = '{$slug}'";
        $result = mysqli_query($link_db, $query);
        while ($cliente = mysqli_fetch_array($result)) { ?>
            <h3>Cliente: <b><?php echo $cliente['nome'];
                    $clientenome = $cliente['nome']; ?></b></h3>
        <?php }
        ?>
        <h2 class="text-center">Sessão iniciada em <b><?php echo $_SESSION['ts_datainicio'] . ''; ?></b></h2>
        <h3>Tempo decorrido:</h3>
        <div id="relogio" class="alert alert-info">menos de minuto</div>


    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="confirmamodal" tabindex="-1" role="dialog"
     aria-labelledby="confirmamodal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" method="post" action="sessao">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tem certeza que quer fechar essa sessao?</h4>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="slug" id="slug">

                <button type="button" class="btn btn-default" style="float: left"  data-dismiss="modal">Não</button>
                <a href="fechasec.php">
                    <button type="button" class="btn btn-default">Sim</button>
                </a>


            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-sm" id="aindamodal" tabindex="-1" role="dialog"
     aria-labelledby="aindamodal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" method="post" action="sessao">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Você ainda está trabalhando em <?php echo  $clientenome; ?>?</h4>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="slug" id="slug">
                <a href="fechasec.php"> <button type="button" class="btn btn-default" style="float: left" >Não</button>  </a>

                <button id="agoravai" style="display: none;" data-dismiss="modal"></button>

                <button onclick="contagem = 0;" type="button" id="sim" data-dismiss="modal" class="btn btn-default">Sim</button>

            </div>
        </div>
    </div>
</div>
<div id="saicliente"></div>
<audio id="chatAudio">
    <source src="audio/notifica.ogg" type="audio/ogg">
    <source src="audio/notifica.mp3" type="audio/mpeg">
    <source src="audio/notifica.wav" type="audio/wav">
</audio>

<footer class="text-center"><a target="_blank" href="http://gerens.com.br">Desenvolvido por <img
                src="imagens/assina.png"></a></footer>
<script>
    function atualizarelogio() {
        var hora = 'false';
        var formData = {
            'hora': hora
        };

        $.ajax({
            url: "includes/contador.php",
            type: "POST",
            data: formData,
            success: function (data) {
                $('#relogio').html(data);
                console.log('foi');
            }
        });
    }
    var contagem = 0;
    function fechasessao() {

        $('#confirmamodal').modal('show');
    }
    (function () {

        if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
                // Whatever the user answers, we make sure we store the information
                if (!('permission' in Notification)) {

                }
            });
        }






        notifyMe('Olá <?php echo $_SESSION['ts_nome']; ?>,', 'imagens/alerticon.png', 'Bem-Vind<?php echo $_SESSION['ts_sexo']; ?> ao Gerens Timesheet', 0);

        setInterval(function () {
            contagem++;
            console.log(contagem);
            if (contagem == 2) {
                $('#agoravai').click();
            }


            if (contagem == 3600) {
                notifyMe('Ainda está trabalhando em <?php echo $clientenome; ?>?', 'imagens/alerticon.png', 'Clique aqui para confirmar', 1);
                $('#aindamodal').modal('show');
                $('#chatAudio')[0].play();
            }

            if (contagem == 3620) {
                window.location = "saicliente.php";
            }

        }, 1000);

        atualizarelogio();
        setInterval(function () {
            atualizarelogio();
        }, 60000);

    })();


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
                        $('#ativanotifica').addClass('displaynone');

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

    function ativanotifica() {

    }




</script>
</body>
</html>