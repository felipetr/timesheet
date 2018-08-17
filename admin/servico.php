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
$queryint = "SELECT * FROM ft_servicos WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Serviço';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/servico.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Serviço';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/servicos"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = 'servicos';
include 'includes/header.php';


?>

<div class="contentbox">
    <?php if ($post == 'false') { ?>
        <h2><?php echo $titulo; if ($pagslug != 'novo') { ?> <a target="_blank"
                                                                href="<?php echo $baseurl; ?>/servico/<?php echo $pagslug; ?>">
                <button class="btn btn-sm btn-visual">Visualizar Landpage</button>
            </a> <?php } ?></h2>

        <form id="pagform" method="post">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-xs-12">
                    <h4>Nome:</h4>
                    <input <?php if ($pagslug != 'novo') {
                        echo 'value="' . $pagina['nome'] . '"';
                    } ?> class="input-lg form-control boffset30" name="titulo" placeholder="Digite o Nome" required
                         id="titulo">
                </div>
                <div class="col-sm-12 col-md-6 col-xs-12">
                    <h4>Título:</h4>
                    <input <?php if ($pagslug != 'novo') {
                        echo 'value="' . $pagina['titulo'] . '"';
                    } ?> class="input-lg form-control boffset30" name="titulo2" placeholder="Digite o Nome" required
                         id="titulo2">
                </div>
                <div class="col-sm-12 col-md-6 col-xs-12">
                    <h4>Subtítulo:</h4>
                    <input <?php if ($pagslug != 'novo') {
                        echo 'value="' . $pagina['subtitulo'] . '"';
                    } ?> class="input-lg form-control boffset30" name="subtitulo" placeholder="Digite o Nome" required
                         id="subtitulo">
                </div>
                <div class="col-sm-12 col-md-6 col-xs-12">
                    <h4>Categoria:</h4>
                    <select class="input-lg form-control boffset30 select-control" name="categoria" required
                            id="titulo">
                        <?php
                        $nqueryint = "SELECT * FROM ft_servicos_categorias ORDER by ordem" or die("Erro.." . mysqli_error($link_db));
                        $nqueryint = mysqli_query($link_db, $nqueryint);
                        $servcat = $pagina['categoria'];
                        while ($nrow = mysqli_fetch_array($nqueryint)) {
                            ?>
                            <option value="<?php echo $nrow['id']?>" <?php  if ($pagslug != 'novo') { if ($nrow['id'] == $servcat) {
                                ?> selected <?php
                            }}?>><?php echo $nrow['nome']; ?></option>
                            <?php
                        }

                        ?>
                    </select>
                </div>


                <div class="col-sm-12 col-md-6 col-xs-12">
                    <h4>Descrição:</h4>
            <textarea class="callfroala boffset30" name="conteudo" id="conteudo"><?php if ($pagslug != 'novo') {
                    echo $pagina['texto'];
                } else {
                    echo "&nbsp;";
                } ?></textarea>
                </div>
                <div class="col-sm-12 col-md-6 col-xs-12">
                    <h4>Vídeo:</h4>
            <textarea id="videoinput" onchange="$('#videoview .videoWrapper').html($('#videoinput').val());" style="resize: none; height: 100px" class="input-lg form-control" name="video"><?php if ($pagslug != 'novo') {
                    echo $pagina['video'];
                } ?></textarea>
                    <button type="button" onclick="$('#videoview .videoWrapper').html($('#videoinput').val());" class="btn btn-sm btn-visual boffset30">Visualizar Video</button>
                    <div id="videoview">
                        <div class="videoWrapper">
                            <?php if ($pagslug != 'novo') {
                                echo $pagina['video'];
                            } ?>
                            </div>
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

    if ($posttitulo) { ?>

    <?php
    $titulo = $_POST['titulo'];
    $titulo2 = $_POST['titulo2'];
    $subtitulo = $_POST['subtitulo'];
    $conteudo = $_POST['conteudo'];
    $categoria = $_POST['categoria'];
    $video = $_POST['video'];


    if ($pagslug != 'novo') {
    $slug = $pagslug;

    $query1 = mysqli_query($link_db, "UPDATE ft_servicos SET nome = '{$titulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query1 = mysqli_query($link_db, "UPDATE ft_servicos SET titulo = '{$titulo2}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query1 = mysqli_query($link_db, "UPDATE ft_servicos SET subtitulo = '{$subtitulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_servicos SET texto = '{$conteudo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_servicos SET categoria = '{$categoria}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_servicos SET video = '{$video}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));


    if ($query1) {
    if ($query2)
    {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/servicos">
        <?php
    }
    }
    } else {


        $slug = ft_slug($titulo);



        $queryint = "SELECT * FROM ft_servicos WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'novo') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';

        $sql = "INSERT INTO ft_servicos (
               nome,
               titulo,
               subtitulo,
               texto,
               slug,
               categoria,
               video
            )
            VALUES
            (
               '$titulo',
               '$titulo2',
               '$subtitulo',
               '$conteudo',
               '$slug',
               '$categoria',
               '$video'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);

        $erro = $sql;
    if ($result) {
        ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/servico.php/<?php echo $slug; ?>">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




