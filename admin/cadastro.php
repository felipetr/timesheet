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


$botaotopo = '<a href="' . $baseurl . '/admin/cadastros/"><i class="fa fa-chevron-left"></i> Voltar</a>';
$ativo = '7';
include 'includes/header.php';

?>

<div class="contentbox">
    <?php if ($post == 'false') { ?>
    <h2><?php echo $cadastro['razao']; ?></h2>


    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <h3>Dados</h3>
            <div class="panel panel-default">
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
        <div class="col-sm-4 col-xs-12">
            <h3>Estatísticas</h3>
            <div class="panel panel-default">
                <ul class="list-group">
                    <li class="list-group-item"><b>Pedidos Realizados:</b> <span class="badge"><?php
                        $queryint = "SELECT * FROM ft_orcamentos WHERE userslug = '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));

                        $queryint = mysqli_query($link_db, $queryint);
                        $total = mysqli_num_rows($queryint);
                        echo $total; ?></span></li>
                    <li class="list-group-item"><b>Último Pedido:</b>
                        <span class="badge"><?php
                        $queryint = "SELECT * FROM ft_orcamentos WHERE userslug = '{$pagslug}' ORDER BY datahora DESC LIMIT 1" or die("Erro.." . mysqli_error($link_db));

                        $queryint = mysqli_query($link_db, $queryint);

                        while ($datah = mysqli_fetch_array($queryint)) {
                            $dataharray = explode(' ', $datah['datahora']);
                            $dataarray = explode('-', $dataharray[0]);
                            $horaarray = explode(':', $dataharray[1]);
                            $mesnome = $meses[intval($dataarray[1])];
                            $mesnome = $mesnome['texto'];
                            echo $dataarray[2].' de '.$mesnome.' de '.$dataarray[0];

                            $hora = intval($horaarray[0]);
                            echo ' à';
                            if ($hora > 1)
                            {
                                echo 's';
                            }

                            echo ' '.$hora.':'.$horaarray[1];


                            }
                        ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <h3>Histórico de Pedidos</h3>
    <div class="panel panel-default">
        <table class="table table-striped orctable">
            <thead>
            <tr>
                <th class="text-left">Data</th>
                <th class="text-right">Status</th>

            </tr>
            </thead>
            <tbody>


    <?php

    $queryint = "SELECT * FROM ft_orcamentos WHERE userslug = '{$pagslug}' ORDER BY datahora DESC" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);

    while ($datah = mysqli_fetch_array($queryint)) {
        ?>
    <tr>
    <td class="text-left">

           <?php
            $dataharray = explode(' ', $datah['datahora']);
            $dataarray = explode('-', $dataharray[0]);
            $horaarray = explode(':', $dataharray[1]);
            $mesnome = $meses[intval($dataarray[1])];
            $mesnome = $mesnome['texto'];
            echo $dataarray[2].' de '.$mesnome.' de '.$dataarray[0];

            $hora = intval($horaarray[0]);
            echo ' à';
            if ($hora > 1)
            {
                echo 's';
            }

            echo ' '.$hora.':'.$horaarray[1];
            ?>
           </td>
        <td class="text-right">
            <?php
            $status = $datah['visualizado'];
            if ($status == '0') {
                echo '<span class="label label-primary">novo</span>';
            }
            if ($status == '1') {
                echo '<span class="label label-info">aberto</span>';
            }
            if ($status == '2') {
                echo '<span class="label label-default">encerrado</span>';
            }
            ?>
            <a href="<?php echo $baseurl; ?>/admin/orcamento.php?o=<?php   echo $datah['id']; ?>" style="color:#555;" class="btn btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>
        </td></tr>
        <?php
    }
    ?>
</tbody></table>
    </div>
</div>
<script>
    function modalorcamento(id)
    {


        var formData = {
            'id'              : id
        };
        $.ajax({
            url : "<?php echo $baseurl ?>/admin/includes/orcecho.php",
            type: "POST",
            data : formData,
            success: function(data) {
                $('#orcmodal .modal-body').html(data);
                $('#orcmodal').modal('show');
            }
        });

    }
</script>
    <div id="orcmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="orcmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="erromsg"></h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>


        </div>
    </div>
<?php
}
include 'includes/footer.php' ?>




