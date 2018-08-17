


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



function excluir(id)
{

    $('#modalconfirm .modal-title span').html($('#nome-'+id).html());
    $('#modalconfirm #confirmadel').data('id',id);
    $('#modalconfirm').modal('show');

}

function selectdestaque()
{
    $('#destaqueselect i').removeClass('fa-check-square-o').removeClass('fa-square-o');
    var destaque = $('#destaqueinput').val();
    var classe = 'check-';
    var novodestaque = '1';
    if(destaque != '0')
    {
        classe = '';
        novodestaque = '0';
    }
    $('#destaqueinput').val(novodestaque);
    $('#destaqueselect i').addClass('fa-'+classe+'square-o');

}


