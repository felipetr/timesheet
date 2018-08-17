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

$titulo = 'Serviços';
$botaotopo = '<a href="' . $baseurl . '/admin/servico.php/novo"><i class="fa fa-plus"></i> Novo Serviço</a>';
$botaotopo .= '<a href="' . $baseurl . '/admin/servicoscategorias.php"><i class="fa fa-bars"></i> Gerenciar Categorias</a>';
$ativo = 'servicos';
include 'includes/header.php';


?>

<div class="contentbox">
    <h2>Serviços</h2>

<div class="catbtns text-center">
    <h4>Filtro de categoria</h4>
    <button onclick="filtraserv('all')" class="btn btn-sm btn-visual">Todos</button>
    <?php
    $queryint = "SELECT * FROM ft_servicos_categorias ORDER by ordem" or die("Erro.." . mysqli_error($link_db));
$categoria = array();
    $queryint = mysqli_query($link_db, $queryint);
    while ($pag = mysqli_fetch_array($queryint)) {
        $catid = $pag['id'];
        $categoria[$catid] = $pag['nome'];
        ?>
        <button onclick="filtraserv('<?php echo $pag['id']; ?>')" class="btn btn-sm btn-visual"><?php echo $pag['nome']; ?></button>
        <?php
    }
     ?>
    </div>
    <?php
    $queryint = "SELECT * FROM ft_servicos ORDER by ordem" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    $total = mysqli_num_rows($queryint);
    if ($total == 0) {
        ?>
        <h4>Nenhum serviço encontrado</h4>
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
                <th class="text-center">Catgeoria</th>
                <th class="text-center">Ativo</th>
                <th class="text-center">Excluir</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($pag = mysqli_fetch_array($queryint)) {
                ?>
                <tr class="servicotr categoria-<?php echo $pag['categoria']; ?>" id="pagina-<?php echo $pag['id']; ?>">
                    <td class="nome"><a id="nome-<?php echo $pag['id']; ?>)" href="<?php echo $baseurl; ?>/admin/servico.php/<?php echo $pag['slug']; ?>"><?php echo $pag['nome']; ?></a></td>
                    <td class="text-center">
                        <i style="color: #777"><?php echo $categoria[$pag['categoria']]; ?></i>
                    </td>
                    <td style="width: 50px" class="text-center">
                        <div class="btn-<?php if ($pag['ativo']==0){echo 'in';} ?>ativo" data-ativo="<?php echo $pag['ativo']; ?>" onclick="ativar('servicos',<?php echo $pag['id']; ?>);" id="ativobtn<?php echo $pag['id']; ?>"><i class="fa fa-eye<?php if ($pag['ativo']==0){echo '-slash';} ?>" aria-hidden="true"></i></div>
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
                <button data-id="" data-tabela="servicos" onclick="confirmadel();" id="confirmadel" style="float: left;" type="button" class="btn btn-default" data-dismiss="modal">Confirmar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    function filtraserv(cat)
    {
        $('.servicotr').removeClass('displaynone');
        if(cat != 'all')
        {
            $('.servicotr').addClass('displaynone');

        }
        $('.categoria-'+cat).removeClass('displaynone');

    }
</script>
<?php include 'includes/footer.php' ?>


