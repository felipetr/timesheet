<?php
include 'configuracoes.php';
include 'conectar.php';
$id = $_POST['id'];

$querycat = "SELECT * FROM ft_produtos WHERE id = '{$id}'" or die("Erro.." . mysqli_error($link_db));
$resultcat = mysqli_query($link_db, $querycat);
while ($produto = mysqli_fetch_array($resultcat)) {
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?php echo $produto['nome']; ?></h4>
</div>
<div class="modal-body">

    <div id="modal-contprod">
        <?php echo $produto['descricao']; ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>
<?php } ?>