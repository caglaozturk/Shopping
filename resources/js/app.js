require('./bootstrap');

setTimeout(() => {
    $('.alert').slideUp(500);
}, 3000);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/*
$('.product-piece-dec, .product-piece-inc').on('click', function(){
    let id = $(this).attr('data-id');
    let piece = $(this).attr('data-piece');
    console.log(id+piece);
    return;
    $.ajax({
        type: 'PATCH',
        url: '/cart/update/'+id,
        data: {piece: piece},
        success: function(){
            window.location.href = '/cart';
        }
    });
});
*/
