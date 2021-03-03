@extends('layouts.chatonym')

@section('content')

<div class="m-3 bg-cha-secondary p-3 rounded-2xl">
    <div class="row">
        <div class="w-1/6 px-2">
            <img src="{{
                                        asset('img/placeholders/profile.jpg')
                                    }}" class="rounded-full float-right w-12 h-12 object-cover" alt="" />
        </div>
        <div class="w-5/6 texting flex flex-col pr-4">
            <div class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white">
                <textarea name="" id="message" cols="30" rows="1" class="border-0 resize-none rounded-full w-full py-1 placeholder-gray-300" placeholder="Write something.."></textarea>
                <i class="mdi mdi-emoticon-happy-outline text-xl text-gray-400 cursor-pointer"></i>
                <i class="mdi mdi-send text-xl text-cha-primary send-btn cursor-pointer"></i>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="replyable">
                <label class="form-check-label" for="flexSwitchCheckDefault">Enable reply</label>
            </div>
            <div class="styling px-4 flex items-center relative">
                <div class="w-3/4">
                    <div class="w-8 cursor-pointer" id="palette-selector">
                        <img src="{{
                                                    asset(
                                                        'img/icons/rainbow.svg'
                                                    )
                                                }}" class="rounded-full w-8" alt="" />
                        <div id="palette" class="hidden absolute z-10 bg-cha-secondarys bg-gray-50 shadow-lg left-10 top-3 p-2 grid grid-cols-8 gap-2 rounded w-5/6">
                            @foreach(['a', 'b', 'c'] as $c)
                            <div class="bg-red-200 w-8 h-8 rounded palette-color"></div>
                            <div class="bg-blue-200 w-8 h-8 rounded palette-color"></div>
                            <div class="bg-green-200 w-8 h-8 rounded palette-color"></div>
                            <div class="bg-pink-200 w-8 h-8 rounded palette-color"></div>
                            <div class="bg-yellow-200 w-8 h-8 rounded palette-color"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="icons flex items-center w-1/2 justify-end space-x-4">
                    <i class="mdi mdi-plus text-cha-primary text-xl"></i>
                    <i class="mdi mdi-camera-image text-cha-primary text-xl"></i>
                    <i class="mdi mdi-video-plus text-cha-primary text-xl"></i>
                    <img src="{{
                                                asset('img/icons/GIF.svg')
                                            }}" class="w-5" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-messaging.js"></script>
<script>
    var auth_status = "{{auth()->check() ? 1 : 0}}"
    var token = '';
    var message = $('textarea#message').val();

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
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);


    if (auth_status == 1) {

        var messaging = firebase.messaging();
        messaging.usePublicVapidKey('BJNTgYZ3Xx6ZiT1P7wMQo9G1ylWcDhJAHzt7eHy_XMK94TtNZ02SqVbqTq6wfZGB0_pkVrXrsO9uRCf6w1Zun9g');
        messaging.requestPermission().then(function() {
            console.log("Notification permission granted.");
            return messaging.getToken();
        }).then(function(token) {
            console.log(token);
            $.post("{{route('users.tokens.create')}}", {
                token: token,
                _token: "{{csrf_token()}}"
            }).done(function(data) {
                console.log(data)
            })
            //alert(token);
        })["catch"](function(err) {
            console.log("Unable to get permission to notify.", err);
        });

        messaging.onMessage(function(payload) {
            console.log('onMessage from msssg is: ', payload);
        });

    }

    $('.send-btn').click(function() {
        message = $('textarea#message').val();
        replyable = $('#replyable').is(":checked");

        clog(message)
        clog(replyable)


        $.post("{{route('users.messages.send', $user)}}", {
            message: message,
            _token: "{{csrf_token()}}"
        }).done(function(data) {
            console.log(data)
        })

    })
</script>
@endsection