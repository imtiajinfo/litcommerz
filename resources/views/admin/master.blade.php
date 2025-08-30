<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="My Daily Shop Admin Dashboard">
    <meta name="keywords" content="grocery-shop, ecommerce, food, electronics, clothes, corporate, creative, management, modern">
    <meta name="author" content="My Daily Shop">
    <meta name="robots" content="noindex, nofollow">
    <title>My Daily Shop</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/logo/'.$setting->meta_logo) }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/toastr/toatr.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/dragula/css/dragula.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    {{-- summernote  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css" integrity="sha512-rDHV59PgRefDUbMm2lSjvf0ZhXZy3wgROFyao0JxZPGho3oOuWejq/ELx0FOZJpgaE5QovVtRN65Y3rrb7JhdQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- drag drop image  --}}
    <link rel="stylesheet" href="{{ asset('admin/drag_drop_image/image-uploader.min.css') }}">
    {{-- pace js  --}}
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
    <!-- vite -->
    {{-- @vite(['resources/js/app.js']) --}}

</head>

<body>
    
      <button id="scrollTopBtn" class="btn text-white shadow">
          <i class="fas fa-chevron-up"></i>
      </button>

    <div class="main-wrapper">

      <style>
        #scrollTopBtn {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 18px;
            z-index: 9999;
            cursor: pointer;
            background-color: #ff9f43;
        }

        #scrollTopBtn:hover {
            opacity: 0.8;
        }
      </style>

        
        @include('admin.layouts.header')
        
        @include('admin.layouts.sidebar')
        
        <div class="page-wrapper">
            <div class="content" id="main-content">
                <div id="global-loader">
                    <div class="whirly-loader"> </div>
                </div>
            </div>
        </div>
        
    </div>

    <x-admin.modal />

    <script>
        var base_url = "{{ $module->url }}";
    </script>
    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/toastr/toastr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    {{-- validate js  --}}
    {{-- <script src="{{ asset('admin/js/jquery.validate.1.19.5.js') }}"></script> --}}
    {{-- summernote  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.js" integrity="sha512-qTQLA91yGDLA06GBOdbT7nsrQY8tN6pJqjT16iTuk08RWbfYmUz/pQD3Gly1syoINyCFNsJh7A91LtrLIwODnw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- drag drop image  --}}
    <script src="{{ asset('admin/drag_drop_image/image-uploader.min.js') }}"></script>
    {{-- sweetalert  --}}
    <script src="{{ asset('admin/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/dragula/js/drag-drop.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/dragula/js/dragula.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        $(document).ready(function() {
            var $scrollBtn = $("#scrollTopBtn");

            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $scrollBtn.fadeIn();
                } else {
                    $scrollBtn.fadeOut();
                }
            });

            $scrollBtn.click(function() {
                $("html, body").animate({ scrollTop: 0 }, 500);
            });
        });
    </script>
    

</body>

