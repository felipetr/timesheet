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

$titulo = 'Relatórios';
$botaotopo = '';
$ativo = '7';
include 'includes/header.php';
@$start = $_GET['start'];

?>

<div class="contentbox">
    <h2 class="noneprint">Relatórios</h2>

    <h3  class="noneprint">Filtro</h3>
    <form class="filtrolist noneprint" method="get">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h4>Cliente</h4>
                <select name="cliente" class="form-control select-control input-lg">
                    <option value="">Todos</option>
                    <?php
                    $queryint = "SELECT * FROM ft_cliente ORDER by slug" or die("Erro.." . mysqli_error($link_db));

                    $queryint = mysqli_query($link_db, $queryint);
                    $clientearr = array();
                    @$colabora = $_GET['user'];
                    @$cliente = $_GET['cliente'];
                    while ($pag = mysqli_fetch_array($queryint)) {
                        $clientid = $pag['id'];
                        $clientearr[$clientid] = $pag;
                        if ($clientid != 8){
                        ?>
                        <option <?php if ($cliente) {
                            if ($pag['id'] == $_GET['cliente']) {
                                echo 'selected';
                            }
                        } ?> value="<?php echo $pag['id']; ?>"><?php echo $pag['nome']; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h4>Colaborador</h4>
                <select name="user" class="form-control select-control input-lg">
                    <option value="">Todos</option>
                    <?php
                    $queryint = "SELECT * FROM ft_users ORDER by slug" or die("Erro.." . mysqli_error($link_db));

                    $queryint = mysqli_query($link_db, $queryint);
                    $userarr = array();
                    while ($pag = mysqli_fetch_array($queryint)) {
                        $clientid = $pag['id'];
                        $userarr[$clientid] = $pag;
                        ?>
                        <option <?php

                        if ($colabora) {
                            if ($pag['id'] == $_GET['user']) {
                                echo 'selected';
                            }
                        } ?> value="<?php echo $pag['id']; ?>"><?php echo $pag['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div id="sandbox-container" class="col-md-12 col-sm-12 col-xs-12">
                <h4 style="margin-top:15px !important;">Período</h4>
                <div class="input-daterange input-group" id="datepicker">
                    <input readonly type="text" value="<?php
                    if ($start) {
                        echo $_GET['start'];
                    } else {
                        echo '01/01/2017';
                    }
                    ?>" class="input-lg form-control" name="start"/>
                    <span class="input-group-addon">Até</span>
                    <input readonly type="text" value="<?php
                    if ($start) {
                        echo $_GET['end'];
                    } else {
                        echo date("d/m/Y");
                    }
                    ?>" class="input-lg form-control" name="end"/>
                </div>
            </div>


            <script>
                $(function () {

                    $('#sandbox-container .input-daterange').datepicker({
                        format: "dd/mm/yyyy",
                        startDate: "01/01/2017",
                        endDate: "<?php echo date("d/m/Y");?>",
                        maxViewMode: 2,
                        todayBtn: "linked",
                        language: "pt-BR"
                    });
                });
            </script>
        </div>
        <div class="text-right" style="margin-top: 15px">
            <button class="btn btn-lg btn-visual">Filtrar</button>
        </div>
    </form>

    <?php
    if ($start) { ?>

    <div class="text-right noneprint" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd">
        <button class="btn btn-lg btn-visual" onclick="window.print();">Imprimir Relatório</button>
    </div>
    <div id="cabecalhorelatorio" class="text-ceter">
        <h2 class="showonlypress text-center">Relatório Timesheet</h2>
        <div><b>Período:</b> <?php echo $_GET['start']; ?> até <?php echo $_GET['end']; ?></div>
        <?php if ($cliente) { ?>
            <div><b>Cliente:</b> <?php $clienteshow = $clientearr[$cliente]; echo $clienteshow['nome']; ?></div>
        <?php } ?>
        <?php if ($colabora) { ?>
            <div><b>Colaborador:</b> <?php $clienteshow = $userarr[$colabora]; echo $clienteshow['name']; ?></div>
        <?php } ?>

    </div>

<?php
    $start = explode('/', $start);
    $from_date = $start[2] . $start[1] . $start[0] . '000000';
    $from_date = (float)$from_date;
    $from_date_data = $start[2] . $start[1] . $start[0];
    $from_date_data = (float)$from_date_data;

    $end = explode('/', $_GET['end']);
    $to_date = $end[2] . $end[1] . $end[0] . '235959';
    $to_date = (float)$to_date;
    $to_date_data = $end[2] . $end[1] . $end[0];
    $to_date_data = (float)$to_date_data;
    @$colabora = $_GET['user'];
    @$cliente = $_GET['cliente'];
    $filtro = '';
    $diarradata = array();
    $clientehorasarrray = array();
    $colaborahorasarrray = array();
    $diarradatadisplay = array();
    for ($i = $from_date_data; $i <= $to_date_data; $i++) {

        $diarradata[$i] = 0;
        $ano = substr($i, 0, 4);
        $mes = substr($i, 4, 2);
        $dia = substr($i, 6, 2);
        $diarradatadisplay[$i] = $dia . '/' . $mes . '/' . $ano;


    }


    $queryint = "SELECT * FROM ft_horas  ORDER by dataentrada" or die("Erro.." . mysqli_error($link_db));
    $order = 0;
    $horarray = array();

    $queryint = mysqli_query($link_db, $queryint);
    while ($hora = mysqli_fetch_array($queryint)) {


        $aparece = 1;
        $dataentrada = $hora['dataentrada'] . '';
        $dataentrada = str_ireplace(' ', '', $dataentrada);
        $dataentrada = str_ireplace('-', '', $dataentrada);
        $dataentradastr = str_ireplace(':', '', $dataentrada);
        $dataentrada = (float)$dataentradastr;


        $datasaida = $hora['datasaida'] . '';
        $datasaida = str_ireplace(' ', '', $datasaida);
        $datasaida = str_ireplace('-', '', $datasaida);
        $datasaidatr = str_ireplace(':', '', $datasaida);
        $datasaida = (float)$datasaidatr;

        if ($from_date > $dataentrada) {
            $aparece = 0;
        }
        if ($hora['idcliente'] == '8') {
            $aparece = 0;
        }

        if ($to_date < $datasaida) {
            $aparece = 0;
        }

        if ($colabora) {
            $iduser = $hora['iduser'];
            if ($iduser != $colabora) {
                $aparece = 0;
            }
        }


        if ($cliente) {
            $idcliente = $hora['idcliente'];
            if ($idcliente != $cliente) {
                $aparece = 0;
            }
        }

        if ($aparece == 1) {
            $horarray[$order] = $hora;
            $order++;
        }


    }


    $somahora = 0;
    $somahoravalor = 0;
    $somahoravalorestimado = 0;

    foreach ($horarray as &$hora) {

        $entrada = new DateTime($hora['dataentrada']);
        $saida = new DateTime($hora['datasaida']);
        $diferenca = $entrada->diff($saida);


        $datahora = explode(' ', $hora['dataentrada']);
        $dataymd = explode('-', $datahora[0]);
        $dataint = $dataymd[0] . $dataymd[1] . $dataymd[2];
        $dataint = intval($dataint);


        $horas = intval($diferenca->format("%H")) * 60;
        $minutos = intval($diferenca->format("%I"));
        $minutosfinais = $horas + $minutos;
        $somahora = $somahora + $minutosfinais;
        $diarradata[$dataint] = $diarradata[$dataint] + $minutosfinais;

        $userid = $hora['iduser'];
        $userget = $userarr[$userid];
        $userhora = $userget['hora'];
        $userhora = str_ireplace(',', '', $userhora);
        $userhora = (float)$userhora;
        $userminuto = $userhora / 6000;
        $usergasto = $minutosfinais * $userminuto;
        $somahoravalor = $somahoravalor + $usergasto;


        $clienteid = $hora['idcliente'];
        $clienteget = $clientearr[$clienteid];
        $clientehora = $clienteget['hora'];
        $clientehora = str_ireplace(',', '', $clientehora);
        $clientehora = (float)$clientehora;
        $clienteminuto = $clientehora / 6000;

        $clienteestimado = $minutosfinais * $clienteminuto;


        $somahoravalorestimado = $somahoravalorestimado + $clienteestimado;
        $dataentrada2 = $hora['dataentrada'] . '';
        $dataentrada2 = str_ireplace(' ', '', $dataentrada2);
        $dataentrada2 = str_ireplace('-', '', $dataentrada2);
        $dataentrada2str = str_ireplace(':', '', $dataentrada2);
        $dataentrada2 = (float)$dataentrada2str;
        @$colaborahorasarrrayid = $colaborahorasarrray[$hora['iduser']];
        if (!$colaborahorasarrrayid) {
            $colaborahorasarrray[$hora['iduser']] = 0;
        }
        @$clientehorasarrrayid = $clientehorasarrray[$hora['idcliente']];
        if (!$clientehorasarrrayid) {
            $clientehorasarrray[$hora['idcliente']] = 0;
        }
        $clientehorasarrray[$hora['idcliente']] = $clientehorasarrray[$hora['idcliente']] + $minutosfinais;
        $colaborahorasarrray[$hora['iduser']] = $colaborahorasarrray[$hora['iduser']] + $minutosfinais;


    }
    $hora = floor($somahora / 60);
    $resto = $somahora % 60;
    $resto .= '';
    $restol = strlen($resto);
    if ($restol == 1) {
        $resto = '0' . $resto;
    }
    $somahoravalorestimado2 = explode('.', $somahoravalorestimado . '');
    $reaissomahoravalorestimado2 = $somahoravalorestimado2[0];
    @$centavossomahoravalorestimado2 = substr($somahoravalorestimado2[1], 0, 2);
    if (!$centavossomahoravalorestimado2) {
        $centavossomahoravalorestimado2 = '00';
    }
    $centavossomahoravalorestimado2l = strlen($centavossomahoravalorestimado2);
    if ($centavossomahoravalorestimado2l == 1) {
        $centavossomahoravalorestimado2 = $centavossomahoravalorestimado2 . '0';
    }

    $somahoravalorestimado2 = $reaissomahoravalorestimado2 . ',' . $centavossomahoravalorestimado2;

    $somahoravalor2 = explode('.', $somahoravalor . '');
    $reaisomahoravalor2 = $somahoravalor2[0];
    @$centavossomahoravalor2 = substr($somahoravalor2[1], 0, 2);

    if (!$centavossomahoravalor2) {
        $centavossomahoravalor2 = '00';
    }
    $centavossomahoravalor2l = strlen($centavossomahoravalor2);

    if ($centavossomahoravalor2l == 1) {
        $centavossomahoravalor2 = $centavossomahoravalor2 . '0';
    }

    $diferencavalor = $somahoravalorestimado - $somahoravalor;
    $valorclass = 'info';
    if ($diferencavalor < 0) {
        $valorclass = 'danger';
    }
    $diferencavalor = $diferencavalor . '';
    $diferencavalor = explode('.', $diferencavalor);
    @$diferencavalorescent = substr($diferencavalor[1], 0, 2);
    if (!$diferencavalorescent) {
        $diferencavalorescent = '00';
    }
    $diferencavalorescentl = strlen($diferencavalorescent);
    if ($centavossomahoravalor2l == 1) {
        $diferencavalorescent = '0' . $diferencavalorescent;
    }


    $somahoravalor2 = $reaisomahoravalor2 . ',' . $centavossomahoravalor2;


    $diferencavalores = $diferencavalor[0] . ',' . $diferencavalorescent;

    $horastrabalhadas = $hora . ':' . $resto;
    $valorestimado = $somahoravalorestimado2;
    $valorreal = $somahoravalor2;


    ?><?php


    ?>

    <div class="list relresult text-center">
        <div class="row">
            <div class="col-xs-3">
                <h4>Total de Horas Trabalhadas</h4>
                <div class="alert">
                    <?php echo $horastrabalhadas; ?>
                </div>
            </div>
            <div class="col-xs-3">
                <h4>Valor Estimado</h4>
                <div class="alert">
                    R$ <?php echo $valorestimado; ?>
                </div>
            </div>
            <div class="col-xs-3">
                <h4>Valor Calculado</h4>
                <div class="alert">
                    R$ <?php echo $valorreal; ?>
                </div>
            </div>
            <div class="col-xs-3">
                <h4>Saldo</h4>
                <div class="alert alert-<?php echo $valorclass; ?>">
                    R$ <?php echo $diferencavalores; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="grafico1">

    </div>

    <div class="row">
        <?php if (!$cliente) {?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="grafico2">

            </div>
        </div>
        <?php }?>
        <?php if (!$colabora) {?>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="grafico3">

            </div>
        </div>
        <?php }?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="grafico4">

            </div>
        </div>
        <script>
            var larguragrafico1 = $('#grafico1').width()-30;
            var larguragrafico2 = $('#grafico4').width()-30;
            <?php


            $jsonc = '';
            foreach ($diarradata as $key => $valor) {


                $jsonc .= '{
                            "label": "' . $diarradatadisplay[$key] . '",
                            "value": "' . $valor . '",
                            "color": "#1B798D",
                            "displayValue": "' . $valor . ' min"
                        },';
            }
            $jsonc = rtrim($jsonc, ",");

            ?>
            FusionCharts.ready(function () {

                var revenueChart = new FusionCharts({
                    "type": "column2d",
                    "renderAt": "grafico1",
                    "width": larguragrafico1,
                    "height": "300",
                    "dataFormat": "json",
                    "dataSource": {
                        "chart": {
                            "caption": "Minutos trabalhados por dia",
                            "subCaption": "",
                            "xAxisName": "Dias",
                            "yAxisName": "Minutos",
                            "theme": "fint"
                        },
                        "data": [
                            <?php echo $jsonc; ?>
                        ]
                    }
                });

                revenueChart.render();
<?php if (!$cliente) { ?>
                var clientechart = new FusionCharts({
                        type: 'pie2d',
                        renderAt: 'grafico2',
                        width: larguragrafico2,
                        height: larguragrafico2,
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "caption": "Minutos por Cliente",
                                "numberSufix": " min",
                                "showBorder": "0",
                                "use3DLighting": "0",
                                "enableSmartLabels": "0",
                                "startingAngle": "310",
                                "showLabels": "0",
                                "showPercentValues": "0",
                                "showLegend": "1",
                                "centerLabel": "Revenue from $label: $value",
                                "centerLabelBold": "1",
                                "showTooltip": "0",
                                "decimals": "0",
                                "useDataPlotColorForLabels": "1",
                                "theme": "fint"
                            },
                            "data": [
                                <?php
                                $jsoncliente = '';
                                foreach ($clientehorasarrray as $key => $valor) {
                                    $clientej = $clientearr[$key];
                                    if ($valor) {
                                        $jsoncliente .= '{"label": "' . $clientej['nome'] . '","value": "' . $valor . '"},';
                                    }
                                }
                                $jsoncliente = rtrim($jsoncliente, ",");
                                echo $jsoncliente;

                                ?>
                            ]
                        }
                    }
                );
                clientechart.render();
                <?php } ?>

                <?php if (!$colabora) { ?>
                var colaborachart = new FusionCharts({
                        type: 'pie2d',
                        renderAt: 'grafico3',
                        width: larguragrafico2,
                        height: larguragrafico2,
                        dataFormat: 'json',
                        dataSource: {
                            "chart": {
                                "caption": "Minutos por Colaborador",
                                "numberSufix": " min",
                                "showBorder": "0",
                                "use3DLighting": "0",
                                "enableSmartLabels": "0",
                                "startingAngle": "310",
                                "showLabels": "0",
                                "showPercentValues": "0",
                                "showLegend": "1",
                                "showTooltip": "0",
                                "decimals": "0",
                                "useDataPlotColorForLabels": "1",
                                "theme": "fint"
                            },
                            "data": [
                                <?php
                                $jsoncolabora = '';
                              foreach ($colaborahorasarrray as $key => $valor) {
                                    $colaboraj = $userarr[$key];
                                  if ($valor) {
                                        $jsoncolabora .= '{"label": "' . $colaboraj['name'] . '","value": "' . $valor . '"},';
                                    }
                                }
                                $jsoncolabora = rtrim($jsoncolabora, ",");
                               echo $jsoncolabora;

                                ?>
                            ]
                        }
                    }
                );
                colaborachart.render();
                <?php } ?>



            });
        </script>
        <?php } ?>
    </div>
        <?php include 'includes/footer.php' ?>


