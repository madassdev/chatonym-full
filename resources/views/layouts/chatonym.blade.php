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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

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
            <div class="fixed w-full md:w-1/2 m-0 p-0 bg-white z-10 top-0">
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

            <div class="fixed transition transition-opacity mobile-menu-overlay duration-300 top-0 hidden md:hidden left-0 z-20 w-full bg-gray-900 h-screen">

            </div>

            <div class="content mt-16">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        function clog(log) {
            console.log(log)
        }


        var notif_icon = $("#notif-icon");
        var notif_dropdown = $("#notif-dropdown");

        $('.openNavBtn').click(function() {
            $('.mobile-menu').toggleClass('-ml-64')
            $('.mobile-menu-overlay').toggleClass('hidden').css('opacity', '0.6')
        })

        $('.closeNavBtn').click(function() {
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
    </script>

    <!-- <script src="{{asset('firebase-messaging-sw.js')}}"></script> -->

    @yield('scripts')



</body>

</html>