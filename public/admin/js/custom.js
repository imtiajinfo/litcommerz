$(document).ready(function () {

      const params = new URLSearchParams(window.location.hash.split('?')[1] || '');
      perpage_val = params.get('perpage') || $('#perpage').val();
      $('#perpage').val(perpage_val); 

    var ajax_url = location.hash.replace(/^#/, '');

    if (ajax_url.length < 1) {
        ajax_url = 'dashboard';
        window.location.hash = ajax_url;
    } else {
        $(".anchor").removeClass('active');
        $(".anchor").each(function () {
            if ($(this).attr('href') == ajax_url) {
                $(this).addClass('active');
                $(this).parent('li').parent('ul').css('display', 'block');
            }
        });
    }

    //loader show
    $('#main-content').html('<div id="global-loader"><div class="whirly-loader"> </div></div>');

    LoadPageContent(ajax_url);

    $(document).on('click', '.anchor', function (e) {
        e.preventDefault();

        search_change_val = null;
        search_change_status = null;

        if ($(this).attr('href')) {
            var url = $(this).attr('href');
            var viewType = $(this).attr('viewType');
            
            if (viewType == 'modal' && url != '#') {

                // var modalTitle = $(this).attr('modalTitle');
                // $("#modal-title").text(modalTitle);
                // $(".post-popup.job_post").addClass("active");
                // $(".wrapper").addClass("overlay");

                // LoadModalPageContent(url);

            } else if (url != '#') {

                window.location.hash = url;
                //loader show
                $(".anchor").removeClass('active');
                $(this).addClass('active'); 
                LoadPageContent(url);

            }
        }
    });

});

function LoadPageContent(url, selector = false) {
    site_url = window.location.origin + '/' + base_url + '/' + url;

    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: site_url,
        type: "GET",
        dataType: "html",
        success: function (data) {

            if (data) {
                $("#main-content").html(data);
            } else {
                location.replace = "/login";
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            $('#main-content').html('');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });

}

$(document).on('click', '.show-modal', function (e) {
    e.preventDefault();
    let modalTitle = $(this).attr('modalTitle');
    hideModal = $(this).attr('hideModal');
    $('.modal-title').text(modalTitle);
    let modalSize = $(this).attr('modalSize');
    let url = base_url + '/' +$(this).attr('url');

    modalShow(url, modalSize);

});

function modalShow(url, modalSize=null){
    $("#modal-dialog").removeClass('modal-sm');
    $("#modal-dialog").removeClass('modal-lg');
    $("#modal-dialog").removeClass('modal-md');
    $("#modal-dialog").removeClass('modal-xl');

    // console.log(modalSize);

    if(modalSize){
        $("#modal-dialog").addClass('modal-'+modalSize);
    }else{
        $("#modal-dialog").addClass('modal-md');
    }
    $("#show-modal").modal('show');

    $("#modal-body").html('<div class="text-center p-3"><div class="spinner-grow spinner-grow-sm mr-3" role="status"></div><div class="spinner-grow spinner-grow-sm mr-3" role="status"></div><div class="spinner-grow spinner-grow-sm mr-3" role="status"></div></div>');

    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: url,
        type: "GET",
        dataType: "html",
        success: function (data) {
            $("#modal-body").html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });
}

$(document).on('change', '.form-load .toggle-status', function() {
    $(this).closest('form').submit();
});

$(document).on('submit', '.form-load', function (e) {
    e.preventDefault();
    let url = $(this).attr('action');
    let type = $(this).attr('type');
    let selector = $(this);
    selector.find("button[type='submit']").attr('disabled', true);
    let hideModal = $(this).attr('hideModal');
    
    let formData = new FormData($(this)[0]);

    //  for (const [key, value] of formData.entries()) {
    //     console.log(`${key}: ${value}`);
    //  }
    let buttonText = $(".modal-button-btn").text();
    $(".modal-button-btn").text('loading..');
    $(".modal-button-btn").attr('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        dataType: 'json',
        success: function (data) {
            
            selector.find("button[type='submit']").attr('disabled', false);

            if(data.success == true){
                toastr.success(data.mgs);

                if(type == 'create'){
                    $("#modal-body form")[0].reset();
                    $("#modal-body form img").attr('src', '');
                }
                $(".modal-button-btn").text(buttonText);
                $(".modal-button-btn").attr('disabled', false);
                
                // if(hideModal=='hide'){
                    $("#show-modal").modal('hide');
                // }

                var ajax_url = location.hash.replace(/^#/, '');
                LoadPageContent(ajax_url);

                
            }else {
                if (data.errors) {
                    $.each(data.errors, function (key, messages) {
                        $.each(messages, function (index, msg) {
                            toastr.error(msg);
                        });
                    });
                } else if (data.mgs) {
                    toastr.error(data.mgs);
                }

                $(".modal-button-btn").text(buttonText).attr('disabled', false);
            }

            $(".modal-button-btn").text(buttonText);
            $(".modal-button-btn").attr('disabled', false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $(".modal-button-btn").text(buttonText).attr('disabled', false);

            if (jqXHR.status === 422 && jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                $.each(jqXHR.responseJSON.errors, function (key, messages) {
                    $.each(messages, function (index, msg) {
                        toastr.error(msg);
                    });
                });
            } else if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                toastr.error(jqXHR.responseJSON.message);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                });
            }
        }
    });

});

