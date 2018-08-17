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
include '../includes/arrays.php';

$titulo = 'Solicitações de Orcamento';
$botaotopo = '';
$ativo = '8';
include 'includes/header.php';


?>
<script src="<?php echo $baseurl; ?>/admin/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $baseurl; ?>/admin/js/bootstrap-datepicker.pt-BR.min.js"></script>
<div class="contentbox">
    <h2>Solicitações de Orcamento</h2>


    <?php
    $where = '';
    @$filterstatus = $_GET['s'];
    @$filterclient = $_GET['c'];
    @$filterearly = $_GET['e'];
    @$filterlater = $_GET['l'];

    $filters = $filterstatus . $filterclient . $filterearly . $filterlater;

    if ($filters) {
        $where = ' WHERE ';

        if ($filterstatus) {

            if ($filterstatus == 'new') {
                $filterstatus = '0';
            }

            $where .= ' visualizado = ' . $filterstatus . ' AND ';
        }

        if ($filterclient) {
            $where .= ' userslug = "' . $filterclient . '" AND ';
        }

        $later = '3000-06-02';
        $early = '1000-06-02';
        if ($filterearly) {

            $filterearly = explode('/', $filterearly);
            $nfilterearly = $filterearly['2'] . '-' . $filterearly['1'] . '-' . $filterearly['0'];
            $early = $nfilterearly;
        }

        if ($filterlater) {

            $filterlater = explode('/', $filterlater);
            $nfilterlater = $filterlater['2'] . '-' . $filterlater['1'] . '-' . $filterlater['0'];
            $later = $nfilterlater;

        }

        $early .= ' 00:00:00';
        $later .= ' 23:59:59';
        $where .= "datahora BETWEEN  '" . $early . "' AND '" . $later . "' AND ";

        $where = substr("$where", 0, -5);


    }


    $ordem = 'datahora DESC';
    @$sort = $_GET['sort'];
    if ($sort) {
        if ($sort == 'dc') {
            $ordem = 'datahora';
        }
        if ($sort == 'cc') {
            $ordem = 'userslug';
        }
        if ($sort == 'cd') {
            $ordem = 'userslug DESC';
        }
        if ($sort == 'sc') {
            $ordem = 'visualizado';
        }
        if ($sort == 'sd') {
            $ordem = 'visualizado DESC';
        }
    } ?>
    <div class="well">
        <form class="filtro" method="get">
            <h4>Filtrar Por:</h4>

            <div class="row">
                <?php @$statusget = $_GET['s']; ?>
                <div class="col-sm-6  col-xs-12">
                    <h4>Status:</h4>
                    <select class="input-lg form-control boffset30 select-control" name="s">
                        <option value='0'>Todos</option>
                        <option <?php if ($statusget == 'new') { ?> selected <?php } ?> value='new'>Novos</option>
                        <option <?php if ($statusget == 1) { ?> selected <?php } ?> value='1'>Abertos</option>
                        <option <?php if ($statusget == 2) { ?> selected <?php } ?> value='2'>Encerrados</option>
                    </select>

                </div>
                <div class="col-sm-6  col-xs-12">
                    <h4>Cliente:</h4>
                    <select class="input-lg form-control boffset30 select-control" name="c">
                        <option value=''>Todos</option>
                        <?php
                        @$clienteget = $_GET['c'];
                        $queryint = "SELECT * FROM ft_usuario ORDER by slug" or die("Erro.." . mysqli_error($link_db));

                        $queryint = mysqli_query($link_db, $queryint);
                        while ($cliente = mysqli_fetch_array($queryint)) {
                            ?>
                            <option <?php if ($clienteget == $cliente['slug']) { ?> selected <?php } ?>
                                value='<?php echo $cliente['slug'] ?>'><?php echo $cliente['razao'] ?></option>
                            <?php
                        }
                        ?>
                    </select>

                </div>
            </div>
            <div class="row input-daterange">
                <div class="col-sm-4 col-xs-12">
                    <h4>Desde o dia:</h4>

                    <input id="data1" readonly value="<?php
                    @$filterlimpa = $nfilterearly;
                    if ($filterlimpa) {
                        echo $filterearly['0'] . '/' . $filterearly['1'] . '/' . $filterearly['2'];
                    } ?>" class="input-lg form-control boffset30 select-control calendar" name="e">

                </div>
                <div class=" col-sm-4 col-xs-12">
                    <h4>Até o dia:</h4>

                    <input id="data2" readonly value="<?php
                    @$filterlimpa = $nfilterlater;
                    if ($filterlimpa) {
                        echo $filterlater['0'] . '/' . $filterlater['1'] . '/' . $filterlater['2'];
                    } ?>" class="input-lg form-control boffset30 select-control calendar" name="l">

                </div>
                <div class="col-sm-4  col-xs-12">
                    <h4 style="visibility: hidden" class="hidden-xs">|</h4>
                    <button type="button" class="input-lg form-control boffset30 select-control btn-default"
                            onclick="$('.calendar').val('');">
                 Limpar <i class="fa fa-calendar" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="col-sm-9  col-xs-12">
                    <h4>Ordenar por:</h4>
                    <select class="input-lg form-control boffset30 selectc-ontrol" name="sort">
                        <?php
                        $sort = 'dd';

                        @$sortget = $_GET['sort'];

                        if ($sortget)
                        {
                            $sort = $sortget;
                        }?>
                                          <option <?php if ($sort == 'dd') { ?> selected <?php } ?> value=''>Mais novos primeiro</option>
                        <option <?php if ($sort == 'dc') { ?> selected <?php } ?> value='dc'>Mais antigos primeiro</option>
                        <option <?php if ($sort == 'cc') { ?> selected <?php } ?> value='cc'>Cliente</option>
                        <option <?php if ($sort == 'cd') { ?> selected <?php } ?> value='cd'>Cliente Decrescente</option>
                        <option <?php if ($sort == 'sc') { ?> selected <?php } ?> value='sc'>Status</option>
                        <option <?php if ($sort == 'sd') { ?> selected <?php } ?> value='sd'>Status Decrescente</option>

                    </select>
                </div>

            <div class="col-sm-3  col-xs-12">
                <h4 style="visibility: hidden" class="hidden-xs">|</h4>
                    <button class="input-lg form-control boffset30 select-control btn-primary">Filtrar</button>

            </div></div>
            <script>
                $(function () {
                    $('.input-daterange').datepicker({
                        format: "dd/mm/yyyy",
                        todayBtn: "linked",
                        language: "pt-BR",
                        startDate: "<?php date('d/m/Y'); ?>"
                    });
                });
            </script>


        </form>
    </div>
    <?php
    $query = 'SELECT * FROM ft_orcamentos ' . $where . ' ORDER BY ' . $ordem;
    //echo $query;

    $queryint = $query or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    $total = mysqli_num_rows($queryint);
    if ($total == 0) {
        ?>
        <h4>Nenhuma solicitaçao de orçamento encontrado</h4>
        <?php
    } else {

        ?>

        <table class="table table-striped orctable">
            <thead>
            <tr>
                <th class="">Cliente</th>
                <th class="text-center">Data</th>
                <th class="text-right">Status</th>

            </tr>
            </thead>
            <tbody>

            <?php
            while ($orc = mysqli_fetch_array($queryint)) {
                ?>
                <tr>
                    <td>
                        <?php
                        $slug = $orc['userslug'];
                        $queryint2 = "SELECT * FROM ft_usuario WHERE  slug  = '$slug'" or die("Erro.." . mysqli_error($link_db));

                        $queryint2 = mysqli_query($link_db, $queryint2);
                        while ($user = mysqli_fetch_array($queryint2)) {
                            echo $user['razao'];
                        }
                        ?>
                    </td>
                    <td class="text-center">
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
                    </td>
                    <td class="text-right">
                        <?php
                        $status = $orc['visualizado'];
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
                        <a href="<?php echo $baseurl; ?>/admin/orcamento.php?o=<?php   echo $orc['id']; ?>" style="color:#555;" class="btn btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } ?>
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
<?php include 'includes/footer.php' ?>


