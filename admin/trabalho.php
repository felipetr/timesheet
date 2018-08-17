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
$queryint = "SELECT * FROM ft_produtos WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Trabalho';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/produto.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Trabalho';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/trabalhos"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = 'trabalhos';
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
                    } ?> class="input-lg form-control boffset30" name="titulo" placeholder="Digite o Nome" required
                         id="titulo">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <h4>Categoria:</h4>
                    <?php if ($pagslug == 'novo') { ?>
                        <select required class="input-lg form-control boffset30 select-control" name="categoria">
                            <option></option>
                            <?php

                            $queryintnew = "SELECT * FROM ft_produtos_categorias ORDER by slug" or die("Erro.." . mysqli_error($link_db));
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
                    <?php } else {
                        ?>
                        <input readonly value=" <?php

                        $queryintnew = "SELECT * FROM ft_produtos_categorias WHERE id = '{$pagina['categoria']}'" or die("Erro.." . mysqli_error($link_db));
                        $queryintnew = mysqli_query($link_db, $queryintnew);
                        while ($categoria = mysqli_fetch_array($queryintnew)) {
                            echo $categoria['nome'];
                        } ?>" class="input-lg form-control boffset30" name="" required id="categoria">
                        <input type="hidden" name="categoria" value="<?php echo $categoria['id']; ?>">
                        <?php

                    } ?>
                </div>


            </div>
            <div class="row">
                <div class="col-sm-3 col-md-2 col-xs-12">
                    <h4>Imagem:</h4>
                    <input onchange="<?php
                    $imgpatch = $baseurl . '/imagens/nophoto.jpg';
                    if ($pagslug != 'novo') {
                        $imgpatch = $baseurl . '/admin/uploads/' . trim($pagina['foto']);
                        if (!$pagina['foto']) {
                            $imgpatch = $baseurl . '/imagens/nophoto.jpg';
                        }
                    }
                    if ($pagslug != 'novo') {
                        if ($pagina['categoria'] == 2) { ?> $('#variacao').val($('#imagemdestaqueinput').val());$('#changecomp').html('<img src = \'<?php echo $baseurl . '/admin/uploads/' ?>'+$('#imagemdestaqueinput').val()+'\' style=\'width:100%;\'>');  <?php }
                    } ?>" value="<?php

                    if ($pagslug != 'novo') {
                        echo trim($pagina['foto']);

                    } ?>" type="hidden" id="imagemdestaqueinput" <?php if ($pagslug != 'novo') {
                        if (!$pagina['foto']) { ?>
                            class="imagemlimpa" <?php }
                    } else { ?> class="imagemlimpa" <?php } ?> name="foto">

                    <div id="imagemdestaquebox">
                        <div id="imagem" class="imagemdestaqueload"
                             style="background-image: url('<?php echo $imgpatch; ?>')"></div>
                        <img id="mudavatar" src="<?php echo $baseurl; ?>/admin/imgs/changeavatar.png"
                             onclick="$('#imagemdestaque #uploadImage').click();">

                        <div class="loading"><i class="fa fa-spinner fa-pulse"></i></div>

                    </div>
                    <?php $destaque = '0';
                    if ($pagslug != 'novo') {
                        if ($pagina['destaque']) {
                            $destaque = '1';
                        }
                    }
                    ?>


                </div>


                <div class="col-sm-9 col-md-10 col-xs-12">
                    <?php if ($pagslug != 'novo') { ?>
                    <div class="row">
                        <div class="col-sm-6 <?php if ($pagslug != 'novo') { if ($pagina['categoria'] == 2) { ?>displaynone<?php }} ?>">


                                <h4>Código de Incorporação:</h4>
                                <textarea style="height: 150px; resize: vertical"
                                          class="input-lg form-control boffset30"
                                          name="variacao" placeholder="Digite o Código" required
                                          id="variacao"><?php echo $pagina['descricao']; ?></textarea>
                                <div class="text-right">
                                    <button type="button" onclick="audiovideovisu('<?php echo $pagina['categoria']; ?>')"
                                            class="btn btn-default">Vizualizar
                                    </button>
                                </div>

                        </div>
                        <div class="col-sm-6">
                            <div id="changecomp" class="<?php if ($pagina['categoria'] == 1) { echo 'audioWrapper';} if ($pagina['categoria'] == 3) { echo 'videoWrapper';} ?>"><?php
                                if ($pagslug != 'novo') {
                                    if ($pagina['categoria'] != 2) {
                                        echo $pagina['descricao'];
                                    }
                                    else
                                    {
                                        echo '<img src ="'.$imgpatch.'" style ="width:100%;" >';
                                    }
                                } ?></div>
                        </div>


                    </div>
                    <?php } ?>

                </div>
            </div>
            <button class="submit displaynone"></button>
        </form>
        <script>
            function  audiovideovisu(cat)
            {
                document.getElementById('variacao').setCustomValidity("");
                var validador = 'ok';
                var iframe = $('#variacao').val();
                var iframemold = iframe.replace("<", "");
                iframemold = iframemold.replace("https", "http");
                iframemold = iframemold.replace("www.", "");
                iframemold = iframemold.replace("//w.", "//");
                iframemold = iframemold.replace(">", "");
                iframemold = iframemold.replace("'", '"');
                var firstexplode = iframemold.split(' ');
                var tag = firstexplode[0];
                if (tag != 'iframe')
                {
                    validador = 'erro';
                }
                var secondexplode = iframemold.split('src="http://');
                var secondexplodelimpo = secondexplode[1];
                var thirdexplode = secondexplodelimpo.split('.');
                var url = thirdexplode[0];
                if (cat == '3')
                {
                    if (url != 'youtube')
                    {
                        validador = 'erro';
                    }
                }

                if (cat == '1')
                {
                    if (url != 'youtube')
                    {
                        validador = 'erro';
                    }
                }


                if (validador == 'ok')
                {
                    $('#changecomp').html(iframe);
                }else {
                    $('#changecomp').html('<h3 class="alert alert-danger" style="padding: 6px !important;">Código inválido!</h3>');
                    document.getElementById('variacao').setCustomValidity("Código inválido!");

                }
            }
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
    $titulo = $_POST['titulo'];
    $foto = $_POST['foto'];

    $categoria = $_POST['categoria'];
    if ($pagslug != 'novo') {
    $slug = $pagslug;
    $variacao = $_POST['variacao'];
    $query1 = mysqli_query($link_db, "UPDATE ft_produtos SET nome = '{$titulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_produtos SET foto = '{$foto}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_produtos SET descricao = '{$variacao}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));

    if ($query1) {
    if ($query2)
    {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/trabalhos">
        <?php
    }
    }
    } else {


        $slug = ft_slug($titulo);



        $queryint = "SELECT * FROM ft_produtos WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'novo') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';
 if ($categoria != '2'){
        $sql = "INSERT INTO ft_produtos (
               nome,
               slug,
               foto,
               categoria
            )
            VALUES
            (
               '$titulo',
               '$slug',
               '$foto',
               '$categoria'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);
 }
        else
        {
            $sql = "INSERT INTO ft_produtos (
               nome,
               slug,
               foto,
               descricao,
               categoria
            )
            VALUES
            (
               '$titulo',
               '$slug',
               '$foto',
               '$foto',
               '$categoria'
            )" or die("Erro.." . mysqli_error($link_db));
            $result = mysqli_query($link_db, $sql);
        }
        $erro = $sql;
    if ($result) {
        ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/trabalho.php/<?php echo $slug; ?>">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




