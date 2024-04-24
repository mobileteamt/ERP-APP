var host = window.location.origin;
var host_name = host.match('localhost');
if(host_name){
    var baseURL = host+'/erp-app';
}
else{
    var baseURL = host;
}
var csrf_token = $(document).find('input[name="csrf_test_name"]').val();

function showLoader(){
   $('.loader-container').removeClass('d-none');
}

function hideLoader(){
    $('.loader-container').addClass('d-none');
 }

$(document).on('click','.qtySection .plus',function(){
    var thisId = $(this).attr('data-this-id');
    var cartId = $(this).attr('data-cart-id');
    var thisSection = $(this).attr('data-section');
    var max_qty = $(this).attr('data-max');

    var thisVal = $('.qtSection_'+thisSection+' .qtyCount_'+thisId).val();
    if(thisVal >= 999){
        return false;
    }

    if(thisVal == max_qty){
        return false;
    }

    $('.qtSection_'+thisSection+' .qtyCount_'+thisId).val(parseInt($('.qtSection_'+thisSection+' .qtyCount_'+thisId).val()) + 1 );

    if( $(this).parents('.qtySection').hasClass('qtSection_cart') ){
        updateCart(cartId, 'plus', $('.qtSection_'+thisSection+' .qtyCount_'+thisId).val());
        return false;
    }
});

$(document).on('click','.qtySection .minus',function(){
    var thisId = $(this).attr('data-this-id');
    var cartId = $(this).attr('data-cart-id');
    var thisSection = $(this).attr('data-section');
    
    $('.qtSection_'+thisSection+' .qtyCount_'+thisId).val(parseInt($('.qtSection_'+thisSection+' .qtyCount_'+thisId).val()) - 1 );
    if ($('.qtSection_'+thisSection+' .qtyCount_'+thisId).val() == 0) {
        $('.qtSection_'+thisSection+' .qtyCount_'+thisId).val(1);
    }

    if( $(this).parents('.qtySection').hasClass('qtSection_cart') ){
        updateCart(cartId,'minus',$('.qtSection_'+thisSection+' .qtyCount_'+thisId).val());
        return false;
    }
});

$(document).on('keyup','.qtySection .count',function(){
    var selectedQty = $.trim($(this).val());
    if(selectedQty >= 999){
        return false;
    }
});

$(document).on('keypress','.qtySection .count',function(e){
    selectedQtyLen = $(this).val().length;
    if(selectedQtyLen > 2){
        return false;
    }
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});

function updateCart(id, action, qty){
    showLoader();
    $.ajax({
        url: baseURL + "/update_cart_qty",
        method: "POST",
        data: {'cart_id':id,'qty':qty,'action':action,'csrf_token':csrf_token},
        success: function (result) {
            hideLoader();
            if(result){
                var res = $.parseJSON(result);
                if(res.error){
                    Swal.fire({ position: "top", text: res.message, showConfirmButton: false, timer: 2000, icon: "error"});
                }
                else{
                    $(document).find('#cart-total .amount').html(res.cart_total);
                    //Swal.fire({ position: "top", text: res.message, showConfirmButton: false, timer: 2000, icon: "success"});
                }
            }
            else{
                Swal.fire({ position: "top", text: 'Something went wrong!!', showConfirmButton: false, timer: 2000, icon: "error"});
            }
        }
    });
}

$(document).ready(function(){

    $(document).on('click', '.add_to_cart', function(){
        
        var product_id = $(this).attr('data-product-id');
        // console.log(product_id);
        // var qty = $('#qty_'+product_id).val();
        var thisSection = $(this).attr('data-section');
        var qty = $('.qtSection_'+thisSection).find('.qtyCount_'+product_id).val();
        
        
        /*
        $('.qty-input').removeClass('error-input');
        if(qty == '' || qty == '0'){
            $('#qty_'+product_id).addClass('error-input');
            return false;
        }else{
            $('#qty_'+product_id).removeClass('error-input');
        }
        if(isNaN(qty)){
            $('#qty_'+product_id).val('');
            return false;
        }
        */

        $.ajax({
            url: baseURL + "/add_to_cart",
            method: "POST",
            //dataType : "json",
            // contentType: "application/json",
            data: {'product_id':product_id,'qty':qty,'csrf_token':csrf_token},
            success: function (result) {
                // console.log(result);
                if(result){
                    var res = $.parseJSON(result);
                    // alert(res.cart_count);
                    if(res.error){
                        Swal.fire({ position: "top", text: res.message, showConfirmButton: false, timer: 2000, icon: "error"});
                    }
                    else{
                        $(document).find('#cart-count').html(res.cart_count);
                        Swal.fire({ position: "top", text: res.message, showConfirmButton: false, timer: 2000, icon: "success"});
                        $('#qty_'+product_id).val('');
                    }
                }
                else{
                    Swal.fire({ position: "top", text: 'Something went wrong!!', showConfirmButton: false, timer: 2000, icon: "error"});
                }
            }
        });
    });
});

function deleteCart(id){
    var result = window.confirm("Are you sure you want to delete this cart?");
    if(result){
        // window.location.href = baseURL+"admin/delete-product/"+id;

        $.ajax({
            url: baseURL + "/delete_cart",
            method: "POST",
            data: {'cart_id':id,'csrf_token':csrf_token},
            success: function (result) {
                console.log(result);
                if(result){
                    var res = $.parseJSON(result);
                    // alert(res.cart_count);
                    if(res.error){
                        Swal.fire({ position: "top", text: res.message, showConfirmButton: false, timer: 2000, icon: "error"});
                    }
                    else{
                        
                        if(res.cart_total == 0){
                            window.location.reload();
                        }
                        else{
                            Swal.fire({ position: "top", text: res.message, showConfirmButton: false, timer: 2000, icon: "success"});
                            $('#cart_'+id).remove();
                            $(document).find('#cart-total .amount').html(res.cart_total);
                        }
                        
                    }
                }
                else{
                    Swal.fire({ position: "top", text: 'Something went wrong!!', showConfirmButton: false, timer: 2000, icon: "error"});
                }
            }
        });
    }
    else{
        return false;
    }
}