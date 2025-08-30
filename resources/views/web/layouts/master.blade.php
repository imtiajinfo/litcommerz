@php
    $setting = \App\Models\Setting::find(1);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>@hasSection('title') @yield('title') @else {{"My Daily Shop"}} @endif</title>

    <meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/logo/'.$setting->meta_logo) }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/font-electro.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/hs-megamenu/src/hs.megamenu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/slick-carousel/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- CSS Electro Template -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/toastr/toatr.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- meta tags  --}}
    <meta name="description" content="@hasSection('meta_desc') @yield('meta_desc') @else {{"My Daily Shop | Best Halal Shop in Japan"}} @endif">
    <meta name="keywords" content="@hasSection('meta_keyword') @yield('meta_keyword') @else {{"Best Halal Shop in Japan for Muslim Community/Asian/African/Part of Europe and America"}} @endif">
    <meta property="og:image" content="@hasSection('meta_img') @yield('meta_img') @else {{ asset('frontend/logo/'.$setting->logo) }} @endif">
    <meta property="og:image:height" content="@hasSection('meta_img_height') @yield('meta_img_height') @else {{"100"}} @endif">

    <!-- vite -->
    {{-- @vite(['resources/js/app.js']) --}}

</head>

<body>

    <x-web.header />

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">

        @yield('main')

    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <x-web.footer />

    <!-- ========== SECONDARY CONTENTS ========== -->
    <x-web.aside_cart />
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- sidebar cart section icon -->
    <a class="u-go-to1" role="button" class="u-header-topbar__nav-link target-of-invoker-has-unfolds" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent" data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500" id="sidebarNavToggler">
        <div style="font-size: large; border-radius: 50%; padding: 10px; ">
            <button type="button" class="btn btn-white text-primary position-relative" style="left: -10px;border: 1px solid #ccc;height: 55px;box-shadow: 0 4px 8px 0 rgb(0 0 0 / 29%), 0 6px 20px 0 rgb(0 0 0 / 18%);font-size: large;"> 
                <i class="fa fa-shopping-cart"></i>
                <span class="position-absolute top-0 start-100 translate-middle bg-primary text-white border border-light rounded-circle" style="min-width: 25px;height: 27px;padding: 0px;left: -16px;top: -5px;font-size: medium;font-weight:500">
                    <span class="visually-hidden"><span class="total-carts">{{count(Helper::cart_products())}}</span></span>
                </span>
            </button>
        </div>
    </a>
    <!-- End sidebar cart section icon -->

    <a href="https://wa.me/819064764347" target="_blank" class="floating-button whatsapp-btn"
      title="Chat on WhatsApp">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
    </a>

    <!-- Go to Top -->
    <a class="js-go-to u-go-to" href="#" data-position='{"bottom": 15, "right": 15 }' data-type="fixed"
        data-offset-top="400" data-compensation="#header" data-show-effect="slideInUp" data-hide-effect="slideOutDown">
        <span class="fas fa-arrow-up u-go-to__inner"></span>
    </a>
    <!-- End Go to Top -->
    

    <!-- JS Global Compulsory -->
    <script src="{{ asset('frontend/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap/bootstrap.min.js') }}"></script>

    <!-- JS Implementing Plugins -->
    <script src="{{ asset('frontend/assets/vendor/appear.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/hs-megamenu/src/hs.megamenu.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/svg-injector/dist/svg-injector.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/fancybox/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/typed.js/lib/typed.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/slick-carousel/slick/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

    <!-- JS -->
    <script src="{{ asset('frontend/assets/js/hs.core.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.countdown.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.header.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.hamburgers.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.unfold.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.focus-state.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.malihu-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.validation.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.fancybox.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.onscroll-animation.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.slick-carousel.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.show-animation.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.svg-injector.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.go-to.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/hs.selectpicker.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/toastr/toastr.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('frontend/custom.js') }}"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(window).on('load', function () {
            // initialization of HSMegaMenu component
            $('.js-mega-menu').HSMegaMenu({
                event: 'hover',
                direction: 'horizontal',
                pageContainer: $('.container'),
                breakpoint: 767.98,
                hideTimeOut: 0
            });

            // initialization of svg injector module
            $.HSCore.components.HSSVGIngector.init('.js-svg-injector');
        });

        $(document).on('ready', function () {
            // initialization of header
            $.HSCore.components.HSHeader.init($('#header'));

            // initialization of animation
            $.HSCore.components.HSOnScrollAnimation.init('[data-animation]');

            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                afterOpen: function () {
                    $(this).find('input[type="search"]').focus();
                }
            });

            // initialization of popups
            $.HSCore.components.HSFancyBox.init('.js-fancybox');

            // initialization of countdowns
            var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
                yearsElSelector: '.js-cd-years',
                monthsElSelector: '.js-cd-months',
                daysElSelector: '.js-cd-days',
                hoursElSelector: '.js-cd-hours',
                minutesElSelector: '.js-cd-minutes',
                secondsElSelector: '.js-cd-seconds'
            });

            // initialization of malihu scrollbar
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

            // initialization of forms
            $.HSCore.components.HSFocusState.init();

            // initialization of form validation
            $.HSCore.components.HSValidation.init('.js-validate', {
                rules: {
                    confirmPassword: {
                        equalTo: '#signupPassword'
                    }
                }
            });

            // initialization of show animations
            $.HSCore.components.HSShowAnimation.init('.js-animation-link');

            // initialization of fancybox
            $.HSCore.components.HSFancyBox.init('.js-fancybox');

            // initialization of slick carousel
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

            // initialization of go to
            $.HSCore.components.HSGoTo.init('.js-go-to');

            // initialization of hamburgers
            $.HSCore.components.HSHamburgers.init('#hamburgerTrigger');

            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                beforeClose: function () {
                    $('#hamburgerTrigger').removeClass('is-active');
                },
                afterClose: function () {
                    $('#headerSidebarList .collapse.show').collapse('hide');
                }
            });

            $('#headerSidebarList [data-toggle="collapse"]').on('click', function (e) {
                e.preventDefault();

                var target = $(this).data('target');

                if ($(this).attr('aria-expanded') === "true") {
                    $(target).collapse('hide');
                } else {
                    $(target).collapse('show');
                }
            });

            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));

            // initialization of select picker
            $.HSCore.components.HSSelectPicker.init('.js-select');
        });

        @if(Session::has('success'))
            toastr.success("{{ Session::get('mgs') }}");
        @endif
        @if(Session::has('error'))
            toastr.error("{{ Session::get('mgs') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        const dropdown = document.querySelector('.searchDropdown');
        if (dropdown) {
          dropdown.addEventListener('change', () => {
            document.querySelector('#searchForm').submit();
          });
        }

        const dropdown1 = document.querySelector('.searchDropdown1');
        if (dropdown1) {
          dropdown1.addEventListener('change', () => {
            document.querySelector('#searchForm1').submit();
          });
        }

    </script>

    @yield('script')
</body>

</html>
