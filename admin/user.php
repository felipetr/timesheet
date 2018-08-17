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
include 'includes/funcoes.php';
include '../includes/arrays.php';

$linkatual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$linkatual = str_replace('.php', '', $linkatual);
$confirmabarra = substr($linkatual, -1);
if ($confirmabarra == '/') {
    $linkatual = substr($linkatual, 0, -1);
}
$arraylink = explode('/', $linkatual);

$pagslug = end($arraylink);
if ($pagslug == 'pagina')
{
    
}
$post = 'false';
@$posttitulo = $_POST['titulo'];
if ($posttitulo) {
    $post = 'true';
}
$queryint = "SELECT * FROM ft_admin WHERE slug =  '{$pagslug}'" or die("Erro.." . mysqli_error($link_db));
$queryint = mysqli_query($link_db, $queryint);
$rowcount = mysqli_num_rows($queryint);
if ($rowcount == 0) {
    $titulo = 'Novo Gerenciador';
    if ($pagslug != 'nova') {
        $redirect = $baseurl . '/admin/pagina.php/nova';
        header("location:$redirect");
        exit();
    }


}
while ($row = mysqli_fetch_array($queryint)) {


    $pagina = $row;
    $titulo = 'Editar Gerenciador';
    $funcao = 'editapag';

}


$botaotopo = '<a href="' . $baseurl . '/admin/users/"><i class="fa fa-chevron-left"></i> Voltar</a> <a onclick="$(\'#pagform .submit\').click();" class="cursorpointer"><i class="fa fa-floppy-o"></i> Salvar</a>';
$ativo = '1';
include 'includes/header.php';


?>

<div class="contentbox">
    <?php if ($post == 'false') { ?>
        <h2><?php echo $titulo; ?></h2>

        <form id="pagform" method="post">
            <h4>Nome:</h4>
            <input <?php if ($pagslug != 'novo') {
                echo 'value="' . $pagina['nome'] . '"';
            } ?> class="input-lg form-control boffset30" name="titulo" placeholder="Digite o Título" required
                 id="titulo">
<div class="row">
    </div>
            <button class="submit displaynone"></button>
        </form>
    <?php } else { ?>
        <h2 class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h2>
        <script>
            $('#topbar').remove();
            $('#sidebar').remove();
        </script>
    <?php

    if ($posttitulo) {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    if ($pagslug != 'nova') {
    $slug = $pagslug;

    $query1 = mysqli_query($link_db, "UPDATE ft_admin SET titulo = '{$titulo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));
    $query2 = mysqli_query($link_db, "UPDATE ft_admin SET conteudo = '{$conteudo}'  WHERE  slug='{$slug}'") or die("Erro " . mysqli_error($link_db));

    if ($query1) {
        if ($query2)
            {
    ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/paginas">
        <?php
            }
        }
    } else {


        $slug = ft_slug($titulo);



        $queryint = "SELECT * FROM ft_admin WHERE  slug  LIKE '$slug%'" or die("Erro.." . mysqli_error($link_db));

        $queryint = mysqli_query($link_db, $queryint);
        $rowcount = mysqli_num_rows($queryint);


        if ($rowcount > 0 OR $slug == 'nova') {
            $slug .= '-' . $rowcount;
        }

        $erro = 'Erro ao salvar! Tente novamente mais tarde!';

        $sql = "INSERT INTO ft_admin (
               titulo,
               conteudo,
               slug
            )
            VALUES
            (
               '$titulo',
               '$conteudo',
               '$slug'
            )" or die("Erro.." . mysqli_error($link_db));
        $result = mysqli_query($link_db, $sql);

        $erro = $sql;
    if ($result) {
        ?>
    <META http-equiv="refresh" content="1;URL=<?php echo $baseurl; ?>/admin/pagina.php/<?php echo $slug; ?>">
        <?php
    }
    }
    }

        ?>
        <?php

    } ?>
</div>
<?php include 'includes/footer.php' ?>




