<?php session_start();

if (!isset($_SESSION['ts_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}

if (!isset($_GET['id'])) {
    $redirect = "./";

    header("location:$redirect");
}

include 'includes/conectar.php';
if (isset($_POST['cliente'])) {

    $cliente = $_POST['cliente'];
    $tipo = $_POST['tipo'];
    $id = $_POST['id'];
    @$host = $_POST['host'];
    @$porta = $_POST['porta'];
    @$login = $_POST['login'];
    @$senha = $_POST['senha'];
    @$observa = $_POST['observa'];


    $query = mysqli_query($link_db, "UPDATE senhas SET cliente = '{$cliente}'  WHERE  id='{$id}'") or die("Erro " . mysqli_error($link_db));
    $query = mysqli_query($link_db, "UPDATE senhas SET tipo = '{$tipo}'  WHERE  id='{$id}'") or die("Erro " . mysqli_error($link_db));
    $query = mysqli_query($link_db, "UPDATE senhas SET host = '{$host}'  WHERE  id='{$id}'") or die("Erro " . mysqli_error($link_db));
    $query = mysqli_query($link_db, "UPDATE senhas SET port = '{$porta}'  WHERE  id='{$id}'") or die("Erro " . mysqli_error($link_db));
    $query = mysqli_query($link_db, "UPDATE senhas SET login = '{$login}'  WHERE  id='{$id}'") or die("Erro " . mysqli_error($link_db));
    $query = mysqli_query($link_db, "UPDATE senhas SET senha = '{$senha}'  WHERE  id='{$id}'") or die("Erro " . mysqli_error($link_db));
    $query = mysqli_query($link_db, "UPDATE senhas SET observa = '{$observa}'  WHERE  id='{$id}'") or die("Erro " . mysqli_error($link_db));


    if ($query) {
        $redirect = "./";
        header("location:$redirect");
    }
}


$tiponome = array();
$tipogrupo = array();
$query = "SELECT * FROM tipos";
$result = mysqli_query($link_db, $query);
while ($tip = mysqli_fetch_array($result)) {
    $tiponome[$tip['id']] = $tip['tipo'];
    $tipogrupo[$tip['id']] = $tip['grupo'];
}


$querypai = "SELECT * FROM senhas WHERE id = '{$_GET['id']}'";
$resultpai = mysqli_query($link_db, $querypai);
while ($senha = mysqli_fetch_array($resultpai)) {
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
            <img src="imagens/logob.png"> - <b>Timesheet</b>

            <div class="perfil">
                Bem Vind<?php echo $_SESSION['ts_sexo']; ?>, <b><?php echo $_SESSION['ts_nome']; ?></b>
                <a class="profile" href="recadastrar?hash=<?php echo $_SESSION['ts_hash']; ?>" data-toggle="tooltip"
                   data-placement="bottom" title="Alterar Senha"><i
                        class="fa fa-key" aria-hidden="true"></i></a>
                <a class="profile" href="logout" data-toggle="tooltip" data-placement="bottom" title="Sair"><i
                        class="fa fa-sign-out" aria-hidden="true"></i></a>

            </div>
        </header>
        <div class="precontent text-right">
            <a href="./">
                <button class="btn btn-gestao"><i class="fa fa-bars" aria-hidden="true"></i> Voltar à lista</button>
            </a>
            <a href="novocliente">
                <button class="btn btn-gestao"><i class="fa fa-user-circle" aria-hidden="true"></i> Novo Cliente
                </button>
            </a>
        </div>
        <div class="conteudo">

            <h3>Editar Senha</h3>

            <form method="post" class="row text-left">
                <div class="col-sm-6 col-xs-12">
                    <h4>Cliente:</h4>
                    <select name="cliente" class="form-control input-lg select-control" required>
                        <option></option>
                        <?php
                        $queryparent = "SELECT * FROM cliente ORDER BY slug ";
                        $resultparent = mysqli_query($link_db, $queryparent);
                        while ($cliente = mysqli_fetch_array($resultparent)) {


                            ?>
                            <option <?php if ($cliente['slug'] == $senha['cliente']) {
                                echo 'selected';
                            } ?> value="<?php echo $cliente['slug'] ?>"><?php echo $cliente['cliente'] ?></option>
                            <?php

                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <h4>Tipo:</h4>
                    <input type="hidden" name="id" value="<?php echo $senha['id']; ?>">
                    <select name="tipo" class="form-control input-lg select-control" required>
                        <option></option>
                        <?php
                        $queryparent = "SELECT * FROM tipos ORDER BY slug ";
                        $resultparent = mysqli_query($link_db, $queryparent);
                        while ($cliente = mysqli_fetch_array($resultparent)) {
                            $acessos = explode(',', $_SESSION['ts_acessos']);
                            foreach ($acessos as &$value) {
                                if ($value == $cliente['grupo']) {
                                    ?>
                                    <option <?php if ($cliente['id'] == $senha['tipo']) {
                                        echo 'selected';
                                    } ?> value="<?php echo $cliente['id'] ?>"><?php echo $cliente['tipo'] ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <h4>Host:</h4>
                    <input name="host" value="<?php echo $senha['host']; ?>"
                           class="form-control input-lg select-control">
                </div>
                <div class="col-sm-6 col-xs-12">
                    <h4>Porta:</h4>
                    <input name="porta" value="<?php echo $senha['port']; ?>"
                           class="form-control input-lg select-control">
                </div>
                <div class="col-sm-6 col-xs-12">
                    <h4>Login:</h4>
                    <input name="login" value="<?php echo $senha['login']; ?>"
                           class="form-control input-lg select-control" required>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <h4>Senha:</h4>
                    <input name="senha" value="<?php echo $senha['senha']; ?>"
                           class="form-control input-lg select-control" required>
                </div>
                <div class="col-sm-12">
                    <h4>Observações:</h4>
                <textarea name="observa" class="form-control input-lg select-control"
                          style="height: 100px; resize: vertical;"><?php echo $senha['observa']; ?></textarea>
                </div>
                <div class="col-sm-12">
                    <div class="text-right" style="margin-top:15px;">
                        <button class="btn btn-gestao btn-lg">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <footer class="text-center"><a target="_blank" href="http://gerens.com.br">Desenvolvido por <img
                src="imagens/assina.png"></a></footer>

    </body>
    </html>
<?php } ?>