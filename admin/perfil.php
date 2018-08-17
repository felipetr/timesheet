<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}

include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include '../includes/arrays.php';

$titulo = 'Perfil';
$botaotopo = '<a onclick="$(\'#formperfil .submit\').click()"><i class="fa fa-floppy-o"></i>  Salvar</a>';
$ativo = 'perfil';
include 'includes/header.php';
?>

<div class="contentbox">
    <h2>Perfil</h2>
    <?php
    $id = $_SESSION['ts_adm_id'];
    $queryint = "SELECT * FROM ft_admin WHERE id = $id" or die("Erro.." . mysqli_error($link_db));

    $queryint = mysqli_query($link_db, $queryint);

    while ($per = mysqli_fetch_array($queryint)) {
        $perfil = $per;
    }
    ?>
    <form id="formperfil" onsubmit="contato(); return false;">
        <div id="msg" class="alert alert-info displaynone"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                Nome:<br>
                <input type="text" required id="perfilnome" value="<?php echo $perfil['nome']; ?>"
                       class="form-control input-lg boffset30">
            </div>
            <div class="col-xs-12 col-sm-6">
                Email:<br>
                <input type="email" required id="perfilemail" value="<?php echo $perfil['email']; ?>"
                       class="form-control input-lg boffset30">
            </div>
            <div class="col-xs-12 col-sm-6">
                Gênero:<br>
                <input type="hidden" required id="perfilsexo" value="<?php echo $perfil['sexo']; ?>">

                <div class="radio">

                        <input type="radio" name="gender"
                               value="o" <?php if ($perfil['sexo'] == 'o') { ?> checked <?php } ?> id="radiomale"> <label for="o" onclick="$('#radiomale').click(); $('#perfilsexo').val('o');">Masculino</label>

                        <input type="radio" name="gender"
                               value="a" <?php if ($perfil['sexo'] == 'a') { ?> checked <?php } ?>  id="radiofemale"> <label for="a" onclick="$('#radiofemale').click(); $('#perfilsexo').val('a');">Feminino</label>

                </div>
            </div>
            </div>
        <div class="text-right">
            <a target="_blank" href="<?php echo $baseurl.'/admin/recadastrasenha.php?hash='.$perfil['senha'].'&user='.$perfil['id']?>" class="btn btn-default">Alterar Senha</a>
        </div>
        <button class="displaynone submit"></button>
    </form>
</div>
<script>
    function confirmasenha() {
    document.getElementById('perfilsenha2').setCustomValidity("");
        if ($('#perfilsenha2').val() != $('#perfilsenha').val())
        {
            document.getElementById('perfilsenha2').setCustomValidity("Senhas não coincidem!");
        }
    }
    function contato() {
        $('form #msg').removeClass('displaynone').html('<i class="fa fa-spinner fa-pulse"></i>');

        var nome = $('#perfilnome').val();
        var email = $('#perfilemail').val();
        var sexo = $('#perfilsexo').val();
        var senha = $('#perfilsenha').val();


        $.ajax({
                // Request method.
                method: "POST",

                // Request URL.
                url: "<?php echo $baseurl?>/admin/includes/editaperfil.php",

                // Request params.
                data: {
                    nome: nome,
                    email: email,
                    senha: senha,
                    sexo: sexo

                }
            })
            .done (function (data) {
                console.log ('atualizado');
                $('.nome-user span').html(nome);
                $('.nome-user small').html('Bem Vind'+sexo);
                $("#avatar").css('background-image', data);
                $('form #msg').html('Salvo');
            });


    }
</script>

<?php include 'includes/footer.php' ?>


