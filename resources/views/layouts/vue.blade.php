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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA==" crossorigin="anonymous" />
    <script>
        if (location.protocol !== 'https:' && location.hostname != 'localhost') {
            location.replace(`https:${location.href.substring(location.protocol.length)}`);
        }
    </script>
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
            <div class="fixed w-full md:w-1/2 m-0 p-0 bg-cha-primary md:bg-white z-50 top-0">
                @php
                $togglenav = "text-white"
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

            <div class="fixed transition-opacity mobile-menu-overlay duration-300 top-0 hidden md:hidden left-0 z-20 w-full bg-gray-900 h-screen">

            </div>

            <div class="content mt-16 relative">
                @yield('content')



                <div class="modal micromodal-slide" id="login-loader-modal" aria-hidden="true">
                    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
                        <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                            <header class="modal__header text-cha-primary">
                                <p class="text-xs text-cha-primary opacity-80">
                                    Validating account
                                </p>
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

                <div class="modal micromodal-slide" id="message-sent-modal" aria-hidden="true">
                    <div class="modal__overlay top-modal pt-24" tabindex="-1" data-micromodal-close>
                        <div class="modal__container text-cha-primary bg-white p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                            <header class="modal__header">
                            </header>
                            <main class="modal__content p-3" id="modal-1-content">
                                <p class="text-center text-gray-600 font-bold text-3xl">
                                    Yay! Your message has been delivered.
                                </p>
                                @guest
                                <p class="text-sm text-center text-cha-primary my-8">
                                    Now create your own account and start receiving anonymous messages.
                                </p>
                                @endguest
                                <div class="flex justify-center items-center p-3">
                                    <a href="{{auth()->check() ? route('user.messages.show'): route('register')}}" class="bg-cha-primary text-white uppercase rounded-full px-6 py-2">CONTINUE</a>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
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

        // $('.mock-notif').click(() => {
        //     setChatNotification()
        // })

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

        var clog = (log) => {
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

        var doReg = function() {
            MicroModal.show("login-loader-modal");
            window.location = "{{route('register')}}/?newReg=true"
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

        var app_user = @json($auth_user)

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

    <!-- start webpushr code -->
    <!-- start webpushr code -->
    <script>
        // (function(w, d, s, id) {
        //     if (typeof(w.webpushr) !== 'undefined') return;
        //     w.webpushr = w.webpushr || function() {
        //         (w.webpushr.q = w.webpushr.q || []).push(arguments)
        //     };
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     js = d.createElement(s);
        //     js.id = id;
        //     js.async = 1;
        //     js.src = "https://cdn.webpushr.com/app.min.js";
        //     fjs.parentNode.appendChild(js);
        // }(window, document, 'script', 'webpushr-jssdk'));
        // webpushr('setup', {
        //     'key': "{{config('webpushr.client_key')}}"
        // });
    </script><!-- end webpushr code -->
    <script>
        //    Our JS snippet goes here
        webpushr('fetch_id', function(sid) {
            // device_token = sid
            localStorage.setItem('webpushr_token', sid)
            if (auth_status == 1) {
                // setUserToken(sid)
            }
        });
    </script>
    <!-- end webpushr code -->

</body>

</html>