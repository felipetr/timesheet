$(window).load(function () {
    centalizalogin();

});
$(window).resize(function () {
    centalizalogin();
});

function centalizalogin()
{
    var total = $(window).height();
    var login = $('.loginform').outerHeight();
    var dif = total-login;
    if (dif > 0)
    {
        var margin = dif/2;
        $('body').css('padding-top',margin);//works
    }
}

function sendmail(baseurl,email,nome,corpo,assunto,form)
{



    modalalertloading();

    var formData = {
        'email'              : email,
        'nome'             : nome,
        'corpo'             : corpo,
        'assunto'             : assunto
    };
    $.ajax({
        url : baseurl+"/includes/sendmail.php",
        type: "POST",
        data : formData,
        success: function(data)
        {

            modalalert(data);

            $(form)[0].reset();
        }
    });

}


function modalalertloading()
{
    $('#modalalert .modal-title').html('Conectando...');
    $('#modalalert .modal-body').css('display','block').html('<div class="modalload"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
    $('#modalalert .modal-footer').css('display','none');
    $('#modalalert').modal('show');
}


function  modalalert(alerta)
{

    $('#modalalert .modal-title').html(alerta);
    $('#modalalert .modal-body').css('display','none');
    $('#modalalert .modal-footer').css('display','block');
}

function logarse(baseurl)
{


    modalalertloading();


    var formData = {
        'email'              : $('#formlogin #email').val(),
        'senha'             : $('#formlogin #senha').val()
    };
    $.ajax({
        url : baseurl+"/admin/includes/logarse.php",
        type: "POST",
        data : formData,
        success: function(data) {

            if (data == '')
            {

                window.location = baseurl + '/admin';
            }
            else
            {
                modalalert(data);
            }
        }
    });

}


function reenviasenha(baseurl)
{


    modalalertloading();


    var formData = {
        'email'              : $('#formlogin #email').val()
    };
    $.ajax({
        url :  baseurl+"/admin/includes/reenviasenha.php",
        type: "POST",
        data : formData,
        success: function(data) {


                modalalert(data);

        }
    });

}

function recadastrasenha(baseurl) {
    $('#modalalert .modal-title').html('Salvando...');
    $('#modalalert .modal-body').html('<div class="modalload"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
    $('#modalalert').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });


    var senha = $('#formreenviasenha #senha').val();
    var senha2 = $('#formreenviasenha #senha2').val();
    var hash = $('#formreenviasenha #hash').val();
    var iduser = $('#formreenviasenha #iduser').val();
    var mostraerro = '';

    if(senha2 != senha)
    {

        mostraerro = 'Senhas não coincidem! Verifique se os campos foram preenchidos corretamente e tente novamente!';


    }



    var pattern = new RegExp('^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$');
    var isValid = pattern.test(senha);

    if (!isValid) {

        mostraerro = 'A senha deve ter apenas letras e números e ter ao menos um número e uma letra!';
    }

    if (senha.length < 8)
    {

        mostraerro =  'A senha deve ter no mínimo 8 dígitos!';


    }

    if (mostraerro != '')
    {
        $('#modalalert .modal-title').html(mostraerro);
        $('#modalalert .modal-body').html('');
        return false;

    }



    var formData = {
        'senha': senha,
        'hash': hash,
        'iduser': iduser

    };
    $.ajax({

        url: baseurl + "/admin/includes/salvasenha.php",
        type: "POST",
        data: formData,
        success: function (data) {
            $('#modalalert').modal({
                backdrop: true,
                keyboard: true

            });
            console.log(data);
            $('#modalalert .modal-title').html(data);
            $('#modalalert .modal-body').html('');
        }
    });

}