<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}
if ($_SESSION['ts_adm_nivel'] > 2) {
    $redirect = "./";

    header("location:$redirect");
}
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include 'includes/funcoes.php';
include '../includes/arrays.php';

$linkatual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$linkatual = str_replace('.php', '', $linkatual);
$confirmabarra = substr($linkatual, -1);
if ($confirmabarra == '/') {
    $linkatual = substr($linkatual, 0, -1);
}
$arraylink = explode('/', $linkatual);

$pagslug = end($arraylink);
if ($pagslug == 'pagina') {

}
$post = 'false';
@$posttitulo = $_POST['nome'];
if ($posttitulo) {
    $post = 'true';
}
$queryint = "SELECT * FROM ft_users WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Colaborador';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/colaborador.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Colaborador';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/colaboradores.php"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = 'colaboradores';
include 'includes/header.php';


?>
<script src="<?php echo $baseurl; ?>/admin/js/jquery.maskMoney.js"></script>
<div class="contentbox" style='position: relative;'>
    <?php if ($post == 'false') { ?>
    <h2><?php echo $titulo; ?></h2>
<?php if ($pagslug != 'novo') { ?><div style="position: absolute; top:15px; right: 15px"><a href="<?php echo $baseurl; ?>/recadastrar.php?hash=<?php echo $pagina['hash']; ?>" target="_blank"><button class="btn btn-lg btn-visual">Alterar Senha</button></div></a>
    <?php } ?>
    <form id="pagform" method="post">

        <h4>Nome:</h4>
        <input <?php if ($pagslug != 'novo') {
            echo 'value="' . $pagina['name'] . '"';
        } ?> class="input-lg form-control boffset30" name="nome" placeholder="Digite o Nome" required
             id="titulo">


        <div class="row">


            <div class="col-sm-6 col-xs-12">
                <h4>Cargo:</h4>
                <input <?php if ($pagslug != 'novo') {
                    echo 'value="' . $pagina['cargo'] . '"';
                } ?> class="input-lg form-control boffset30" name="cargo" placeholder="Digite o Cargo" required
                     id="cargo">
            </div>


            <div class="col-sm-6 col-xs-12">
                <h4>Email:</h4>
                <input <?php if ($pagslug != 'novo') {
                    echo 'value="' . $pagina['email'] . '"';
                } ?> class="input-lg form-control boffset30" type="email" name="email"
                     placeholder="Digite o Email" required
                     id="email">
            </div>
            <div class="col-sm-6 col-xs-12">
                <h4>Valor da Hora:</h4>

                <div class="input-group">
                    <span class="input-group-addon" >R$ </span>
                    <input <?php if ($pagslug != 'novo') {
                        echo 'value="' . $pagina['hora'] . '"';
                    } ?> class="input-lg form-control boffset30" type="text" name="hora"
                         placeholder="Digite o Valor da Hora do Colaborador"
                         id="hora">

                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <h4>Gênero:</h4>
                <div class="btn-group chackgroup" data-toggle="buttons">

                    <label class="btn btn-default btn-large <?php
                    $sexo = 'o';
                    if ($pagslug != 'novo') {
                        $sexo = $pagina['sexo'];
                    }
                    if ($sexo == 'o') {
                        echo 'active';
                    }
                    ?>">
                        <i class="fa fa-male" aria-hidden="true"></i>
                        <input type="radio" name="sexo" <?php if ($sexo == 'o') {
                            echo 'checked';
                        }
                        ?> autocomplete="off" checked value="o">
                    </label>
                    <label class="btn btn-default btn-large <?php if ($sexo == 'a') {
                        echo 'active';
                    }
                    ?>">
                        <i class="fa fa-female" aria-hidden="true"></i>
                        <input type="radio" name="sexo" autocomplete="off" value="a" <?php if ($sexo == 'a') {
                            echo 'checked';
                        }
                        ?>>
                    </label>
                </div>
            </div>

        </div>



    <button class="submit displaynone" id="submit">ee</button>
    </form>
</div>
    <script>
        $(function () {
            $("#hora").maskMoney({
                prefix: '',
                allowNegative: true,
                thousands: '.',
                decimal: ',',
                affixesStay: false
            });
        });

    </script>
<?php } else { ?>
    <h2 class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h2>
    <script>
        $('#topbar').remove();
        $('#sidebar').remove();
    </script>
    <?php

    if ($posttitulo) { ?>

        <?php
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $email = $_POST['email'];
        $hora = $_POST['hora'];
        $hash = md5($nome.$cargo.$email.$hora.date("Ymdhis"));
if (!$hora){$hora = '0,00';}
        $sexo = $_POST['sexo'];

        if ($pagslug != 'novo') {
            $slug = $pagslug;

            $query1 = mysqli_query($link_db, "UPDATE ft_users SET name = '{$nome}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
            $query2 = mysqli_query($link_db, "UPDATE ft_users SET cargo = '{$cargo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
            $query2 = mysqli_query($link_db, "UPDATE ft_users SET email = '{$email}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
            $query2 = mysqli_query($link_db, "UPDATE ft_users SET hora = '{$hora}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
            $query2 = mysqli_query($link_db, "UPDATE ft_users SET sexo = '{$sexo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));


            if ($query1) {
                if ($query2) {
                    ?>
                    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/colaboradores">
                    <?php
                }
            }
        } else {


            $slug = ft_slug($nome);


            $queryint = "SELECT * FROM ft_users WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

            $queryint = mysqli_query($link_db, $queryint);
            $rowcount = mysqli_num_rows($queryint);


            if ($rowcount > 0 OR $slug == 'novo') {
                $slug .= '-' . $rowcount;
            }

            $erro = 'Erro ao salvar! Tente novamente mais tarde!';

            $sql = "INSERT INTO ft_users (
               name,
               cargo,
               slug,
               email,
               hash,
               hora,
               sexo
            )
            VALUES
            (
               '$nome',
               '$cargo',
               '$slug', 
               '$email', 
               '$hash', 
               '$hora',
               '$sexo'
            )" or die("Erro.." . mysqli_error($link_db));
            $result = mysqli_query($link_db, $sql);

            $erro = $sql;
            if ($result) {
                
                $url = 'http://gerens.com.br/timesheet/recadastrar.php?hash='.$hash;
                
                $noreply = 'naoresponda@gerens.com.br';
                
                $titulo = 'Cadastro Efetuado';
$corpo ='<p>Ola, '.$nome.'</p>';
$corpo .='Você foi cadastrad'.$sexo.' no nosso timesheet<br>';
$corpo .='Acesse o link abaixo para definir sua senha:';
$corpo .='<p>http://gerens.com/timesheet/recadastrar.php?hash='.$hash.'</p>';
$corpo .='<p>Equipe Gerens</p>';

$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: ".$noreply."\r\n"; // remetente
$headers .= "Return-Path: ".$noreply."\r\n"; // return-path


@$envio = mail($usemail, $titulo, $corpo, $headers);
                
                
                ?>
                <META http-equiv="refresh"
                      content="1;URL=<?php echo $baseurl; ?>/admin/colaboradores.php">
                <?php
            }
        }
    }

    ?>
    <?php

} ?>
</div>
<?php include 'includes/footer.php' ?>




