@extends('layouts.profile') @section('content')
<div class="px-3 py-4 bg-cha-primary w-full text-gray-100">
    <div class="flex items-center justify-center flex-col pt-8">
        <div class="w-24 h-24 relative mb-2">
            <img src=" {{ asset('img/placeholders/anonymous.jpeg') }}" alt="" class="border-2 border-gray-200 shadow-lg rounded-full h-24 w-24 object-cover" />
            <span class="bg-white absolute bottom-1 right-1 h-6 w-6 flex justify-center items-center rounded-full text-center">
                <i class="text-cha-primary text-lg mdi mdi-guy-fawkes-mask"></i>
            </span>
        </div>
        <div class="text my-2">
            <p class="font-light text-center">{{'@'.auth()->user()->username}}</p>
        </div>

        <div class="flex w-full md:w-1/2 my-5 items-center justify-between px-3">
            <div class="dms text-center">
                <a href="{{ route('user.messages.show') }}">
                    <p class="text-sm mx-2">
                        <i class="mdi mdi-email"></i>
                        {{ $messages_count }}
                    </p>
                    <p class="text-xs">Messages</p>
                </a>
            </div>
            <div class="threads text-center">
                <a href="{{ route('user.threads.show') }}">
                    <p class="text-sm mx-2">
                        <i class="mdi mdi-forum"></i>
                        <span class="user-threads-count">{{
                            $threads_count
                        }}</span>/10
                    </p>
                    <p class="text-xs">Threads</p>
                </a>
            </div>
            <div class="cta create-thread text-center">
                <a href="#" class="p-2 md:p-3 rounded-full bg-gray-100 text-xs text-cha-primary">
                    <i class="mdi mdi-plus"></i>
                    Create thread
                </a>
            </div>
        </div>
        <div title="Click to copy" class="rounded-full border-gray-100 border p-1 text-xs cursor-pointer hover:border-0 hover:bg-gray-100 hover:text-cha-primary hover:font-bold hover:px-2">
            <p class="ref-link" link="{{shareDmLink(auth()->user()->ref_link)}}">
                {{auth()->user()->ref_link}}
                <i class="mdi mdi-content-copy"></i>
            </p>
        </div>
        <div class="share-profile-btn my-2">
            <span class="rounded-full px-6 py-1 text-xs cursor-pointer">
                <i class="mdi mdi-share"></i>
                Share
            </span>
        </div>
    </div>

    <div class="modal micromodal-slide" id="create-thread-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header text-cha-primary">
                    <h2 class="modal__title" id="modal-1-title">
                        Create thread
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content p-3 py-1" id="modal-1-content">
                    <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi rerum laboriosam voluptas optio exercitationem illo est aspernatur recusandae eum porro. Perferendis debitis corrupti consequuntur molestiae, doloribus labore tenetur accusantium aspernatur.</p> -->
                    <form action="" id="create-thread-form">
                        <div class="form-group flex space-y-1 flex-col md:flex-row my-2 items-start md:items-center">
                            <label for="" class="md:pr-8 md:w-1/3">Name</label>
                            <input type="text" class="rounded-xl p-1 px-2 border-gray-400 border w-full" id="thread-name" required />
                        </div>
                        <div class="form-group flex space-y-1 flex-col md:flex-row my-2 items-start md:items-center">
                            <label for="" class="md:pr-8 md:w-1/3">Description</label>
                            <textarea name="" cols="30" rows="2" class="rounded-xl border-gray-400 border w-full" id="thread-desc"></textarea>
                        </div>
                        <!-- <div class="p-3 bg-cha-secondary flex rounded items-center justify-between my-3">
                            <div class="private w-5/6">
                                <p class="text-sm text-cha-primary font-bold">
                                    Turn on privacy
                                </p>
                                <p class="text-gray-500 text-xs">
                                    A secret passcode will be generated for you
                                    to share with people you want to access this
                                    private thread only.
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="private-check" />
                                <span class="slider round"></span>
                            </label>
                        </div> -->

                        <div class="flex justify-end">
                            <x-primary-button id="create-thread-btn">Create</x-primary-button>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>

    <div class="modal micromodal-slide" id="share-profile-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header text-cha-primary">
                    <h2 class="modal__title" id="modal-1-title">
                        Share your profile
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content p-3 py-1" id="modal-1-content">
                    <div class="my-8 flex space-x-4 items-center justify-center w-full md:w-3/4 mx-auto">
                        <!-- Sharingbutton Facebook -->
                        <a class="p-3 profile-share focus:outline-none text-2xl shadow-xl flex items-center justify-center rounded w-18 h-18 flex-col bg-blue-600 text-white" href="https://facebook.com/sharer/sharer.php?u={{(auth()->user()->ref_link)}}" target="_blank" rel="noopener" aria-label="Share on Facebook">
                            <i class="mdi mdi-facebook"></i>
                            <p class="text-white text-xs">Facebook</p>
                        </a>
                        <a class="p-3 profile-share focus:outline-none text-2xl shadow-xl flex items-center justify-center rounded w-18 h-18 flex-col bg-green-500 text-white" href="whatsapp://send?text={{shareDmLink(auth()->user()->ref_link)}}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                            <i class="mdi mdi-whatsapp"></i>
                            <p class="text-white text-xs">Whatsapp</p>
                        </a>
                        <a class="p-3 profile-share focus:outline-none text-2xl shadow-xl flex items-center justify-center rounded w-18 h-18 flex-col bg-blue-900 text-white" href="https://twitter.com/intent/tweet/?text={{shareDmLink(auth()->user()->ref_link)}}" target="_blank" rel="noopener" aria-label="Share on Twitter">
                            <i class="mdi mdi-twitter"></i>
                            <p class="text-white text-xs">Twitter</p>
                        </a>

                        <!-- Sharingbutton Twitter -->


                        <!-- Sharingbutton WhatsApp -->
                        <!-- <a class="whatsapp-share" href="whatsapp://send?text=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.%20http%3A%2F%2Fsharingbuttons.io" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                            
                        </a> -->

                        <!-- Sharingbutton Telegram -->
                        <!-- <a class="telegram-share" href="https://telegram.me/share/url?text=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.&amp;url=http%3A%2F%2Fsharingbuttons.io" target="_blank" rel="noopener" aria-label="Share on Telegram">
                            
                        </a> -->

                    </div>
                </main>
            </div>
        </div>
    </div>
    <div class="modal micromodal-slide" id="share-thread-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header text-cha-primary">
                    <h2 class="modal__title" id="modal-1-title">
                        Share your thread
                        <p class="text-xs thread-link-text"></p>
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content p-3 py-1" id="thread-share-content">
                    <div class="thread-share-container my-8 flex space-x-4 items-center justify-center w-full md:w-3/4 mx-auto">
                        <!-- Sharingbutton Facebook -->
                        <a class="p-3 thread-share-fb focus:outline-none text-2xl shadow-xl flex items-center justify-center rounded w-18 h-18 flex-col bg-blue-600 text-white" href="https://facebook.com/sharer/sharer.php?u=***link***" target="_blank" rel="noopener" aria-label="Share on Facebook">
                            <i class="mdi mdi-facebook"></i>
                            <p class="text-white text-xs">Facebook</p>
                        </a>
                        <a class="p-3 thread-share-wa focus:outline-none text-2xl shadow-xl flex items-center justify-center rounded w-18 h-18 flex-col bg-green-500 text-white" href="whatsapp://send?text=***link***" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                            <i class="mdi mdi-whatsapp"></i>
                            <p class="text-white text-xs">Whatsapp</p>
                        </a>
                        <a class="p-3 thread-share-tw focus:outline-none text-2xl shadow-xl flex items-center justify-center rounded w-18 h-18 flex-col bg-blue-900 text-white" href="https://twitter.com/intent/tweet/?text=***link***" target="_blank" rel="noopener" aria-label="Share on Twitter">
                            <i class="mdi mdi-twitter"></i>
                            <p class="text-white text-xs">Twitter</p>
                        </a>

                        <!-- Sharingbutton Twitter -->


                        <!-- Sharingbutton WhatsApp -->
                        <!-- <a class="whatsapp-share" href="whatsapp://send?text=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.%20http%3A%2F%2Fsharingbuttons.io" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                            
                        </a> -->

                        <!-- Sharingbutton Telegram -->
                        <!-- <a class="telegram-share" href="https://telegram.me/share/url?text=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.&amp;url=http%3A%2F%2Fsharingbuttons.io" target="_blank" rel="noopener" aria-label="Share on Telegram">
                            
                        </a> -->

                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
