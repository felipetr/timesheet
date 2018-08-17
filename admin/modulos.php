<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}
if ($_SESSION['ts_adm_nivel'] != 0) {
    $redirect = "./";

    header("location:$redirect");
}

include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include 'includes/funcoes.php';
include '../includes/arrays.php';

$titulo = 'Módulos';
$botaotopo = '<a href="' . $baseurl . '/admin/modulo.php/novo"><i class="fa fa-plus"></i> Novo Módulo</a>';
$ativo = '4';
include 'includes/header.php';


?>

<div class="contentbox">
    <h2>Módulos</h2>

    <?php
    $queryint = "SELECT * FROM ft_modulos ORDER by slug" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    $total = mysqli_num_rows($queryint);
    if ($total == 0) {
        ?>
        <h4>Nenhum módulo encontrado</h4>
        <?php
    } else {
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nome</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Ativo</th>
                <th class="text-center">Excluir</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($modulo = mysqli_fetch_array($queryint)) {
                ?>
                <tr id="pagina-<?php echo $modulo['id']; ?>">
                    <td class="nome"><a id="nome-<?php echo $modulo['id']; ?>)" href="<?php echo $baseurl; ?>/admin/modulo.php/<?php echo $modulo['slug']; ?>"><?php echo $modulo['nome']; ?></a></td>
                    <td class="text-center">
                        <i style="color: #777;"><?php echo $tiparray[$modulo['tipo']]; ?></i>
                    </td>
                    <td style="width: 50px" class="text-center">
                        <div class="btn-<?php if ($modulo['ativo']==0){echo 'in';} ?>ativo" data-ativo="<?php echo $modulo['ativo']; ?>" onclick="ativar('paginas',<?php echo $modulo['id']; ?>);" id="ativobtn<?php echo $modulo['id']; ?>"><i class="fa fa-eye<?php if ($modulo['ativo']==0){echo '-slash';} ?>" aria-hidden="true"></i></div>
                    </td>

                    <td style="width: 50px" class="text-center">
                        <div class="btn-ativo" id="exclui-<?php echo $modulo['slug']; ?>" onclick="excluir(<?php echo $modulo['id']; ?>);"><i class="fa fa-trash" aria-hidden="true"></i></div>
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
                <h4 class="modal-title text-center">Confirma a exclusão do módulo <span></span>?</h4>
            </div>
            <div class="modal-footer">
                <button data-id="" data-tabela="modulos" onclick="confirmadel();" id="confirmadel" style="float: left;" type="button" class="btn btn-default" data-dismiss="modal">Confirmar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>


