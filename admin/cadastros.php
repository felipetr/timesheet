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

$titulo = 'Cadastros';
$botaotopo = '';
$ativo = '7';
include 'includes/header.php';


?>

<div class="contentbox">
    <h2>Cadastros</h2>

    <?php
    $queryint = "SELECT * FROM ft_usuario ORDER by slug" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    $total = mysqli_num_rows($queryint);
    if ($total == 0) {
        ?>
        <h4>Nenhum cadastro encontrado</h4>
        <?php
    } else {
        ?>
        <table class="table table-striped">

            <tbody>
            <?php
            while ($pag = mysqli_fetch_array($queryint)) {
                ?>
                <tr id="pagina-<?php echo $pag['id']; ?>">
                    <td class="nome"><a href="<?php echo $baseurl; ?>/admin/cadastro.php/<?php echo $pag['slug']; ?>"><?php echo $pag['razao']; ?></a></td>
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
                <button data-id="" data-tabela="paginas" onclick="confirmadel();" id="confirmadel" style="float: left;" type="button" class="btn btn-default" data-dismiss="modal">Confirmar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>


