@extends('layouts.vue')

@section('content')

<section class="anon-msg">
    <div class="flex flex-col m-3">
        <div class="header bg-cha-primary p-3 rounded-t-2xl flex space-x-4 items-center">
            <div class="h-12 relative">
                <img src=" {{ asset('img/placeholders/anonymous.jpeg') }}" alt="" class="border-2 border-gray-200 shadow-lg rounded-full h-12 w-12 object-cover" />
                <span class="bg-white absolute bottom-0 right-0 h-5 w-5 flex justify-center items-center rounded-full text-center">
                    <i class="text-cha-primary mdi mdi-guy-fawkes-mask"></i>
                </span>
            </div>
            <div class="info text-xs">
                <p class="text-lg text-white">Anonymous message</p>
                <p class="text-purple-900 font-bold"> Recipient:
                    <span class="font-normal text-white ml-2">
                        {{ucfirst($user->username)}}
                    </span>
                </p>
                <p class="text-purple-900 font-bold"> Member since:
                    <span class="font-normal text-white ml-2">
                        {{$user->created_at->diffForHumans()}}
                    </span>
                </p>
            </div>
        </div>
        <div class="body bg-cha-secondary">
            <form action="" id="send-message-form">
                <div class="mt-3 bg-cha-secondary p-3 rounded-2xl">
                    <div class="flex">
                        <div class="w-1/6 px-2">
                            <img src="{{
                                            asset('img/placeholders/anonymous.jpeg')
                                        }}" class="rounded-full float-right w-8 h-8 md:w-12 md:h-12 object-cover" alt="" />
                        </div>
                        <div class="w-5/6 texting flex flex-col">
                            <div class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white">
                                <textarea name="" id="message" cols="30" rows="3" class="text-xs text-gray-600 border-0 resize-none rounded-xl w-full py-1 placeholder-gray-400" placeholder="Write something to {{$user->username}}" required></textarea>
                                <!-- <i class="mdi mdi-emoticon-happy-outline text-xl hidden text-gray-400"></i>
                            <i class="send-message cursor-pointer shadow mdi mdi-send text-xl text-cha-primary"></i> -->
                            </div>

                            <!-- <div class="styling px-4 flex items-center relative">
                            <div class="w-3/4">
                                <div class="w-8 cursor-pointer" id="palette-selector">
                                    <img src="{{
                                                        asset(
                                                            'img/icons/rainbow.svg'
                                                        )
                                                    }}" class="rounded-full w-8" alt="" />
                                    <div id="palette" class="hidden absolute z-10 bg-cha-secondarys bg-gray-50 shadow-lg left-10 top-3 p-1 md:p-2 grid grid-cols-8 md:gap-2 gap-1 rounded w-full sm:w-2/3 md:w-5/6">
                                        @foreach(['a', 'b', 'c'] as $c)
                                        <div class="gra-orange w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-orange"></div>
                                        <div class="gra-oxblood w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-oxblood"></div>
                                        <div class="gra-quepal w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-quepal"></div>
                                        <div class="gra-cherry w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-cherry"></div>
                                        <div class="gra-amin w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-amin"></div>
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
                        </div> -->
                        </div>
                    </div>
                    <div class="reply-container flex items-center justify-end space-x-2 px-3 w-full">
                        <p class="text-xs text-cha-primary">
                            Allow reply
                        </p>
                        <label class="switch">
                            <input type="checkbox" id="repliable-check" checked/>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="p-1 reply-tooltip float-right w-5/6 md:w-2/3 shadow-sm rounded flex bg-white space-x-2 items-center justify-between mt-2 relative">
                        <div class="arrow-up absolute right-6 -top-2"></div>
                        <span class="flex items-center justify-center text-cha-primary">
                            <i class="text-xs mdi mdi-bell"></i>
                        </span>

                        <p class="text-gray-500 text-xs" style="line-height: 11px; font-size:10px">
                            You need to enable notifications so that you can get replies from "<strong class="text-cha-primary">
                                {{ucfirst($user->username)}}</strong>".
                            Don't worry, we'll keep you anonymous, so they won't know it's you.
                        </p>
                    </div>
                </div>
        </div>
        <div class="footer flex justify-end p-3 bg-cha-secondary rounded-b-2xl">
            <button class="send-btn text-xs rounded-full text-white h-8 w-8 bg-cha-primary flex items-center justify-center">
                <svg class="spinner animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <!-- Send -->
                <i class="mdi mdi-send send-icon ml-1"></i>
            </button>
        </div>
        </form>

    </div>
