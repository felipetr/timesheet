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
$queryint = "SELECT * FROM ft_banners WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Banner';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/banner.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Banner';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/banners/"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = '2';
include 'includes/header.php';


?>

<div class="contentbox">
    <?php if ($post == 'false') { ?>
        <h2><?php echo $titulo; ?></h2>

        <form id="pagform" method="post">
            <div class="row">
                <div class="col-sm-8 col-xs-12">
                    <h4>Nome:</h4>
                    <input <?php if ($pagslug != 'novo') {
                        echo 'value="' . $pagina['nome'] . '"';
                    } ?> class="input-lg form-control boffset30" name="nome" placeholder="Digite o Nome" required
                         id="titulo">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <h4>Categoria:</h4>
                    <select class="input-lg form-control boffset30 select-control" name="categoria">
                        <option value="">Sem Categoria</option>
                        <?php
                        $imgpatch = $baseurl . '/admin/uploads/' . trim($pagina['imagem']);
                        if (!$pagina['imagem']) {
                            $imgpatch = $baseurl . '/imagens/nobanner.jpg';
                        }
                        $queryintnew = "SELECT * FROM ft_banners_categoria ORDER by slug" or die("Erro.." . mysqli_error($link_db));
                        $queryintnew = mysqli_query($link_db, $queryintnew);
                        while ($categoria = mysqli_fetch_array($queryintnew)) {
                            ?>

                            <option value="<?php echo $categoria['id'] ?>" <?php if ($pagslug != 'novo') {
                                if ($pagina['categoria'] == $categoria['id']) { ?> selected <?php }
                            } ?>><?php echo $categoria['nome'] ?></option>

                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <h4>Link:</h4>
                    <input <?php if ($pagslug != 'novo') {
                        echo 'value="' . $pagina['link'] . '"';
                    } ?> class="input-lg form-control boffset30" name="link" placeholder="Digite o Link" required
                         id="link">
                    </div>
                <div class="col-sm-3 col-xs-12">
                    <h4>Abrir link em:</h4>
                    <?php $target = '_self';
                    if ($pagslug != 'novo') {
                         $target = $pagina['target'];
                     }

                    ?>
                    <select required class="input-lg form-control boffset30 select-control" name="target">

                        <option value="_self" <?php  if ($target == '_self') { ?> selected <?php
                        } ?>>Mesma Aba</option>
                        <option value="_blank" <?php  if ($target == '_blank') { ?> selected <?php
                        } ?>>Nova Aba</option>

                    </select>
                </div>
            </div>

            <h4>Imagem:</h4>

            <input value="<?php if ($pagslug != 'novo') {
                echo trim($pagina['imagem']);
            } ?>" type="hidden" id="imagemdestaqueinput" <?php if ($pagslug != 'novo') {
                if (!$pagina['imagem']) { ?>
                    class="imagemlimpa" <?php }
            } else { ?> class="imagemlimpa" <?php } ?> name="foto">

            <div class="">

                <div id="imagemdestaquebox" style="width: 800px; max-width: 100%; position: relative !important; display: inline-block">
                    <div id="loader" style="display: block;"><i class="fa fa-spinner fa-pulse"></i></div>
                    <div id="imgbox">
                        <img style="width: 100%; position: relative !important" src="<?php echo $imgpatch; ?>" id="imagem">
                    </div>
                    <div class="mudabanner" onclick="$('#imagembanner #uploadImage').click();">

                    </div>




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

    if ($post == 'true') { ?>

    <?php
    $titulo = $_POST['nome'];
    $foto = $_POST['foto'];
    $categoria = $_POST['categoria'];
    $link = $_POST['link'];
    $target = $_POST['target'];
    if ($pagslug != 'novo') {
    $slug = $pagslug;

    $query1 = mysqli_query($link_db, "UPDATE ft_banners SET nome = '{$titulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_banners SET imagem = '{$foto}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_banners SET categoria = '{$categoria}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_banners SET target = '{$target}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_banners SET link = '{$link}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));

    if ($query1) {
    if ($query2)
    {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/produtos">
        <?php
    }
    }
    } else {


        $slug = ft_slug($titulo);



        $queryint = "SELECT * FROM ft_banners WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'novo') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';

        $sql = "INSERT INTO ft_banners (
               nome,
               imagem,
               slug,
               categoria,
               target,
               link
            )
            VALUES
            (
               '$titulo',
               '$foto',
               '$slug',
               '$categoria',
               '$target',
               '$link'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);

        $erro = $sql;
    if ($result) {
        ?>
   <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/banner.php/<?php echo $slug; ?>">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




