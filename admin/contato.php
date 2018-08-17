<?php session_start();
if (!isset($_SESSION['ts_adm_nome'])) {
    $redirect = "login";

    header("location:$redirect");
}
if ($_SESSION['ts_adm_nivel'] > 2) {
    $redirect = "./";

    header("location:$redirect");
}
include '../includes/configuracoes.php';
include '../includes/conectar.php';
include '../includes/funcoes.php';
include '../includes/arrays.php';

$titulo = 'Contato e Seo';
$botaotopo = '<a onclick="contato()"><i class="fa fa-floppy-o"></i>  Salvar</a>';
$ativo = 'contato';
?>
<script>

    function contato() {
        $('form #msg').removeClass('displaynone').html('<i class="fa fa-spinner fa-pulse"></i>');

        var email = $('#siteemail').val();
        var telefone = $('#sitefone').val();
        var rua = $('#siterua').val();
        var num = $('#sitenum').val();
        var loja = $('#siteloja').val();
        var bairro = $('#sitebairro').val();
        var comp = $('#sitecomp').val();
        var cidade = $('#sitecidade').val();
        var uf = $('#siteuf').val();
        var cep = $('#sitecep').val();

        var facebook = $('#sitefacebook').val();
        var instagram = $('#siteinstagram').val();
        var twitter = $('#sitetwitter').val();
        var linkedin = $('#sitelinkedin').val();

        var whatsapp = $('#sitewhatsapp').val();

        var titulo = $('#sitetitle').val();
        var description = $('#sitedesc').val();
        var keywords = $('#sitekeys').val();

        var lat = $('#sitelat').val();
        var lng = $('#sitelng').val();

        var fbimg = $('#sitefbimg input').val();





        $.ajax({
                // Request method.
                method: "POST",

                // Request URL.
                url: "<?php echo $baseurl?>/admin/includes/editacontato.php",

                // Request params.
                data: {
                    email: email,
                    telefone: telefone,
                    rua: rua,
                    num: num,
                    loja: loja,
                    bairro: bairro,
                    comp: comp,
                    cidade: cidade,
                    uf: uf,
                    cep: cep,
                    facebook: facebook,
                    instagram: instagram,
                    twitter: twitter,
                    linkedin: linkedin,
                    whatsapp: whatsapp,
                    titulo: titulo,
                    description: description,
                    keywords: keywords,
                    lat: lat,
                    lng: lng,
                    fbimg: fbimg

                }
            })
            .done (function (data) {
                console.log ('atualizado');
                $('form #msg').html(data);
            });


    }
</script>

<?php
include 'includes/header.php';
?>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtR-mjizq0jJvthbhhz97Pe4qF-LKU4_0&signed_in=true&callback=initMap">

</script>
<script>

    // The following example creates a marker in Stockholm, Sweden using a DROP
    // animation. Clicking on the marker will toggle the animation between a BOUNCE
    // animation and no animation.

    var marker;

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            scrollwheel: false,
            center: {lat: <?php echo $config['lat']; ?>, lng: <?php echo $config['lng']; ?>}
        });

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: {lat: <?php echo $config['lat']; ?>, lng: <?php echo $config['lng']; ?>}
        });
        marker.addListener('click', toggleBounce);
        google.maps.event.addListener(marker, 'dragend', function (event) {

            $('#sitelat').val(event.latLng.lat());
            $('#sitelng').val(event.latLng.lng());

        });
    }


    function toggleBounce() {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }





