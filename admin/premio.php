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
@$posttitulo = $_POST['titulo'];
if ($posttitulo) {
    $post = 'true';
}
$queryint = "SELECT * FROM ft_premios WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Prêmio';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/premio.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Prêmio';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/premios"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = 'premio';
include 'includes/header.php';


?>

<div class="contentbox">
    <?php if ($post == 'false') { ?>
        <h2><?php echo $titulo; ?></h2>

        <form id="pagform" method="post">

            <h4>Nome:</h4>
            <input <?php if ($pagslug != 'novo') {
                echo 'value="' . $pagina['nome'] . '"';
            } ?> class="input-lg form-control boffset30" name="titulo" placeholder="Digite o Nome" required
                 id="titulo">

            <div class="row">
                <div class="col-sm-3 col-md-2 col-xs-12">
                    <h4>Imagem: <small><br>Resolução ideal 150px X 150px <br> Proporção ideal 1:1</small></h4>
                    <input value="<?php if ($pagslug != 'novo') {
                        echo trim($pagina['foto']);
                    } ?>" type="hidden" id="imagemdestaqueinput" <?php if ($pagslug != 'novo') {
                        if (!$pagina['foto']) { ?>
                            class="imagemlimpa" <?php }
                    } else { ?> class="imagemlimpa" <?php } ?> name="foto">

                    <div id="imagemdestaquebox" class="tudoredondo">
                        <div id="imagem" class="imagemdestaqueload"
                             style="background-image: url('<?php
                             $imgpatch = $baseurl . '/imagens/nophoto.jpg';
                             if ($pagslug != 'novo') {
                                 $imgpatch = $baseurl . '/admin/uploads/' . trim($pagina['foto']);
                                 if (!$pagina['foto']) {
                                     $imgpatch = $baseurl . '/imagens/nophoto.jpg';
                                 }  } echo $imgpatch; ?>')"></div>
                        <img class="tudoredondo" id="mudavatar" src="<?php echo $baseurl; ?>/admin/imgs/changeavatar.png"
                             onclick="$('#imagemdestaque #uploadImage').click();">

                        <div class="loading"><i class="fa fa-spinner fa-pulse"></i></div>

                    </div>
                    <?php $destaque = '0';
                    if ($pagslug != 'novo') {
                        if ($pagina['foto']) {
                            $destaque = '1';
                        }
                    }
                    ?>



                </div>
                <div class="col-sm-9 col-md-10 col-xs-12">
                    <h4>Descrição:</h4>
            <textarea class="callfroala" name="conteudo" id="conteudo"><?php if ($pagslug != 'novo') {
                    echo $pagina['texto'];
                } else {
                    echo "&nbsp;";
                } ?></textarea>
                </div>

            </div>

            <button class="submit displaynone"></button>
        </form>
    <?php } else { ?>
        <h2 class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h2>
        <script>
            $('#topbar').remove();
            $('#sidebar').remove();
        </script>
    <?php

    if ($posttitulo) { ?>

    <?php
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    $foto = $_POST['foto'];


    if ($pagslug != 'novo') {
    $slug = $pagslug;

    $query1 = mysqli_query($link_db, "UPDATE ft_premios SET nome = '{$titulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_premios SET texto = '{$conteudo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_premios SET foto = '{$foto}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));


    if ($query1) {
    if ($query2)
    {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/premios">
        <?php
    }
    }
    } else {


        $slug = ft_slug($titulo);



        $queryint = "SELECT * FROM ft_premios WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'novo') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';

        $sql = "INSERT INTO ft_premios (
               nome,
               texto,
               slug,
               foto
            )
            VALUES
            (
               '$titulo',
               '$conteudo',
               '$slug',
               '$foto'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);

        $erro = $sql;
    if ($result) {
        ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/premio.php/<?php echo $slug; ?>">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




