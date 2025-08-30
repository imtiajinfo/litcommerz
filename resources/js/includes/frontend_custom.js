$(document).ready(function(){

    $("#login-submit").submit(function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        let url = $(this).attr("action");
        $("#login-action-btn").attr('disabled', true);
        $("#login-action-btn").text('Loading..');
        
        $.ajax({
            type:"POST",
            url: url,
            data:formData,
            success: function(response){
                
                if(response.success == 1){
                    if(response.type == 1){
                        window.location.href = '/';
                    }else if(response.type == 2){
                        window.location.href = '/admin-panel';
                    }
                }else{
                    $.each(response[0], function (key, item) {
                        toastr.error(item);
                    });
                    if(response.mgs){
                        toastr.error(response.mgs);
                    }
                }
                $("#login-action-btn").attr('disabled', false);
                $("#login-action-btn").text('Login');
            },
            error: function(err){
                console.log(err);
            }
        });
    });


    $("#register-action-btn").click(function(e){
        e.preventDefault();
        
        let formData = $("#register-submit").serialize();
        let url = $("#register-submit").attr("action");
        $("#register-action-btn").attr('disabled', true);
        $("#register-action-btn").text('Loading..');
        
        $.ajax({
            type:"POST",
            url: url,
            data:formData,
            success: function(response){
                console.log(response);
                
                if(response.success == 1){
                    window.location.href = '/verify-your-mail';
                }else{
                    $.each(response[0], function (key, item) {
                        toastr.error(item);
                    });
                }
                $("#register-action-btn").attr('disabled', false);
                $("#register-action-btn").text('Get Started');
            },
            error: function(err){
                console.log(err);
                toastr.error("Something is Rong!");
                
            }
        });
    });
    
    $(".add-to-cart").click(function(e){
        e.preventDefault();
        
        let id = $(this).attr('get-id');
        let selector = $(this);
        
        $.ajax({
            type:"get",
            url: "/cart-add",
            data:{id:id},
            success: function(data){
                if(data.success == 1){
                    toastr.success(data.mgs);
                    selector.removeClass('add-to-cart');
                    $('.cart-'+id).find('i').removeClass('ec ec-add-to-cart');
                    $('.cart-'+id).find('i').addClass('fa fa-check');
                    $(".total-carts").text(data.total_cart);
                    $(".total_cart_price").text(data.total_cart_price);

                    $.ajax({
                        type:"get",
                        url: '/ajax-cart-view',
                        dataType:'html',
                        success: function(response){
                            console.log(response);
                            $(".ajax-cart-view").html(response);
                        },
                        error: function(err){
                            console.log(err);                            
                        }
                    });

                }else{
                    toastr.error(data.mgs);
                }
            },
            error: function(err){
                console.log(err);
            }
        });

    });

    $(document).on('click', '.cart-remove', function(e){
        e.preventDefault();
        
        let index = $(this).attr('index');
        let selector = $(this);
        
        $.ajax({
            type:"get",
            url: "/cart-remove-ajax",
            data:{index:index},
            success: function(data){
                if(data.success == 1){
                    toastr.success(data.mgs);
                    $(".total-carts").text(data.total_cart);
                    $(".total_cart_price").text(data.total_cart_price);

                    $.ajax({
                        type:"get",
                        url: '/ajax-cart-view',
                        dataType:'html',
                        success: function(response){
                            console.log(response);
                            $(".ajax-cart-view").html(response);
                        },
                        error: function(err){
                            console.log(err);                            
                        }
                    });

                }else{
                    toastr.error(data.mgs);
                }
            },
            error: function(err){
                console.log(err);
            }
        });

    });

    $(".wishlist-add-to-cart").click(function(e){
        e.preventDefault();
        
        let id = $(this).attr('get-id');
        let selector = $(this);
        
        $.ajax({
            type:"get",
            url: "/cart-add",
            data:{id:id},
            success: function(data){
                if(data.success == 1){
                    toastr.success(data.mgs);

                    $.ajax({
                        type:"get",
                        url: '/ajax-cart-view',
                        dataType:'html',
                        success: function(response){
                            console.log(response);
                            selector.text("Added");
                        },
                        error: function(err){
                            console.log(err);                            
                        }
                    });

                }else{
                    toastr.error(data.mgs);
                }
            },
            error: function(err){
                console.log(err);
            }
        });

    });


    $(".add-wishlist").click(function(e){
        e.preventDefault();
        
        let id = $(this).attr('get-id');
        let selector = $(this);
        
        $.ajax({
            type:"get",
            url: "/wishlist/store",
            data:{id:id},
            success: function(data){
                if(data.success == 1){
                    selector.removeClass('text-gray-6');
                    selector.addClass('text-primary');
                    selector.html('<i class="fa fa-heart" aria-hidden="true"></i> Wishlist');
                    toastr.success(data.mgs);

                }else if(data.success == 2){
                    selector.removeClass('text-primary');
                    selector.addClass('text-gray-6');
                    selector.html('<i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist');
                    toastr.success(data.mgs);

                }else{
                    toastr.error(data.mgs);
                }
            },
            error: function(err){
                console.log(err);
            }
        });

    });


    // $(".cart-plus").click(function(e){
    //     e.preventDefault();
        
    //     let index = $(this).attr('index');
    //     let selector = $(this);

    //     $.ajax({
    //         type:"get",
    //         url: "/cart-plus",
    //         data:{index:index},
    //         success: function(data){
    //             selector.parent().parent().find('input').val(data.qty);
    //             selector.parent().parent().parent().parent().parent().find('.sub-total-price').text(data.price);
    //             $("#sub-total-price").text(data.sub_total);
    //             $("#last-total").text(data.grand_total);
    //             // $("#before-coupon-amount").text(data.before_discount);
    //             $("#before-coupon-amount").text("9999");
    //             console.log($("#before-coupon-amount").length); 

    //         },
    //         error: function(err){
    //             console.log(err);
    //         }
    //     });

    // });

    // $(".cart-minus").click(function(e){
    //     e.preventDefault();
        
    //     let index = $(this).attr('index');
    //     let selector = $(this);

    //     $.ajax({
    //         type:"get",
    //         url: "/cart-minus",
    //         data:{index:index},
    //         success: function(data){
    //             selector.parent().parent().find('input').val(data.qty);
    //             selector.parent().parent().parent().parent().parent().find('.sub-total-price').text(data.price);
    //             $("#sub-total-price").text(data.sub_total);
    //             $("#last-total").text(data.sub_total);
    //             $("#before-coupon-amount").text(data.before_discount);
    //         },
    //         error: function(err){
    //             console.log(err);
    //         }
    //     });

    // });


    $(".details-cart-plus").click(function(e){
        e.preventDefault();
        
        let index = $(this).attr('index');
        let selector = $(this);

        $.ajax({
            type:"get",
            url: "/cart-plus",
            data:{index:index},
            success: function(data){
                
                selector.parent().parent().find('input').val(data.qty);
                selector.parent().parent().parent().parent().parent().find('.sub-total-price').text(data.price);
                $("#sub-total-price").text(data.sub_total);
                $("#last-total").text(data.sub_total);
            },
            error: function(err){
                console.log(err);
                let qty = parseInt($(".cart-input-change").val());
                selector.parent().parent().find('input').val(qty+1);
            }
        });

    });

    $(".details-cart-minus").click(function(e){
        e.preventDefault();
        
        let index = $(this).attr('index');
        let selector = $(this);

        $.ajax({
            type:"get",
            url: "/cart-minus",
            data:{index:index},
            success: function(data){
                selector.parent().parent().find('input').val(data.qty);
                selector.parent().parent().parent().parent().parent().find('.sub-total-price').text(data.price);
                $("#sub-total-price").text(data.sub_total);
                $("#last-total").text(data.sub_total);
            },
            error: function(err){
                console.log(err);
                let qty = parseInt($(".cart-input-change").val());
                if(qty > 1){
                    selector.parent().parent().find('input').val(qty-1);
                }else{
                    toastr.error("Minimum Quantity One!");
                    selector.parent().parent().find('input').val(1);
                }
            }
        });

    });


    $(".cart-input-change").keyup(function(e){
        e.preventDefault();
        
        let index = $(this).attr('index');
        let qty = $(this).val();
        let selector = $(this);

        $.ajax({
            type:"get",
            url: "/cart-change-qty",
            data:{index:index, qty:qty},
            success: function(data){
                selector.val(qty);
                selector.parent().parent().parent().parent().parent().find('.sub-total-price').text(data.price);
                $("#sub-total-price").text(data.sub_total);
                $("#last-total").text(data.sub_total);
            },
            error: function(err){
                console.log(err);
            }
        });

    });

    $(".details-add-to-cart").click(function(e){
        e.preventDefault();
        let url = $(this).attr('href');
        let status = $(this).attr('status');

        let qty = $(".cart-input-change").val();
        window.location.href = url+"?qty="+qty+"&status="+status;
    })
    $("#checkout-form-submit").submit(function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        $(".order-placed").attr('disabled', true);

        $.ajax({
            url: "/checkout/store",
            type:"post",
            data:formData,
            dataType:'json',
            success: function(data){
                console.log(data);

                if(data.success == 1){
                    toastr.success(data.mgs);
                    window.location.href = '/orders';
                }else if(data.error == 1){
                    toastr.error(data.mgs);
                }else{
                    $.each(data[0], function (key, item) {
                        toastr.error(item);
                    });
                }

                $(".order-placed").attr('disabled', false);
                
            },
            error: function(err){
                console.log(err);
            }
        });
    })

})