$(document).on('click', '.delete', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    let url = $(this).attr('url');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                url: base_url + url,
                type: 'DELETE',
                data: {id : id},
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    var ajax_url = location.hash.replace(/^#/, '');
                    LoadPageContent(ajax_url);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                }
            });
          
        }
      })

})

// Replace the existing page-link click handler with this:
$(document).on('click', '.page-link', function(e) {
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    
    // Get all current parameters
    let currentHash = location.hash.replace(/^#/, '');
    let [url, existingParams] = currentHash.split('?');
    let searchParams = new URLSearchParams(existingParams || '');
    
    // Update or add page parameter
    searchParams.set('page', page);
    
    // Ensure perpage is included
    if (perpage_val) {
        searchParams.set('perpage', perpage_val);
    }
    
    // Build new URL
    let newUrl = url + '?' + searchParams.toString();
    
    // Update page content and URL hash
    LoadPageContent(newUrl);
    window.location.hash = newUrl;
});

$(document).on('change', '#perpage', function(e) {
    e.preventDefault();
    perpage_val = $(this).val();

    let url = location.hash.replace(/^#/, '').split('?')[0];
    let query = "perpage=" + perpage_val;

    if (search_change_val && search_change_status) {
        query += "&" + search_change_status + "=" + search_change_val;
    }

    LoadPageContent(url + "?" + query);
    window.location.hash = url + "?" + query;
});

$(document).on('submit', '#search', function(e) {
    e.preventDefault();

    let search = $("#search-input").val();
    let url = location.hash.replace(/^#/, '').split('?')[0];
    let currentParams = new URLSearchParams(location.hash.split('?')[1] || '');

    if (search) {
        currentParams.set('search', search);
    } else {
        currentParams.delete('search');
    }

    if (perpage_val) {
        currentParams.set('perpage', perpage_val);
    }

    let query = currentParams.toString();

    LoadPageContent(url + "?" + query);
    window.location.hash = url + "?" + query;

    setTimeout(() => {
        $('#search-input').focus().val(search);
    }, 1000);
});

$(document).on('submit', '#date-filter', function(e) {
    e.preventDefault();

    let from_date = $("input[name='from_date']").val();
    let to_date   = $("input[name='to_date']").val();

    let url = location.hash.replace(/^#/, '').split('?')[0];
    let currentParams = new URLSearchParams(location.hash.split('?')[1] || '');

    if (from_date) {
        currentParams.set('from_date', from_date);
    } else {
        currentParams.delete('from_date');
    }

    if (to_date) {
        currentParams.set('to_date', to_date);
    } else {
        currentParams.delete('to_date');
    }

    if (perpage_val) {
        currentParams.set('perpage', perpage_val);
    }

    let query = currentParams.toString();

    LoadPageContent(url + "?" + query);
    window.location.hash = url + "?" + query;
});

$(document).on('click', '.data-edit', function(e){
    e.preventDefault();
    let modalTitle = $(this).attr('modalTitle');
    hideModal = $(this).attr('hideModal');
    $('.modal-title').text(modalTitle);
    let modalSize = $(this).attr('modalSize');
    let url = base_url + '/' +$(this).attr('url');
    modalShow(url, modalSize);
});

// $( "form" ).each( function() {
//     $( this ).validate( options );
// });


// function LoadModalPageContent(url, selector = false) {
//     site_url = "{{url('/')}}/mentor-member/" + url;

//     $("#modal-main-content").html('<div id="loader"><div class="process-comm"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div></div>');

//     $.ajax({
//         mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
//         url: site_url,
//         type: "GET",
//         dataType: "html",
//         success: function (data) {

//             if (data) {
//                 $("#modal-main-content").html(data);
//                 $('#modal-loader').hide();
//             } else {
//                 location.replace = "/login";
//             }
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             toastr.error(errorThrown);
//         }
//     });

// }


$(document).on('submit', '.form-load-product-update', function (e) {
    e.preventDefault();
    let url = $(this).attr('action');
    let type = $(this).attr('type');
    let hideModal = $(this).attr('hideModal');
    
    let formData = new FormData($(this)[0]);
    let buttonText = $(".modal-button-btn").text();
    $(".modal-button-btn").text('loading..');
    $(".modal-button-btn").attr('disabled', true);

    var images = $('.uploaded-image:not([data-index="0"]) img');
    var old_images = [];
    images.each(function() {
        var src = $(this).attr('src');
        old_images.push(src);
    });

    $.ajax({
        url: url+'?old_images='+old_images,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        dataType: 'json',
        success: function (data) {

            if(data.success == true){
                toastr.success(data.mgs);

                if(type == 'create'){
                    $("#modal-body form")[0].reset();
                    $("#modal-body form img").attr('src', '');
                }
                $(".modal-button-btn").text(buttonText);
                $(".modal-button-btn").attr('disabled', false);
                
                // if(hideModal=='hide'){
                    $("#show-modal").modal('hide');
                // }

                var ajax_url = location.hash.replace(/^#/, '');
                LoadPageContent(ajax_url);

                
            }else{
                $.each(data[0], function (key, item) {
                    toastr.error(item);
                });
                if(data.mgs){
                    toastr.error(data.mgs);
                }
            }

            $(".modal-button-btn").text(buttonText);
            $(".modal-button-btn").attr('disabled', false);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });

    
});

$(document).on('click', '#category-sorting', function(e){
    e.preventDefault();

    let category_arr = [];
    $(".draggable-sl").each(function(index, element){
        value = $(this).attr('sl');
        category_arr.push(value);
    });

    $.ajax({
        url: 'admin-panel/category-sorting',
        type: 'GET',
        data: {category_ids:category_arr, type: 'store'},
        success: function (data) {
            toastr.success(data.mgs);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });

});


$(document).on('click', '#offer-sorting', function(e){
    e.preventDefault();

    let offer_arr = [];
    $(".draggable-sl").each(function(index, element){
        value = $(this).attr('sl');
        offer_arr.push(value);
    });

    $.ajax({
        url: 'admin-panel/offer-sorting',
        type: 'GET',
        data: {offer_ids:offer_arr, type: 'store'},
        success: function (data) {
            toastr.success(data.mgs);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        }
    });

});
search_change_val = null;
search_change_status = null;

function change(val, status) {
    search_change_val = val;
    search_change_status = status;

    let url = location.hash.replace(/^#/, '').split('?')[0];

    let currentParams = new URLSearchParams(location.hash.split('?')[1] || '');

    currentParams.set(status, val);

    if (perpage_val) {
        currentParams.set('perpage', perpage_val);
    }
    let query = currentParams.toString();

    LoadPageContent(url + "?" + query);
    window.location.hash = url + "?" + query;
}

$(document).on('click', '.productRemove', function(e){
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Remove it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $(this).parent().parent().remove();
            toastr.success('Your Order Product has been Removed!');
        }
      })
    
})
$(document).on('click', '#addNewProductButton', function(e){
    
    e.preventDefault();
    let jsonData = $("#addNewProduct").val();
    const product = JSON.parse(jsonData);
    let base_url = window.location.origin; 
       
    
    $("#productAddSection").prepend(`<tr class="odd">                          
        <td>
            <input type="hidden" name="product_id[]" value="${product.id}">
            <a target="_blank" href="${base_url}/product/${product.slug}">${product.slug}</a>
        </td>
        <td>
            <a target="_blanck" href="${base_url}/product/${product.slug}"><img src="${base_url}/frontend/images/product/${product.first_img.image}" style="height:80px"></a>
        </td>
        <td>
            <input type="number" step="any" class="form-control" value="${product.sell_price}" name="product_price[]">
        </td>
        <td>
            <input type="number" step="any" class="form-control" value="${product.offer_amount}" name="discount[]">
        </td>
        <td>
            <input type="number" step="any" class="form-control" value="1" name="quantity[]">
        </td>
        <td>
            <button class="btn btn-danger productRemove">Remove</button>
        </td>
    </tr>`);
    $("#addNewProduct").val('').trigger('change');
    toastr.success('New Product Added!');
    
});

$(document).on('click', '#addNewProductButton2', function(e){
    
    e.preventDefault();
    let jsonData = $("#selectproduct2").val();
    const product = JSON.parse(jsonData);
    let base_url = window.location.origin;
       
    
    $("#productAddSection").prepend(`<tr class="odd">                          
        <td>
            <input type="hidden" name="product_id[]" value="${product.id}">
            <a target="_blank" href="${base_url}/product/${product.slug}">${product.slug}</a>
        </td>
        <td>
            <a target="_blanck" href="${base_url}/product/${product.slug}"><img src="${base_url}/frontend/images/product/${product.first_img.image}" style="height:80px"></a>
        </td>
        <td>
            <input type="number" step="any" class="form-control" value="${product.sell_price}" name="product_price[]">
        </td>
        <td>
            <input type="number" step="any" class="form-control" value="${product.offer_amount}" name="discount[]">
        </td>
        <td>
            <input type="number" step="any" class="form-control" value="1" name="quantity[]">
        </td>
        <td>
            <button class="btn btn-danger productRemove">Remove</button>
        </td>
    </tr>`);
    $("#selectproduct2").val('').trigger('change');
    toastr.success('New Product Added!');
    
});