</section>
@auth
<!-- <section class="create-feed">
    <div id="palette-preview-box" class="hidden rounded-xl bg-cha-secondary m-3 p-3">
        <div id="palette-preview" class=" w-3/4 mx-auto h-24 px-5 py-3 rounded-2xl gra-orange text-white" gradient-bg="gra-orange">
            <p class="preview-text text-xs text-gray-100">
                Type a message in the input box below to preview
            </p>
        </div>
    </div>

    <div class="m-3 bg-cha-secondary p-3 rounded-2xl">
        <div class="flex">
            <div class="w-1/6 px-2">
                <img src="{{
                                            asset('img/placeholders/anonymous.jpeg')
                                        }}" class="rounded-full float-right w-8 h-8 md:w-12 md:h-12 object-cover" alt="" />
            </div>
            <div class="w-5/6 texting flex flex-col pr-4">
                <div class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white">
                    <textarea name="" id="message" cols="30" rows="3" class="text-xs text-gray-600 border-0 resize-none rounded-xl w-full py-1 placeholder-gray-400" placeholder="Write something.."></textarea>
                    <i class="mdi mdi-emoticon-happy-outline text-xl hidden md:block text-gray-400"></i>
                    <i class="mdi mdi-send text-xl text-cha-primary"></i>
                </div>

                <div class="styling px-4 flex items-center relative">
                    <div class="w-3/4">
                        <div class="w-8 cursor-pointer" id="palette-selector">
                            <img src="{{
                                                        asset(
                                                            'img/icons/rainbow.svg'
                                                        )
                                                    }}" class="rounded-full w-8" alt="" />
                            <div id="palette" class="hidden absolute z-10 bg-cha-secondarys bg-gray-50 shadow-lg left-10 top-3 p-1 md:p-2 grid grid-cols-8 md:gap-2 gap-1 rounded w-full sm:w-2/3 md:w-5/6">
                                @foreach(['a', 'b', 'c'] as $c)
                                <div class="gra-orange w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-orange"></div>
                                <div class="gra-oxblood w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-oxblood"></div>
                                <div class="gra-quepal w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-quepal"></div>
                                <div class="gra-cherry w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-cherry"></div>
                                <div class="gra-amin w-6 h-6 md:w-8 md:h-8 rounded palette-color" gradient-bg="gra-amin"></div>
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
</section> -->
@endauth

@endsection

@section('scripts')

<script>
    $("#private-check").change(function() {
        $('.reply-tooltip').toggleClass('hidden')
        if (device_token === null) {
            messaging.requestPermission().then(function() {
                console.log("Notification permission granted.");
                return messaging.getToken();
            }).then(function(token) {
                device_token = token
                console.log(device_token)
            })["catch"](function(err) {
                console.log("Unable to get permission to notify.", err);
            });
        } else {
            $('.reply-tooltip').addClass('hidden')

        }
    })

    $('#send-message-form').submit(function(e) {
        $('.send-icon, .spinner').toggleClass('hidden')
        e.preventDefault()
        message = $(this).find('textarea').val()
        repliable = $(this).find("#repliable-check").is(":checked");
        // if (auth_status == 0) {
        //     MicroModal.show("message-register-modal");
        // }
        $.post("{{route('users.messages.send', $user->username)}}", {
            message: message,
            repliable: repliable,
            replier_token: device_token,
            username: "{{$user->username}}",
            _token: "{{csrf_token()}}"
        }).done(function(response) {
            clog(device_token)
            clog(response)
            $('.send-icon, .spinner').toggleClass('hidden')
            MicroModal.show("message-sent-modal", {
                onClose: function() {
                    window.location = auth_status == 0 ? "{{route('register')}}" : "{{route('user.messages.show')}}"
                }
            });
        })
    })
</script>
@endsection