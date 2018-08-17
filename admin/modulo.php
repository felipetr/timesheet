<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}
if ($_SESSION['ts_adm_nivel'] != 0) {
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
if ($pagslug == 'modulo') {

}
$post = 'false';
@$posttitulo = $_POST['nome'];
if ($posttitulo) {
    $post = 'true';
}
$queryint = "SELECT * FROM ft_modulos WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Módulo';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/modulo.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $modulo = $row;
    $titulo = 'Editar Módulo';
    $funcao = 'salvamodulo';

}


$botaotopo = '<a href="' . $baseurl . '/admin/modulos/"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#modform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = '4';
include 'includes/header.php';


?>

<div class="contentbox">
    <?php if ($post == 'false') { ?>


        <form id="modform" method="post">
            <?php if ($pagslug == 'novo') { ?>
                <h2>Novo Módulo</h2>
                <h4>Nome:</h4>
            <input class="input-lg form-control boffset30" name="nome" placeholder="Digite o Nome" required
                   id="nome">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h4>Tipo:</h4>
                        <select required class="input-lg form-control boffset30 select-control" name="tipo">
                            <option>Selecione o tipo</option>
                            <option value="conteudohtml">Conteúdo HTML</option>
                            <option value="menu">Menu</option>
                            <option value="produtos">Produtos</option>
                            <option value="banner">Banners</option>
                            <option value="redessociais">Redes Sociais</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <h4>Posição:</h4>
                        <select required class="input-lg form-control boffset30 select-control" name="posicao">
                            <option>Selecione a posicao</option>
                            <?php $posarray = explode(',', $posicoes);
                            foreach ($posarray as &$posicao) {
                                ?>
                                <option value="<?php echo $posicao; ?>"><?php echo $posicao; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php } else { ?>
                <h2>Editar Módulo</h2>
                <h4>Nome:</h4>
            <input class="input-lg form-control boffset30" name="nome" value="<?php echo $modulo['nome']; ?>"
                   placeholder="Digite o Título" required id="nome">

                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h4>Tipo:</h4>

                        <div
                            class="input-lg form-control boffset30 notallowed"><?php echo $tiparray[$modulo['tipo']]; ?></div>
                    </div>

                    <div class="col-sm-6 col-xs-12">
                        <h4>Posição:</h4>
                        <select required class="input-lg form-control boffset30 select-control" name="posicao">
                            <option>Selecione a posicao</option>
                            <?php $posarray = explode(',', $posicoes);
                            foreach ($posarray as &$posicao) {
                                ?>
                                <option <?php if ($modulo['posicao'] == $posicao) {
                                    echo ' selected ';
                                } ?> value="<?php echo $posicao; ?>"><?php echo $posicao; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php if ($modulo['tipo'] == 'menu') { ?>
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        <?php
                        $idmenu = $modulo['id'];
                        $queryint = "SELECT * FROM ft_menu_itens WHERE menu_id = '{$idmenu}' AND ativo = 1 ORDER by ordem" or die("Erro.." . mysqli_error($link_db));

                        $queryint = mysqli_query($link_db, $queryint);
                        while ($item = mysqli_fetch_array($queryint)) {
                            $idmenu = $item['id'];
                            if ($item['parent'] == 'none')
                            {
                         ?>
                        <li class="dd-item" data-id="<?php echo $item['id']; ?>" id="item<?php echo $item['id']; ?>">
                            <div class="dd-handle"><span class="titulo"><?php echo $item['titulo']; ?></span> - <i class="url" style="color: #777"><?php echo $item['url']; ?></i></div>
                            <?php
                            $queryints = "SELECT * FROM ft_menu_itens WHERE parent = '{$idmenu}' AND ativo = 1 ORDER by ordem" or die("Erro.." . mysqli_error($link_db));

                            $queryints = mysqli_query($link_db, $queryints);
                            $rowcount = mysqli_num_rows($queryints);

                            if ($rowcount != 0) {
                                ?>
                            <ul class="dd-list">
                                <?php
                                while ($subitem = mysqli_fetch_array($queryints)) {
                                    ?>
                                <li class="dd-item" data-id="<?php echo $subitem['id']; ?>" id="item<?php echo $subitem['id']; ?>">
                                    <div class="dd-handle"><span class="titulo"><?php echo $subitem['titulo']; ?></span> - <i class="url" style="color: #777"><?php echo $subitem['url']; ?></i></div></li>
                                    <?php
                                }
                                ?>
                                </ul>
                                    <?php
                            }
                            ?>
                        </li>
                        <?php } } ?>
                    </ol>
                </div>

                    <textarea id="nestable-output" name="array"></textarea>


                <script>

                    $(document).ready(function () {

                        var updateOutput = function (e) {
                            var list = e.length ? e : $(e.target),
                                output = list.data('output');
                            if (window.JSON) {
                                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                            } else {
                                output.val('JSON browser support required for this demo.');
                            }
                        };

                        // activate Nestable for list 1
                        $('#nestable').nestable({
                                maxDepth: 2
                            })
                            .on('change', updateOutput);


                        // output initial serialised data
                        updateOutput($('#nestable').data('output', $('#nestable-output')));
                        $('#nestable-output').val('<?php echo $modulo['content'];?>');


                    });
                </script>
            <?php } ?>
                <?php
            }
            ?>


            <button class="submit displaynone"></button>
        </form>
    <?php } else { ?>
        <h2 class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h2>
        <script>
            $('#topbar').remove();
            $('#sidebar').remove();
        </script>
    <?php

    if ($posttitulo) {
    $nome = $_POST['nome'];
    $posicao = $_POST['posicao'];
    if ($pagslug != 'novo') {
    $slug = $pagslug;

    $query1 = mysqli_query($link_db, "UPDATE ft_paginas SET titulo = '{$titulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_paginas SET conteudo = '{$conteudo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));

    if ($query1) {
    if ($query2)
    {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/modulos">
        <?php
    }
    }
    } else {

        $tipo = $_POST['tipo'];
        $slug = ft_slug($nome);



        $queryint = "SELECT * FROM ft_modulos WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'novo') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';

        $sql = "INSERT INTO ft_modulos (
               nome,
               tipo,
               posicao,
               slug
            )
            VALUES
            (
               '$nome',
               '$tipo',
               '$posicao',
               '$slug'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);

        $erro = $sql;
    if ($result) {
        ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/modulo.php/<?php echo $slug; ?>">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




