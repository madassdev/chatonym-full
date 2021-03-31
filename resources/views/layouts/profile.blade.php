<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="{{ asset('css/gradients.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script>
        if (location.protocol !== 'https:' && location.hostname != 'localhost') {
            location.replace(`https:${location.href.substring(location.protocol.length)}`);
        }
    </script>
    <title>Chatonym</title>
</head>

<body class="font-normal bg-gray-200">

    <div class="flex">
        <!-- Sidebar -->
        <div class="hidden md:block sidebar w-1/4 fixed z-20 bg-cha-primary h-screen text-white top-0">
            @include('partials.sidebar')
        </div>
        <!-- Main -->
        <div class="md:ml-1/4p w-full md:w-3/4 p-0 m-0 top-0">
            <div class="fixed w-full md:w-3/4 m-0 p-0 bg-white z-10 top-0">
                @php
                $togglenav = "text-cha-primary"
                @endphp
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

            <div class="content mt-12 px-">
                @yield('content')
            </div>
        </div>
    </div>
    @php
    $auth_user = auth()->user()
    @endphp

    <script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-messaging.js"></script>
    <script>
        var auth_status = "{{auth()->check() ? 1 : 0}}"
        var device_token = null;
        var app_url = "{{env('APP_URL')}}"

        function setUserToken(token) {
            $.post(app_url + "/users/token", {
                token: token
            }).done((res) => {
                clog(res)
            })
        }

        function setChatNotification(plod) {

            const notif_count = $('.notif-count')
            notif_count.removeClass('hidden')
            notif_count.text(parseInt(notif_count.text()) + 1)
            const no_new = $('.no-new');
            const new_notif = no_new.clone().removeClass('no-new hidden')
            new_notif.find('.notif-text').text("New message: " + '"' + plod.text.substring(0, 10) + '..."')
            new_notif.find('.notif-link').attr('href', plod.link)
            $('.notifications-list').prepend(new_notif)
            no_new.addClass('hidden')
            clog('lets begin')

        }
        var scrollToBottom = (duration = 0) => {
            $("html, body").animate({
                scrollTop: $(document).height()
            }, duration);
        }

        function setNewChat(m, context = "sender") {
            scrollToBottom();
            if (context == "sender") {
                var new_chat = $($('.sender-chat')[0]).clone();
            } else {
                var new_chat = $($('.replier-chat')[0]).clone();
            }
            new_chat.find('.chat-message').html(m.replace(/\n/g, '<br />'))
            // new_chat.find('.chat-time').text(moment().format(Date.now()))
            $('.chats-container').append(new_chat)
        }
        // var firebaseConfig = {
        //     apiKey: "AIzaSyCzzLQxYlhGrME1pB5Ukie2eZysQ014BpU",
        //     authDomain: "autifycloud-bba94.firebaseapp.com",
        //     databaseURL: "https://autifycloud-bba94.firebaseio.com",
        //     projectId: "autifycloud-bba94",
        //     storageBucket: "autifycloud-bba94.appspot.com",
        //     messagingSenderId: "338960353893",
        //     appId: "1:338960353893:web:e082eb524607ac7839d48c",
        //     measurementId: "G-ECGLNDB5YY"
        // };
        var firebaseConfig = {
            apiKey: "AIzaSyBYtoMYgqcD0xJA67rfD2ZI4jV-DGhBx84",
            authDomain: "chatonym-full.firebaseapp.com",
            projectId: "chatonym-full",
            storageBucket: "chatonym-full.appspot.com",
            messagingSenderId: "738168635297",
            appId: "1:738168635297:web:3e033097bd626e9d4bd5e0",
            measurementId: "G-82GPCTJ8SG"
        };

        firebase.initializeApp(firebaseConfig);
        var messaging = firebase.messaging();
        // messaging.usePublicVapidKey('BPV4J_fRC_Evc8tCwwsiIXQgSgOMen3tDY94rtZL9IIobq9xWHvNk4DO22qDNSeF5WHhRRC8L7NqpHbmBXRVTiA');
        messaging.usePublicVapidKey('BJNTgYZ3Xx6ZiT1P7wMQo9G1ylWcDhJAHzt7eHy_XMK94TtNZ02SqVbqTq6wfZGB0_pkVrXrsO9uRCf6w1Zun9g');
        messaging.requestPermission().then(function() {
            console.log("Notification permission granted.");
            return messaging.getToken();
        }).then(function(token) {
            device_token = token
            console.log(token)
            if (auth_status == 1) {
                setUserToken(token)
            }
            //alert(token);
        })["catch"](function(err) {
            console.log("Unable to get permission to notify.", err);
        });

        messaging.onMessage(function(payload) {
            console.log('onMessage: ', payload);
            const notif = {
                text: payload.data.title,
                link: payload.data.click_action
            }
            setChatNotification(notif)

            @if(@$chat_page)
            setNewChat(payload.data.body, "replier")
            @endif
        });

        function clog(log) {
            console.log(log)
        }

        $('.openNavBtn').click(function() {
            $('.mobile-menu').toggleClass('-ml-64')
            $('.mobile-menu-overlay').toggleClass('hidden').css('opacity', '0.6')
        })

        $('.closeNavBtn').click(function() {
            $('.mobile-menu').toggleClass('-ml-64')
            $('.mobile-menu-overlay').toggleClass('hidden').css('opacity', '0')
        })

        var notif_icon = $("#notif-icon");
        var notif_dropdown = $("#notif-dropdown");

        notif_icon.mouseup(function(e) {
            console.log(notif_dropdown);
            notif_dropdown.removeClass("hidden");
            $('.notif-count').addClass("hidden")
        });

        $(document).mouseup(function(e) {
            if (
                !notif_icon.is(e.target) &&
                notif_icon.has(e.target).length === 0 &&
                !notif_dropdown.hasClass("hidden")
            ) {
                notif_dropdown.addClass("hidden");
                $('.notif-count').text('0')
            }
        });

    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script> -->

    <!-- <script src="{{asset('firebase-messaging-sw.js')}}"></script> -->

    @yield('scripts')



</body>

</html>