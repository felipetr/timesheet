<?php
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
include '../../includes/funcoes.php';
include 'funcoes.php';
include '../../includes/arrays.php';


$titulo = $_POST['nome'];
$slug = ft_slug($titulo);



$queryint = "SELECT * FROM ft_banners_categoria WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);

if ($rowcount > 0 OR $slug == 'novo') {
    $slug .= '-' . $rowcount;
}


$queryint = "SELECT * FROM ft_banners_categoria" or die("Erro.." . mysqli_error($link_db));

$queryint = mysqli_query($link_db, $queryint);



$sql = "INSERT INTO ft_banners_categoria (
               nome,
               slug
            )
            VALUES
            (
               '$titulo',
               '$slug'
            )" or die("Erro.." . mysqli_error($link_db));

$result = mysqli_query($link_db, $sql);
if (!$result)
{
    echo $titulo.','.$slug.','.$ordem;
}

$queryint = "SELECT * FROM ft_banners_categoria WHERE  slug  = '$slug'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
while ($cat = mysqli_fetch_array($queryint)) {
    echo '<tr id="pagina-'.$cat['id'].'" class="ui-sortable-handle" data-nome="'.$titulo.'"><td class="nome"><span>'.$titulo.'</span><button class="editarcategoria" onclick="editac('.$cat['id'].')"><i class="fa fa-pencil" style="cursor:pointer;"></i></button> <td class="text-center" style="width: 50px">                <div onclick="excluir('.$cat['id'].');" id="exclui-capacetes" class="btn-ativo"><i aria-hidden="true" class="fa fa-trash"></i></div></td></tr>';
}

