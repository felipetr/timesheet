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
$queryint = "SELECT * FROM ft_cliente WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Cliente';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/cliente.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Cliente';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/clientes.php"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = 'clientes';
include 'includes/header.php';


?>

<div class="contentbox">
    <?php if ($post == 'false') { ?>
        <h2><?php echo $titulo; ?></h2>
        <script src="<?php echo $baseurl; ?>/admin/js/jquery.maskMoney.js"></script>
        <form id="pagform" method="post">

            <h4>Nome:</h4>
            <input <?php if ($pagslug != 'novo') {
                echo 'value="' . $pagina['nome'] . '"';
            } ?> class="input-lg form-control boffset30" name="nome" placeholder="Digite o Nome" required
                 id="titulo">


            <div class="row">
                <div class="col-sm-3 col-md-2 col-xs-12">
                    <h4>Logo:
                        <small><br>Resolução ideal 400px X 400px</small>
                    </h4>
                    <input value="<?php if ($pagslug != 'novo') {
                        echo trim($pagina['logo']);
                    } ?>" type="hidden" id="imagemdestaqueinput" <?php if ($pagslug != 'novo') {
                        if (!$pagina['logo']) { ?>
                            class="imagemlimpa" <?php }
                    } else { ?> class="imagemlimpa" <?php } ?> name="foto">

                    <div id="imagemdestaquebox" class="sociobox">
                        <div id="imagem" class="imagemdestaqueload"
                             style="background-image: url('<?php
                             $imgpatch = $baseurl . '/imagens/nophoto.jpg';
                             if ($pagslug != 'novo') {
                                 $imgpatch = $baseurl . '/admin/uploads/' . trim($pagina['logo']);
                                 if (!$pagina['logo']) {
                                     $imgpatch = $baseurl . '/imagens/nophoto.jpg';
                                 }
                             }
                             echo $imgpatch; ?>')"></div>
                        <img class="socioavatar" id="mudavatar"
                             src="<?php echo $baseurl; ?>/admin/imgs/changeavatar.png"
                             onclick="$('#imagemdestaque #uploadImage').click();">

                        <div class="loading socioloading"><i class="fa fa-spinner fa-pulse"></i></div>

                    </div>


                </div>

                <div class="col-sm-3 col-md-2 col-xs-12">

                    <h4>Valor Estimado da Hora:</h4>

                    <div class="input-group">
                        <span class="input-group-addon" >R$ </span><input <?php if ($pagslug != 'novo') {
                            echo 'value="' . $pagina['hora'] . '"';
                        } ?> class="input-lg form-control boffset30" type="text" name="hora"
                             placeholder="Digite o Valor da Hora do Cliente"
                             id="hora">

                    </div>
                </div>
            </div>

            <button class="submit displaynone"></button>
        </form>
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
    $foto = $_POST['foto'];
    $hora = $_POST['hora'];
if (!$hora){$hora = '0,00';}

    if ($pagslug != 'novo') {
    $slug = $pagslug;

    $query1 = mysqli_query($link_db, "UPDATE ft_cliente SET nome = '{$nome}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_cliente SET logo = '{$foto}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_cliente SET hora = '{$hora}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));


    if ($query1) {
    if ($query2)
    {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/clientes">
        <?php
    }
    }
    } else {


        $slug = ft_slug($nome);



        $queryint = "SELECT * FROM ft_cliente WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'novo') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';

        $sql = "INSERT INTO ft_cliente (
               nome,
               slug,
               hora,
               logo
            )
            VALUES
            (
               '$nome',
               '$slug',
               '$hora',
               '$foto'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);

        $erro = $sql;
    if ($result) {
        ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/clientes.php">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




