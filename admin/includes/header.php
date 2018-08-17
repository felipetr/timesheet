<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>HelloWORD - <?php echo $titulo; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon shortcut" type="image/x-icon" href="<?php echo $baseurl; ?>/admin/imgs/favicon.png"/>
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/font-awesome.css">
    <link href="<?php echo $baseurl; ?>/admin/css/jquery.bxslider.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/prettify.css">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/jquery.tagsinput.css">


    <!-- Include Code Mirror style -->


    <!-- Include Editor Plugins style. -->
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/wysiyyg.css">


    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/felipetravassos.css">
    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="<?php echo $baseurl; ?>/admin/css/cms.css">


    <script src="<?php echo $baseurl; ?>/admin/js/jquery.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/jquery.bxslider.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/prettify.js"></script>

    <script src="<?php echo $baseurl; ?>/admin/js/jquery.nestable.js"></script>

    <script src="<?php echo $baseurl; ?>/admin/js/tinymce/tinymce.min.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/jquery.nicescroll.min.js"></script>





    <!-- Include Language file if we want to use it. -->
    <script type="text/javascript" src="<?php echo $baseurl; ?>/admin/js/languages/pt_br.js"></script>


    <script> var baseurl = '<?php echo $baseurl; ?>';</script>
    <script type="text/javascript" src="<?php echo $baseurl; ?>/admin/js/uploader.js"></script>



    <script src="<?php echo $baseurl; ?>/admin/js/jquery.tagsinput.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/bootstrap-datepicker.pt-BR.min.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/jquery.tagsinput.js"></script>
    <script type="text/javascript" src="<?php echo $baseurl; ?>/admin/js/charts/fusioncharts.js"></script>
    <script type="text/javascript" src="<?php echo $baseurl; ?>/admin/js/charts/themes/fusioncharts.theme.fint.js"></script>
    <script src="<?php echo $baseurl; ?>/admin/js/admin.js"></script>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="generator" content="Felipe Travassos"/>
</head>
<body>

<div id="sidebar">
    <div id="assina"></div>
    <a href="<?php echo $baseurl; ?>/admin/">
        <div id="header">

        </div>
    </a>

    <div id="userbox"<?php if ($ativo == 'perfil') { ?> class="ativo"<?php } ?>>
        <div class="user">
            <div id="avatar"
                 style="background-image: url('<?php echo $baseurl; ?>/admin/avatar/<?php echo $_SESSION['ts_adm_avatar']; ?>')"></div>
            <img id="mudavatar" src="<?php echo $baseurl; ?>/admin/imgs/changeavatar.png"
                 onclick="$('#avatarform #uploadImage').click();">

            <div id="loading"><i class="fa fa-spinner fa-pulse"></i></div>
        </div>
    </div>
    <div class="nome-user">
        <small>Bem Vind<?php echo $_SESSION['ts_adm_sexo']; ?>,</small>
        <br><span><?php echo $_SESSION['ts_adm_nome']; ?></span><br>


        <a href="<?php echo $baseurl; ?>/admin/perfil"><i class="fa fa-pencil-square-o"></i></a>
        <a href="<?php echo $baseurl; ?>/admin/logout"><i class="fa fa-sign-out"></i></a>

    </div>
    <div class="menu">

        <a <?php if ($ativo == 'colaboradores') {
            echo 'class="ativo"';
        } ?> href="<?php echo $baseurl ?>/admin/colaboradores.php"><i class="fa fa-user"></i> Colaboradores</a>
        <a <?php if ($ativo == 'clientes') {
            echo 'class="ativo"';
        } ?> href="<?php echo $baseurl ?>/admin/clientes.php"><i class="fa fa-briefcase"></i> Clientes</a>
        <a <?php if ($ativo == 'relatorios') {
            echo 'class="ativo"';
        } ?> href="<?php echo $baseurl ?>/admin/relatorios.php"><i class="fa fa-pie-chart"></i> Relatórios</a>


    </div>
</div>
<div id="topbar">
    <div class="user">
        <div id="avatar"
             style="background-image: url('<?php echo $baseurl; ?>/admin/avatar/<?php echo $_SESSION['ts_adm_avatar']; ?>')"></div>
        <img id="mudavatar" src="<?php echo $baseurl; ?>/admin/imgs/changeavatar.png"
             onclick="$('#avatarform #uploadImage').click();">

        <div id="loading"><i class="fa fa-spinner fa-pulse"></i></div>
    </div>

    <a href="<?php echo $baseurl; ?>/admin/logout" class="respbtns sair">
        <i class="fa fa-sign-out"></i>
    </a>
    <a href="<?php echo $baseurl; ?>/admin/perfil" class="respbtns">
        <i class="fa fa-cog"></i>
    </a>
    <a href="<?php echo $baseurl; ?>" target="_blank">
        <i class="fa fa-globe"></i>
        Ir para o site
    </a>
    <?php if (isset($botaotopo)) {
        echo $botaotopo;
    } ?>

</div>

<div id="conteudo">