@yield('content-in')

@endsection @section('scripts')
<script>
    $('.ref-link').click(function() {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr('link')).select();
        document.execCommand("copy");
        $temp.remove();

        notyf.success({
            message: 'Link copied to clipboard',
            duration: 1500
        })
    })

    var old_content = $('.thread-share-container').clone()
    // MicroModal.show("create-thread-modal");
    $(".create-thread").click(function() {
        MicroModal.show("create-thread-modal");
    });
    // MicroModal.show("share-profile-modal");
    $(".share-profile-btn").click(function() {
        MicroModal.show("share-profile-modal");
    });
    $(".share-thread-btn").click(function() {
        $('.thread-link-text').text($(this).attr('data-thread-link'))
        $('.thread-share-fb').attr('href', "https://facebook.com/sharer/sharer.php?u="+$(this).attr('data-thread-link'))
        $('.thread-share-wa').attr('href',  "whatsapp://send?text="+$(this).attr('data-share-link'))
        $('.thread-share-tw').attr('href',  "https://twitter.com/intent/tweet/?text="+$(this).attr('data-share-link'))
        // clog(old_content)
        MicroModal.show("share-thread-modal", {
            onClose: function() {
                // clog(old_content)
                // $('#thread-share-content').html(old_content)
            }
        });
    });

    var create_thread_form = $("#create-thread-form");

    create_thread_form.submit(function(e) {
        e.preventDefault();
        btn_spinner = $(this).find("svg");
        thread_name = $(this).find("#thread-name").val();
        desc = $(this).find("#thread-desc").val();
        private = $(this).find("#private-check").is(":checked");

        btn_spinner.show();
        $.post("{{route('thread.create')}}", {
                name: thread_name,
                description: desc,
                visibility: private ? "private" : "public",
                _token: "{{csrf_token()}}",
            })
            .done(function(response) {
                clog(response);
                notyf.success("Thread created successfully!");
                $(".user-threads-count").text(response.threads_count);
                create_thread_form[0].reset();
                MicroModal.close("create-thread-modal");
                window.location = "{{route('user.threads.show')}}"
                btn_spinner.hide();
            })
            .fail(function(response, status, error) {
                btn_spinner.hide();
                if (response.status === 419) {
                    notyf.error({
                        message: "Page expired, reload and try again.",
                        duration: 3000,
                        dismissible: false,
                        position: {
                            y: "bottom",
                        },
                    });
                }
            });
    });

    var pwd_btn = $("#pwdBtn");

    var notyf = new Notyf({
        duration: 3000,
        position: {
            x: "right",
            y: "bottom",
        },
        types: [{
            type: "primary",
            background: "#ff8000",
            icon: {
                className: "material-icons",
                tagName: "i",
                text: "star",
            },
        }, ],
        dismissible: true,
    });

    pwd_btn.click(function() {
        notyf.open({
            type: "primary",
            message: "Send us <b>an email</b> to get support",
        });
        var err = 0;
        var spinner = $(this).children("svg");

        password = $("#password");
        c_password = $("#c_password");

        password.focus(function() {
            $(".password-error").text("Password cannot be empty").hide();
            password.removeClass("border-red-500");
        });
        c_password.focus(function() {
            $(".c_password-error").text("Password cannot be empty").hide();
            c_password.removeClass("border-red-500");
        });

        if (password.val() === "") {
            err++;
            $(".password-error").text("Password cannot be empty").show();
            password.addClass("border-red-500");
            password = $("#password");
        }
        if (password.val().length < 5) {
            err++;
            $(".password-error")
                .text("Password must be at least 5 characters long")
                .show();
            password.addClass("border-red-500");
            password = $("#password");
        }

        if (c_password.val() != password.val()) {
            err++;
            $(".c_password-error").text("Passwords do not match!").show();
            c_password.addClass("border-red-500");
            c_password = $("#c_password");
        }

        if (err === 0) {
            spinner.toggleClass("hidden");

            $.post("{{route('user.password.update')}}", {
                    password: password.val(),
                    _token: "{{csrf_token()}}",
                })
                .done(function(response) {
                    spinner.toggleClass("hidden");
                    popAlert("success");
                    clog(response);
                })
                .fail();
        }
    });
</script>
@stack('scripts')
@endsection