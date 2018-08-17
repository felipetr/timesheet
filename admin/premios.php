<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}
if ($_SESSION['ts_adm_nivel'] > 2)
{
    $redirect = "./";

    header("location:$redirect");
}
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include '../includes/arrays.php';

$titulo = 'Prêmios';
$botaotopo = '<a href="' . $baseurl . '/admin/premio.php/novo"><i class="fa fa-plus"></i> Novo Prêmio</a>';
$ativo = 'premios';
include 'includes/header.php';


?>

<div class="contentbox">
    <h2>Prêmios</h2>

    <?php
    $queryint = "SELECT * FROM ft_premios ORDER by ordem" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    $total = mysqli_num_rows($queryint);
    if ($total == 0) {
        ?>
        <h4>Nenhum prêmio encontrado</h4>
        <?php
    } else {
        ?>
        <div id="alerta">
            <small>Arraste para mudar a posição</small>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nome</th>

                <th class="text-center">Ativo</th>
                <th class="text-center">Excluir</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($pag = mysqli_fetch_array($queryint)) {
                ?>
                <tr id="pagina-<?php echo $pag['id']; ?>">
                    <td class="nome"><a id="nome-<?php echo $pag['id']; ?>)" href="<?php echo $baseurl; ?>/admin/premio.php/<?php echo $pag['slug']; ?>"><?php echo $pag['nome']; ?></a></td>

                    <td style="width: 50px" class="text-center">
                        <div class="btn-<?php if ($pag['ativo']==0){echo 'in';} ?>ativo" data-ativo="<?php echo $pag['ativo']; ?>" onclick="ativar('premios',<?php echo $pag['id']; ?>);" id="ativobtn<?php echo $pag['id']; ?>"><i class="fa fa-eye<?php if ($pag['ativo']==0){echo '-slash';} ?>" aria-hidden="true"></i></div>
                    </td>

                    <td style="width: 50px" class="text-center">
                        <div class="btn-ativo" id="exclui-<?php echo $pag['slug']; ?>" onclick="excluir(<?php echo $pag['id']; ?>);"><i class="fa fa-trash" aria-hidden="true"></i></div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <script>
            $('tbody').sortable({
                update: function (event, ui) {
                    ordenar();
                }
            });
            function ordenar() {
                var tabela = $('#confirmadel').data('tabela');
                $('#alerta small').html('<i class="fa fa-spinner fa-pulse"></i> Atualizando');
                var lista = '';
                $("tbody tr").each(function (index) {
                    var thisid = this.id.replace('pagina-', '');
                    lista += thisid + '#';
                });
                lista += '#';
                lista = lista.replace('##', '');
                $('#alerta small').html(lista);


                $.ajax({
                        // Request method.
                        method: "POST",

                        // Request URL.
                        url: "<?php echo $baseurl?>/admin/includes/ordenar.php",

                        // Request params.
                        data: {
                            lista: lista,
                            tabela: tabela
                        }
                    })
                    .done (function (data) {
                        console.log ('atualizado');
                        $('#alerta small').html('Salvo!');

                    })
                    .fail (function () {
                        console.log ('erro');
                        $('#alerta small').html('Erro ao salvar');
                    })
            }
            </script>
    <?php } ?>
</div>
<div class="modal fade" id="modalconfirm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Confirma a exclusão?</h4>
            </div>
            <div class="modal-footer">
                <button data-id="" data-tabela="premios" onclick="confirmadel();" id="confirmadel" style="float: left;" type="button" class="btn btn-default" data-dismiss="modal">Confirmar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>


