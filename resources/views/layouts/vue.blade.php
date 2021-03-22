<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/gradients.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <base href="https://chatonym.dv">
    <title>Chatonym</title>
</head>

<body class="font-normal">
    <div class="flex">
        <!-- Sidebar -->
        <div class="hidden md:block sidebar w-1/4 fixed z-20 bg-cha-primary h-screen text-white top-0">
            @include('partials.sidebar')
        </div>
        <div class="hidden md:block rightbar ml-3/4p w-1/4 fixed z-20 bg-cha-primary h-screen text-white top-0 px-8">
            @include('partials.rightbar')
        </div>
        <!-- Main -->
        <div class="md:ml-1/4p w-full md:w-1/2 p-0 m-0 top-0">
            <div class="fixed w-full md:w-1/2 m-0 p-0 bg-cha-primary md:bg-white z-10 top-0">
                @include('partials.topbar')
            </div>

            <div class="fixed mobile-menu top-0 duration-300 -ml-64 md:hidden left-0 text-white z-30 w-64 bg-cha-primary h-screen">
                <div class="relative">
                    <div class="closeNavBtn absolute top-0 right-2 cursor-pointer">
                        <i class="mdi mdi-close font-bold text-2xl text-white"></i>
                    </div>
                    @include('partials.sidebar')
                </div>
            </div>

            <div class="fixed transition-opacity mobile-menu-overlay duration-300 top-0 hidden md:hidden left-0 z-20 w-full bg-gray-900 h-screen">

            </div>

            <div class="content mt-16">
                @yield('content')


                <div class="modal micromodal-slide" id="login-loader-modal" aria-hidden="true">
                    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
                        <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                            <header class="modal__header text-cha-primary">
                                <!-- <h2 class="modal__title" id="modal-1-title">
                    Login to Chatonym
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button> -->
                            </header>
                            <main class="modal__content p-3" id="modal-1-content">
                                <div class="spinner space-y-1 text-4xl p-5 flex items-center justify-center flex-col">
                                    <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-cha-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <p class="text-xs text-cha-primary opacity-80">
                                        Validating account
                                    </p>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function clog(log) {
            console.log(log)
        }

        var CLOUDINARY_FOLDER_ID = "{{cloudinary_folder_id()}}"
        var CLOUDINARY_API_KEY = "{{cloudinary_api_key()}}"
        var CLOUDINARY_UPLOAD_PRESET = "{{cloudinary_upload_preset()}}"
        var CLOUDINARY_UPLOAD_URL = "{{cloudinary_upload_url()}}"
        var auth = "{{auth()->check()}}" ? true : false;
        var notyf = new Notyf()
        var doLogin = function() {
            MicroModal.show("login-loader-modal");
            window.location = "{{route('login')}}"
        }

        var notif_icon = $("#notif-icon");
        var notif_dropdown = $("#notif-dropdown");

        $('.openNavBtn').click(function() {
            $('.mobile-menu').toggleClass('-ml-64')
            $('.mobile-menu-overlay').toggleClass('hidden').css('opacity', '0.6')
        })

        $('.closeNavBtn,.mobile-menu-overlay').click(function() {
            $('.mobile-menu').toggleClass('-ml-64')
            $('.mobile-menu-overlay').toggleClass('hidden').css('opacity', '0')
        })



        notif_icon.mouseup(function(e) {
            console.log(notif_dropdown);
            notif_dropdown.removeClass("hidden");
        });

        $(document).mouseup(function(e) {
            if (
                !notif_icon.is(e.target) &&
                notif_icon.has(e.target).length === 0 &&
                !notif_dropdown.hasClass("hidden")
            ) {
                notif_dropdown.addClass("hidden");
            }
        });

        var app_user = @json(auth()->user())

        $('.ref-link').click(function() {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).text()).select();
        document.execCommand("copy");
        $temp.remove();

        notyf.success({
            message: 'Link copied to clipboard',
            duration: 1500
        })
    })
    
    </script>

    <!-- <script src="{{asset('firebase-messaging-sw.js')}}"></script> -->

    @yield('scripts')



</body>

</html>