</script>
<div class="contentbox">
    <h2>Contato e Seo</h2>
    <?php

    ?>
    <form id="formcontato" onsubmit="contato(); return false;">
        <div id="msg" class="alert alert-info displaynone"></div>
        <div class="row">

            <div class="col-xs-12 col-sm-6">
                Email:<br>
                <input type="email" required id="siteemail" value="<?php echo $config['email']; ?>"
                       class="form-control input-lg boffset30">
            </div>

            <div class="col-xs-12 col-sm-6">
                Telefone:<br>
                <input type="text" id="sitefone" value="<?php echo $config['telefone']; ?>"
                       class="form-control input-lg boffset30">
            </div>
            <div class="col-xs-12 col-sm-12">
                <h3>Endereço: </h3>
            </div>
            <div class="col-xs-12 col-sm-8">
                Logradouro:<br>
                <input type="text" id="siterua" value="<?php echo $config['rua']; ?>"
                       class="form-control input-lg boffset30">

            </div>
            <div class="col-xs-12 col-sm-4">
                Número:<br>
                <input type="text" id="sitenum" value="<?php echo $config['num']; ?>"
                       class="form-control input-lg boffset30">

            </div>
            <div class="col-xs-12 col-sm-4">
                Loja/Apartamento:<br>
                <input type="text" id="siteloja" value="<?php echo $config['loja']; ?>"
                       class="form-control input-lg boffset30">

            </div>
            <div class="col-xs-12 col-sm-4">
                Bairro:<br>
                <input type="text" id="sitebairro" value="<?php echo $config['bairro']; ?>"
                       class="form-control input-lg boffset30">

            </div>

            <div class="col-xs-12 col-sm-4">
                Complemento:<br>
                <input type="text" id="sitecomp" value="<?php echo $config['complemento']; ?>"
                       class="form-control input-lg boffset30">

            </div>
            <div class="col-xs-12 col-sm-4">
                Cidade:<br>
                <input type="text" id="sitecidade" value="<?php echo $config['cidade']; ?>"
                       class="form-control input-lg boffset30">

            </div>
            <div class="col-xs-12 col-sm-4">
                UF:<br>
                <input type="text" id="siteuf" value="<?php echo $config['uf']; ?>"
                       class="form-control input-lg boffset30">

            </div>
            <div class="col-xs-12 col-sm-4">
                CEP:<br>
                <input type="text" id="sitecep" value="<?php echo $config['cep']; ?>"
                       class="form-control input-lg boffset30">
            </div>

            <div class="col-sm-6 col-xs-12 redessociais">

                <h3>Redes Sociais: </h3>


                <div class="input-group" style="margin-bottom: 7px">
                    <div class="input-group-addon redesocialicon"><i class="fa fa-facebook-official"
                                                                     aria-hidden="true"></i></div>
                    <input type="text" id="sitefacebook" value="<?php echo $config['facebook']; ?>"
                           class="form-control input-lg">
                </div>
                <div class="input-group" style="margin-bottom: 7px">
                    <div class="input-group-addon redesocialicon"><i class="fa fa-instagram" aria-hidden="true"></i>
                    </div>
                    <input type="text" id="siteinstagram" value="<?php echo $config['instagram']; ?>"
                           class="form-control input-lg">
                </div>
                <div class="input-group" style="margin-bottom: 7px">
                    <div class="input-group-addon redesocialicon"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                    <input type="text" id="sitetwitter" value="<?php echo $config['twitter']; ?>"
                           class="form-control input-lg">
                </div>
                <div class="input-group" style="margin-bottom: 7px">
                    <div class="input-group-addon redesocialicon"><i class="fa fa-linkedin" aria-hidden="true"></i>
                    </div>
                    <input type="text" id="sitelinkedin" value="<?php echo $config['linkedin']; ?>"
                           class="form-control input-lg">
                </div>
                <div class="input-group">
                    <div class="input-group-addon redesocialicon"><i class="fa fa-whatsapp" aria-hidden="true"></i>
                    </div>
                    <input type="text" id="sitewhatsapp" value="<?php echo $config['whatsapp']; ?>"
                           class="form-control input-lg">
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">

                <h3>SEO: </h3>


                Título do Site:<br>
                <input type="text" required id="sitetitle" value="<?php echo $config['titulo']; ?>"
                       class="form-control input-lg boffset30">

                Descrição do Site:<br>
                <input type="text" id="sitedesc" value="<?php echo $config['description']; ?>"
                       class="form-control input-lg boffset30">


                Palavras Chave:<br>
                <input type="text" id="sitekeys" value="<?php echo $config['keywords']; ?>"
                       class="form-control input-lg boffset30">


            </div>
            <div class="col-sm-7 col-xs-12">
                <h3>Localização: <small><br>Arraste para alterar</small></h3>
                <div id="map" class="maplocal"></div>
                <input id="sitelat" value="<?php echo $config['lat']; ?>" type="hidden">
                <input id="sitelng" value="<?php echo $config['lng']; ?>" type="hidden">


            </div>
            <div id="sitefbimg" class="col-sm-5 col-xs-12">

                    <h3>Imagem para Facebook:
                        <small><br>Resolução ideal 600px X 315px</small>
                    </h3>
                    <input value="<?php   echo trim($config['fbimg']); ?>" type="hidden" id="imagemdestaqueinput" class="imagemlimpa"  name="foto">

                    <div id="imagemdestaquebox" class="sociobox">
                        <div id="imagem" class="imagemdestaqueload"
                             style="background-image: url('<?php
                             $imgpatch = $baseurl . '/imagens/nofb.jpg';

                                 $imgpatch = $baseurl . '/admin/uploads/' . trim($config['fbimg']);
                                 if (!$config['fbimg']) {
                                     $imgpatch = $baseurl . '/imagens/nofb.jpg';
                                 }

                             echo $imgpatch; ?>')"></div>
                        <img class="socioavatar" id="mudavatar"
                             src="<?php echo $baseurl; ?>/admin/imgs/fbsh.png"
                             onclick="$('#imagemdestaque #uploadImage').click();">

                        <div class="loading socioloading"><i class="fa fa-spinner fa-pulse"></i></div>

                    </div>



                </div>
            </div>
        </div>
        <button class="displaynone submit"></button>
    </form>
</div>


<?php include 'includes/footer.php' ?>




