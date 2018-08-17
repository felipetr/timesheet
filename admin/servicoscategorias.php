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

$titulo = 'Categorias de Serviços';
$botaotopo = '<a style="cursor: pointer;" href="'.$baseurl.'/admin/servicoscategoria.php/nova.php"><i class="fa fa-plus"></i> Nova Categoria</a>';
$ativo = 'servicos';
include 'includes/header.php';


?>

<div class="contentbox">
    <h2>Categorias de Serviços</h2>

    <?php
    $queryint = "SELECT * FROM ft_servicos_categorias ORDER by ordem" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    $total = mysqli_num_rows($queryint);
    ?>
        <div id="alerta">
            <small>Arraste para mudar a posição</small>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nome</th>

                <th class="text-center">Excluir</th>
            </tr>
            </thead>
            <tbody>

            <?php if ($total == 0) {
        ?><tr id="nenhum">
                    <td>
            <h4 class="text-center">Nenhuma categoria encontrada</h4>
                    </td>
                    <td>
                    </td>
                </tr>
            <?php
            } else {

            while ($pag = mysqli_fetch_array($queryint)) {
                ?>
                <tr id="pagina-<?php echo $pag['id']; ?>" data-nome="<?php echo $pag['nome']; ?>">
                    <td class="nome"><a href="<?php echo $baseurl.'/admin/servicoscategoria.php/'.$pag['slug'];?>"><span><?php echo $pag['nome']; ?></span></a>

                    </td>


                    <td style="width: 50px" class="text-center">
                        <div class="btn-ativo" id="exclui-<?php echo $pag['slug']; ?>"
                             onclick="excluir(<?php echo $pag['id']; ?>);"><i class="fa fa-trash"
                                                                              aria-hidden="true"></i></div>
                    </td>
                </tr>
            <?php } ?> <?php } ?>
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
            function editac(id)
            {
                $('#editacategoria').modal('show');
                var nome = $('#pagina-'+id).data('nome');

                $('#enomecat').val(nome).data('id',id);

            }
            function salvacat()
            {
                $('#editacategoria #msg').removeClass('displaynone').html('<i class="fa fa-spinner fa-pulse"></i>');

                var nomecat = $('#enomecat').val();
                var id = $('#enomecat').data('id');

                $.ajax({
                        // Request method.
                        method: "POST",

                        // Request URL.
                        url: "<?php echo $baseurl?>/admin/includes/editacat.php",

                        // Request params.
                        data: {
                            nome: nomecat,
                            id: id
                        }
                    })
                    .done (function (data) {
                        console.log ('atualizado');

                        $('#pagina-'+id).data('nome', data);
                        $('#pagina-'+id+' .nome span').html(data);
                        $('#editacategoria').modal('hide');
                        $('#editacategoria #msg').addClass('displaynone');
                    })


            }
            function salvacatnova()
            {
                $('#novacategoria #msg').removeClass('displaynone').html('<i class="fa fa-spinner fa-pulse"></i>');

                var nomecat = $('#novacategoria #nomecat').val();

                $.ajax({
                        // Request method.
                        method: "POST",

                        // Request URL.
                        url: "<?php echo $baseurl?>/admin/includes/novacat.php",

                        // Request params.
                        data: {
                            nome: nomecat
                        }
                    })
                    .done (function (data) {
                        console.log ('atualizado');
                        $('tbody').append(data);
                        $('tbody #nenhum').remove();
                        $('#novacategoria').modal('hide');
                        $('#novacategoria #msg').addClass('displaynone');
                        $('#novacategoria #nomecat').val('');
                    })


            }


        </script>


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
                <button data-id="" data-tabela="servicos_categorias" onclick="confirmadel();" id="confirmadel"
                        style="float: left;" type="button" class="btn btn-default" data-dismiss="modal">Confirmar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="novacategoria" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Nova Categoria</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="displaynone text-center"></div>
                <form id="novacatform" onsubmit="salvacatnova(); return false;">
                    <input type="text" required id="nomecat" class="input-lg form-control" placeholder="Nome da categoria">
                    <button class="displaynone">vai</button>
                </form>
            </div>
            <div class="modal-footer">
                <button style="float: left;" type="button" onclick="$('#novacatform button').click()" class="btn btn-default">Salvar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editacategoria" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Editar Categoria</h4>
            </div>
            <div class="modal-body">
                <div id="msg" class="displaynone text-center"></div>
                <form id="editacatform" onsubmit="salvacat(); return false;">
                    <input type="text" data-id="" required id="enomecat" class="input-lg form-control" placeholder="Nome da categoria">
                    <button class="displaynone">vai</button>
                </form>
            </div>
            <div class="modal-footer">
                <button style="float: left;" type="button" onclick="$('#editacatform button').click()" class="btn btn-default">Salvar
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>


