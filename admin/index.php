<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}

include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include '../includes/arrays.php';

$titulo = 'Área Administrativa';
$ativo = '99';
include 'includes/header.php';
?>

<div class="row">





    <div class="col-md-4 col-sm-6 col-xs-12">
        <a class="homebtn" href="<?php echo $baseurl ?>/admin/colaboradores.php">
            <div class="homebtn-titulo"><i class="fa fa-user"></i> Colaboradores</div>
            <div class="homebtn-dados text-center">

                    <?php
                    $queryint = "SELECT * FROM ft_users" or die("Erro.." . mysqli_error($link_db));

                    $queryint = mysqli_query($link_db, $queryint);
                    $total = mysqli_num_rows($queryint);

                    ?>


                        <div>Total: <?php echo $total; ?></div>




            </div>
        </a>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <a class="homebtn" href="<?php echo $baseurl ?>/admin/clientes.php">
            <div class="homebtn-titulo"><i class="fa fa-briefcase"></i> Clientes</div>
            <div class="homebtn-dados text-center">

                <?php
                $queryint = "SELECT * FROM ft_cliente" or die("Erro.." . mysqli_error($link_db));

                $queryint = mysqli_query($link_db, $queryint);
                $total = mysqli_num_rows($queryint);

                ?>
                <div>Total:  <?php echo $total; ?></div>


            </div>
        </a>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <a class="homebtn" href="<?php echo $baseurl ?>/admin/relatorios.php">
            <div class="homebtn-titulo"><i class="fa fa-pie-chart"></i> Relatórios</div>
            <div class="homebtn-dados text-center">
                <div>Clique para gerar</div>
            </div>
        </a>
    </div>







</div>


<?php include 'includes/footer.php' ?>


