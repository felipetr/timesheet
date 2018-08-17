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

$titulo = 'Trabalhos';
$botaotopo = '<a href="' . $baseurl . '/admin/trabalho.php/novo"><i class="fa fa-plus"></i> Novo Trabaho</a>';
$ativo = 'trabalhos';
include 'includes/header.php';


?>

<div class="contentbox">
    <h2>Trabalhos</h2>

    <?php
    $queryint = "SELECT * FROM ft_produtos ORDER by slug" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);
    $total = mysqli_num_rows($queryint);
    if ($total == 0) {
        ?>
        <h4>Nenhum trabalho encontrado</h4>
        <?php
    } else {
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Titulo</th>
                <th class="text-center">Destaque</th>
                <th class="text-center">Ativo</th>
                <th class="text-center">Excluir</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($pag = mysqli_fetch_array($queryint)) {
                ?>
                <tr id="pagina-<?php echo $pag['id']; ?>">
                    <td class="nome"><a id="nome-<?php echo $pag['id']; ?>)" href="<?php echo $baseurl; ?>/admin/trabalho.php/<?php echo $pag['slug']; ?>"><i class="icontrabalho fa fa-<?php if ($pag['categoria'] == '3'){echo 'play'; } if ($pag['categoria'] == '2'){echo 'picture-o'; } if ($pag['categoria'] == '1'){echo 'music'; } ?>" aria-hidden="true"></i><?php ?><?php echo $pag['nome']; ?></a></td>
                    <td style="width: 50px" class="text-center">
                        <div class="btn-<?php if ($pag['destaque']==0){echo 'in';} ?>destaque" data-ativo="<?php echo $pag['destaque']; ?>" onclick="destaque('produtos',<?php echo $pag['id']; ?>);" id="destaquebtn<?php echo $pag['id']; ?>"><i class="fa fa-star<?php if ($pag['destaque']==0){echo '-o';} ?>" aria-hidden="true"></i></div>
                    </td>
                    <td style="width: 50px" class="text-center">
                        <div class="btn-<?php if ($pag['ativo']==0){echo 'in';} ?>ativo" data-ativo="<?php echo $pag['ativo']; ?>" onclick="ativar('produtos',<?php echo $pag['id']; ?>);" id="ativobtn<?php echo $pag['id']; ?>"><i class="fa fa-eye<?php if ($pag['ativo']==0){echo '-slash';} ?>" aria-hidden="true"></i></div>
                    </td>

                    <td style="width: 50px" class="text-center">
                        <div class="btn-ativo" id="exclui-<?php echo $pag['slug']; ?>" onclick="excluir(<?php echo $pag['id']; ?>);"><i class="fa fa-trash" aria-hidden="true"></i></div>
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
                <h4 class="modal-title text-center">Confirma a exclusão?</h4>
            </div>
            <div class="modal-footer">
                <button data-id="" data-tabela="produtos" onclick="confirmadel();" id="confirmadel" style="float: left;" type="button" class="btn btn-default" data-dismiss="modal">Confirmar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>


