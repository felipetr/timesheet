<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}
if ($_SESSION['ts_adm_nivel'] > 2) {
    $redirect = "./";

    header("location:$redirect");
}
@$filterid = $_GET['o'];

include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include '../includes/arrays.php';
if (!$filterid) {
    $redirect = $baseurl . "/admin/orcamentos.php";

    header("location:$redirect");
    exit();
}
$titulo = 'Detalhamento da Solicitação de Orcamento';
$botaotopo = '<a href="' . $baseurl . '/admin/orcamentos.php"><i class="fa fa-chevron-left"></i> Voltar</a>';
$ativo = '8';
include 'includes/header.php';


?>
<script src="<?php echo $baseurl; ?>/admin/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $baseurl; ?>/admin/js/bootstrap-datepicker.pt-BR.min.js"></script>
<div class="contentbox">


    <?php


    $query = "SELECT * FROM ft_orcamentos WHERE id = {$filterid}";


    $queryint = $query or die("Erro.." . mysqli_error($link_db));


    $queryint = mysqli_query($link_db, $queryint);

    while ($item = mysqli_fetch_array($queryint)) {

        $orc = $item;

    }
    $status = $orc['visualizado'];
    if ($status == 0) {
        $query = mysqli_query($link_db, "UPDATE ft_orcamentos SET visualizado = 1  WHERE  id={$filterid}") or die("Erro " . mysqli_error($link_db));
    }

    ?>

    <h2>Detalhamento da Solicitação de Orcamento</h2>

    <?php

    $produtos = $orc['produtos'];
    $produtos = str_replace('<p><b>', '<li class="list-group-item"><b>', $produtos);
    $produtos = str_replace(':</b> ', '</b><span style="margin-left: 20px;" class="label label-info">', $produtos);
    $produtos = str_replace('</p>', ' </span></li>', $produtos);


    ?>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <div style="padding: 15px 0; font-size: 18px"><b>Status:</b> <?php
                $status = $orc['visualizado'];
                $statustitle = 'Aberto';
                $statusclass = 'info';


                    if ($status == 2)
                    {
                        $statustitle = 'Encerrado';
                        $statusclass = 'default';
                    }

                ?><span id='statusobj' class="label label-<?php echo $statusclass;  ?>" style="font-size: 18px"><?php echo $statustitle; ?></span><?php
                if ($status != 2)
                {
                ?><span id="fechabtn" onclick="fechaorc(<?php echo $orc['id'];?>);" class="label btn-primary" style="font-size: 18px; cursor:pointer; float: right">Encerrar</span>
            <div id="erro" style="margin-top: 15px" class="alert alert-danger displaynone"></div>
            <?php } ?></div>
            <small>Solicitado em
                <?php
                $dataharray = explode(' ', $orc['datahora']);
                $dataarray = explode('-', $dataharray[0]);
                $horaarray = explode(':', $dataharray[1]);
                $mesnome = $meses[intval($dataarray[1])];
                $mesnome = $mesnome['texto'];
                echo $dataarray[2] . ' de ' . $mesnome . ' de ' . $dataarray[0];
                $hora = intval($horaarray[0]);
                echo ' à';
                if ($hora > 1) {
                    echo 's';
                }

                echo ' ' . $hora . ':' . $horaarray[1];

                ?>

            </small>
            <ul class="list-group">
                <?php echo $produtos; ?>
            </ul>
            <a class="btn btn-success" style="text-decoration: none !important;" href="<?php echo $baseurl; ?>/admin/excel/index.php?id=<?php echo $orc['id']; ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Baixar Planilha em Excel</a>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="well">
                <h4>Dados do Cliente:</h4>
                <?php
                $pagslug = $orc['userslug'];
                $queryint = "SELECT * FROM ft_usuario WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
                $queryint = mysqli_query($link_db, $queryint);
                $rowcount = mysqli_num_rows($queryint);
                if ($rowcount == 0) {

                    $redirect = $baseurl . '/admin/cadastros.php';
                    header("location:$redirect");


                }
                while ($row = mysqli_fetch_array($queryint)) {


                    $cadastro = $row;
                    $titulo = 'Cadastro';
                    $funcao = 'editapag';

                }
                ?>
                <ul class="list-group">
                    <li class="list-group-item"><b>Razão Social:</b> <?php echo $cadastro['razao']; ?></li>
                    <li class="list-group-item"><b>CNPJ:</b> <?php echo $cadastro['cnpj']; ?></li>
                    <li class="list-group-item"><b>Responsável:</b> <?php echo $cadastro['responsavel']; ?></li>
                    <li class="list-group-item"><b>Email:</b> <a
                            href="mailto:<?php echo $cadastro['email']; ?>"><?php echo $cadastro['email']; ?></a></li>
                    <li class="list-group-item"><b>Telefone:</b> <a
                            href="tel:<?php echo $cadastro['telefone']; ?>"><?php echo $cadastro['telefone']; ?></a></li>
                    <li class="list-group-item">
                        <b>Endereço:</b><?php echo $cadastro['logradouro']; ?> <?php echo $cadastro['numero'];
                        if ($cadastro['complemento']) {
                            echo ' ' . $cadastro['numero'];
                        } ?>, <?php echo $cadastro['bairro']; ?>, <?php echo $cadastro['cidade']; ?>
                        - <?php echo $cadastro['estado']; ?></li>
                    <li class="list-group-item"><b>CEP:</b> <?php echo $cadastro['cep']; ?></li>

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalconfirm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Confirma a exclusão da página <span></span>?</h4>
            </div>
            <div class="modal-footer">
                <button data-id="" data-tabela="paginas" onclick="confirmadel();" id="confirmadel" style="float: left;"
                        type="button" class="btn btn-default" data-dismiss="modal">Confirmar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    function fechaorc(id)
    {
        $('#statusobj').html('<i class="fa fa-spinner fa-pulse"></i>');
        $('#fechabtn').addClass('displaynone');
        var formData = {
            'id'              : id
        };
        $.ajax({
            url : "<?php echo $baseurl ?>/admin/includes/orcecho.php",
            type: "POST",
            data : formData,
            success: function() {
                $('#statusobj').removeClass('label-info').addClass('label-default').html('Encerrado');
                $('#fechabtn').remove();
            },
            error: function() {
                $('#fechabtn').removeClass('displaynone');
                $('#statusobj').html('aberto');
                $('#erro').html('Erro ao salvar!').removeClass('displaynone');
            }
        });

    }
</script>
<?php include 'includes/footer.php' ?>


