</div>
<div class="displaynone">
    <form id="avatarform" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <input id="uploadImage" type="file" onchange="$('#avatarform #button').click();" accept="image/*" name="image"/>
        <input id="button" type="submit" value="Upload">
    </form>

    <form id="imagemdestaque" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <input id="uploadImage" type="file" onchange="$('#imagemdestaque #button').click();" accept="image/*"
               name="image"/>
        <input id="button" type="submit" value="Upload">
    </form>

    <form id="imagembanner" action="ajaxupload.php" method="post" enctype="multipart/form-data">
        <input id="uploadImage" type="file" onchange="$('#imagembanner #button').click();" accept="image/*"
               name="image"/>
        <input id="button" type="submit" value="Upload">
    </form>

    <div id="ajaxarray" class="">
        sdf
    </div>
</div>

<div id="erromodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="erromodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="erromsg"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>


    </div>
</div>
<footer>

    <a title="Desenvolvido por Gerens" target="_blank" href="http://gerens.com.br">
        <small>Desenvolvido por <img src="<?php echo $baseurl; ?>/admin/imgs/assina.png"> Gerens</small>
    </a>

</footer>
<script>
    $(document).ready(function (e) {

        $("#avatarform").on('submit', (function (e) {
            modalalertloading();
            e.preventDefault();
            $.ajax({
                url: "<?php echo $baseurl; ?>/admin/ajaxupload.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#ajaxarray').html(data);
                    var mensagem = $('#ajaxarray #mensagem').html();
                    if (mensagem == 'sucesso') {
                        $('#modalalert').modal('hide');
                        var imagem = $('#ajaxarray #imagem').html();
                        $('#sidebar #avatar').css('background-image', 'url("' + imagem + '")');
                        $('#topbar #avatar').css('background-image', 'url("' + imagem + '")');
                    }
                    else {
                        modalalert(mensagem);
                    }
                },
                error: function (e) {
                    $('#ajaxarray').html('<div id="mensagem">Erro no Envio</div><div id="imagem"></div>');
                }
            });
        }));
        $("#imagemdestaque").on('submit', (function (e) {
            modalalertloading();
            e.preventDefault();
            $.ajax({
                url: "<?php echo $baseurl; ?>/admin/ajaxuploaddestaque.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    console.log(data);

                    if (data == '0') {
                        modalalert('Erro ao enviar imagem!')
                    }
                    else {
                        data = data.trim();
                        $('#modalalert').modal('hide');
                        $('#imagemdestaquebox #imagem').css('background-image', 'url("<?php echo $baseurl; ?>/admin/uploads/' + data + '")');
                        $('#imagemdestaqueinput').val(data);
                        $('#imagemdestaqueinput').removeClass('imagemlimpa');
				

                    }
                },
                error: function (e) {
                    $('#ajaxarray').html('<div id="mensagem">Erro no Envio</div><div id="imagem"></div>');
						
                }
            });
        }));
        $("#imagembanner").on('submit', (function (e) {
            modalalertloading();
            e.preventDefault();
            $.ajax({
                url: "<?php echo $baseurl; ?>/admin/ajaxuploaddestaque.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    console.log(data);

                    if (data == '0') {
                        modalalert('Erro ao enviar imagem!')
                    }
                    else {
                        data = data.trim();
                        $('#modalalert').modal('hide');

                        $('#imagemdestaquebox #imgbox').html('<img style="width: 100%; position: relative !important;" src="<?php echo $baseurl; ?>/admin/uploads/' + data + '" id="imagem">');
                        $('#imagemdestaqueinput').val(data);
                        $('#imagemdestaqueinput').removeClass('imagemlimpa');

                    }
                },
                error: function (e) {
                    $('#ajaxarray').html('<div id="mensagem">Erro no Envio</div><div id="imagem"></div>');
                }
            });
        }));
    });

    $(function () {


        tinymce.init({
            selector: '.callfroala',
            height: 300,
            menubar: false,
            language: 'pt_BR',
            plugins: [
                'advlist autolink lists link image responsivefilemanager charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste  code textcolor'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image responsivefilemanager link code',
            content_css: [

                'css/wysiyyg.css'
            ],
            image_class_list: [
                {title: 'Nenhuma', value: ''},
                {title: '100%', value: 'perc100'},
                {title: 'Alinha à Esquerda', value: 'floatleft'},
                {title: 'Alinha à Direita', value: 'floatright'}
            ],
            external_filemanager_path: "<?php echo $baseurl; ?>/admin/js/filemanager/",
            filemanager_title: "Inserir Imagem",
            relative_urls: false,
            remove_script_host: false


        });
    });

    function paddingtopoimg() {
        $('#imagemdestaquebox .loading').css('line-height', $('#imagemdestaquebox').height() + 'px');

    }


    $(window).on({
        load: function () {
            paddingtopoimg();
            $('.imagemlimpa').val('')
        },
        resize: function () {
            paddingtopoimg();
        }
    });

    function confirmadel() {

        var id = $('#modalconfirm #confirmadel').data('id');
        var tabela = $('#modalconfirm #confirmadel').data('tabela');

        var formData = {
            'id': id,
            'tabela': tabela
        };
        $.ajax({
            url: "<?php echo $baseurl ?>/admin/includes/excluir.php",
            type: "POST",
            data: formData,
            success: function (data) {
                $('#modalconfirm').modal('hide');
                $('#pagina-' + id).remove();
                console.log(data);
            }
        });

    }

    function ativar(tabela, id) {
        $('#ativobtn' + id).html('<i class="fa fa-spinner fa-pulse"></i>');
        var statusatual = $('#ativobtn' + id).data('ativo');
        var status = 1;
        if (statusatual == '1') {
            status = 0;
        }


        var formData = {
            'status': status,
            'tabela': tabela,
            'id': id
        };
        $.ajax({
            url: "<?php echo $baseurl; ?>/admin/includes/ativar.php",
            type: "POST",
            data: formData,
            success: function (data) {
                var slash = '';

                if (status == 0) {
                    slash = '-slash';
                }

                $('#ativobtn' + id).html('<i class="fa fa-eye' + slash + '"></i>').toggleClass('btn-ativo').toggleClass('btn-inativo').data('ativo', status);
                console.log(data);
            }
        });

    }
    function destaque(tabela, id) {


        $('#destaquebtn' + id).html('<i class="fa fa-spinner fa-pulse"></i>');
        var statusatual = $('#destaquebtn' + id).data('ativo');
        var status = 1;
        if (statusatual == '1') {
            status = 0;
        }


        var formData = {
            'status': status,
            'tabela': tabela,
            'id': id
        };
        $.ajax({
            url: "<?php echo $baseurl; ?>/admin/includes/destaque.php",
            type: "POST",
            data: formData,
            success: function (data) {
                var slash = '';

                if (status == 0) {
                    slash = '-o';
                }

                $('#destaquebtn' + id).html('<i class="fa fa-star' + slash + '"></i>').toggleClass('btn-destaque').toggleClass('btn-indestaque').data('ativo', status);
                console.log(data);
            }
        });

    }


    function verificanot(som) {
        var status = $('#novasolicitacao').data('status');
        var qtd = $('#novasolicitacao').data('qtd');
        $.ajax({
            url: "<?php echo $baseurl; ?>/admin/includes/verificanot.php",
            type: "POST",
            success: function (data) {
                if (data != 'false') {
                    var plural1 = '';
                    var plural2 = 'ão';
                    if (data != '1') {
                        var plural1 = 's';
                        var plural2 = 'ões';
                    }
                    var htmlint = '<span class="badgered">' + data + '</span> Nova' + plural1 + ' Solicitaç' + plural2 + ' de Orçamento';
                    if (data != qtd) {
                        if (som == 1) {
                            $('#chatAudio')[0].play();
                        }
                        $('#novasolicitacao').html(htmlint);
                        $('#novasolicitacao').data('qtd', data);
                    }
                    if (status == 'old') {
                        $('#novasolicitacao').data('status', 'new');
                        $('#novasolicitacao').addClass('notifica');
                    }
                } else {
                    $('#novasolicitacao').removeClass('notifica');
                }
            }
        });

    }
    $(function () {
        verificanot(0);
        var conta = 1;
        setInterval(function () {
            conta++;
            console.log(conta);
            verificanot(1);
        }, 2000);
    });


</script>
<audio id="chatAudio">
    <source src="<?php echo $baseurl; ?>/admin/audio/notifica.ogg" type="audio/ogg">
    <source src="<?php echo $baseurl; ?>/admin/audio/notifica.mp3" type="audio/mpeg">
    <source src="<?php echo $baseurl; ?>/admin/audio/notifica.wav" type="audio/wav">
</audio>

<a id="novasolicitacao" data-qdt="<?php
$queryint = "SELECT * FROM ft_orcamentos WHERE visualizado = 0" or die("Erro.." . mysqli_error($link_db));

$queryint = mysqli_query($link_db, $queryint);

echo mysqli_num_rows($queryint);

?>" data-status="old" class="" href="<?php echo $baseurl; ?>/admin/orcamentos.php?s=new">
    <span class="badgered">4</span> Novas Solicitações de Orçamento
</a>
</body>

</html>

