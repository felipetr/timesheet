<?php

include '../../includes/configuracoes.php';
include '../../includes/conectar.php';

$lista = explode("#", $_POST["lista"]);
$tabela = 'ft_'.$_POST["tabela"];
$quantidade = count($lista)-1;
print_r($lista);

for ($i = 0; $i <= $quantidade; $i++) {

    $iduser = $lista[$i];
    $posicao = $i;

    $query = mysqli_query($link_db, "UPDATE {$tabela} SET ordem = {$posicao}  WHERE  id={$iduser}") or die("Erro " . mysqli_error($link_db));

}

?>
