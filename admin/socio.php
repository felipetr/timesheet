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
$queryint = "SELECT * FROM ft_socios WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Sócio';
    if ($pagslug != 'novo') {
        $redirect = $baseurl . '/admin/socio.php/novo';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Sócio';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/socios/"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = 'socio';
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
                    <h4>Imagem:
                        <small><br>Resolução ideal 570px X 496px <br> Corte de Topo: 127px</small>
                    </h4>
                    <input value="<?php if ($pagslug != 'novo') {
                        echo trim($pagina['foto']);
                    } ?>" type="hidden" id="imagemdestaqueinput" <?php if ($pagslug != 'novo') {
                        if (!$pagina['foto']) { ?>
                            class="imagemlimpa" <?php }
                    } else { ?> class="imagemlimpa" <?php } ?> name="foto">

                    <div id="imagemdestaquebox" class="sociobox">
                        <div id="imagem" class="imagemdestaqueload"
                             style="background-image: url('<?php
                             $imgpatch = $baseurl . '/imagens/socio.png';
                             if ($pagslug != 'novo') {
                                 $imgpatch = $baseurl . '/admin/uploads/' . trim($pagina['foto']);
                                 if (!$pagina['foto']) {
                                     $imgpatch = $baseurl . '/imagens/socio.png';
                                 }
                             }
                             echo $imgpatch; ?>')"></div>
                        <img class="socioavatar" id="mudavatar"
                             src="<?php echo $baseurl; ?>/admin/imgs/changesociobox.png"
                             onclick="$('#imagemdestaque #uploadImage').click();">

                        <div class="loading socioloading"><i class="fa fa-spinner fa-pulse"></i></div>

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
                    <h4>Cargo:</h4>
                    <input <?php if ($pagslug != 'novo') {
                        echo 'value="' . $pagina['cargo'] . '"';
                    } ?> class="input-lg form-control boffset30" name="cargo" placeholder="Digite o Cargo" required
                         id="cargo">

                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Email:</h4>
                            <input <?php if ($pagslug != 'novo') {
                                echo 'value="' . $pagina['email'] . '"';
                            } ?> class="input-lg form-control boffset30" type="email" name="email"
                                 placeholder="Digite o Email" required
                                 id="email">
                        </div>
                        <div class="col-sm-6">
                            <h4>Site:</h4>
                            <input <?php if ($pagslug != 'novo') {
                                echo 'value="' . $pagina['site'] . '"';
                            } ?> class="input-lg form-control boffset30" name="site" placeholder="Digite o Site"

                                 id="site">
                        </div>
                        <div class="col-sm-6">
                            <h4>Facebook:</h4>
                            <input <?php if ($pagslug != 'novo') {
                                echo 'value="' . $pagina['facebook'] . '"';
                            } ?> class="input-lg form-control boffset30" name="facebook" placeholder="Digite o Facebook"

                                 id="facebook">
                        </div>
                        <div class="col-sm-6">
                            <h4>Instagram:</h4>
                            <input <?php if ($pagslug != 'novo') {
                                echo 'value="' . $pagina['instagram'] . '"';
                            } ?> class="input-lg form-control boffset30" name="instagram"
                                 placeholder="Digite o Instagram"
                                 id="instagram">
                        </div>
                        <div class="col-sm-4">
                            <h4>Twitter:</h4>
                            <input <?php if ($pagslug != 'novo') {
                                echo 'value="' . $pagina['twitter'] . '"';
                            } ?> class="input-lg form-control boffset30" name="twitter" placeholder="Digite o Twitter"

                                 id="twitter">
                        </div>
                        <div class="col-sm-4">
                            <h4>Linkedin:</h4>
                            <input <?php if ($pagslug != 'novo') {
                                echo 'value="' . $pagina['linkedin'] . '"';
                            } ?> class="input-lg form-control boffset30" name="linkedin" placeholder="Digite o Linkedin"

                                 id="linkedin">
                        </div>
                        <div class="col-sm-4">
                            <h4>Whatsapp:</h4>
                            <input <?php if ($pagslug != 'novo') {
                                echo 'value="' . $pagina['whatsapp'] . '"';
                            } ?> class="input-lg form-control boffset30" name="whatsapp" placeholder="Digite o Whatsapp"

                                 id="whatsapp">
                        </div>
                    </div>


                    <div class="displaynone">
                        <h4>Descrição:</h4>
            <textarea class="callfroala" name="conteudo" id="conteudo"><?php if ($pagslug != 'novo') {
                    echo $pagina['texto'];
                } else {
                    echo "&nbsp;";
                } ?></textarea>
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
    $cargo = $_POST['cargo'];
    $email = $_POST['email'];
    $site = $_POST['site'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $linkedin = $_POST['linkedin'];
    $instagram = $_POST['instagram'];
    $whatsapp = $_POST['whatsapp'];
    $foto = $_POST['foto'];


    if ($pagslug != 'novo') {
    $slug = $pagslug;

    $query1 = mysqli_query($link_db, "UPDATE ft_socios SET nome = '{$titulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET foto = '{$foto}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET cargo = '{$cargo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET email = '{$email}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET site = '{$site}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET instagram = '{$instagram}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET facebook = '{$facebook}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET twitter = '{$twitter}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET linkedin = '{$linkedin}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_socios SET whatsapp = '{$whatsapp}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));


    if ($query1) {
    if ($query2)
    {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/socios">
        <?php
    }
    }
    } else {


        $slug = ft_slug($titulo);



        $queryint = "SELECT * FROM ft_socios WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'novo') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';

        $sql = "INSERT INTO ft_socios (
               nome,
               cargo,
               email,
               facebook,
               site,
               instagram,
               slug,
               twitter,
               linkedin,
               whatsapp,
               foto
            )
            VALUES
            (
               '$titulo',
               '$cargo',
               '$email',
               '$facebook',
               '$site',
               '$instagram',
               '$slug',
               '$twitter',
               '$linkedin',
               '$whatsapp',
               '$foto'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);

        $erro = $sql;
    if ($result) {
        ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/socio.php/<?php echo $slug; ?>">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




