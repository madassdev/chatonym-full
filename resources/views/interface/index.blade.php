@extends('layouts.chatonym')

@section('content')
<section class="create-feed duration-300">
    <div id="palette-preview-box" class="hidden rounded-xl bg-cha-secondary m-3 mb-0 p-3">
        <div id="palette-preview" class="relative w-3/4 mx-auto h-24 px-5 py-3 rounded-2xl gra-orange text-white" gradient-bg="gra-orange">
            <p class="preview-text text-xs text-gray-100">
                Type a message in the input box below to preview
            </p>
            <i class="palette-close mdi mdi-close absolute top-0 right-2 cursor-pointer"></i>
        </div>
    </div>

    <div class="m-3 mb-0 bg-cha-secondary p-3 rounded-2xl">
        <div class="flex">
            <div class="w-1/6 px-2">
                <img src="{{
                                            asset('img/placeholders/profile.jpg')
                                        }}" class="rounded-full float-right w-8 h-8 md:w-12 md:h-12 object-cover" alt="" />
            </div>
            <div class="w-5/6 texting flex flex-col pr-4">
                <div class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white">
                    <textarea name="" id="feed-message" cols="30" rows="3" class="text-xs text-gray-600 border-0 resize-none rounded-xl w-full py-1 placeholder-gray-400" placeholder="Write something.."></textarea>
                    <i class="mdi mdi-emoticon-happy-outline text-xl hidden  text-gray-400"></i>
                    <i class="mdi mdi-send text-xl text-cha-primary cursor-pointer"></i>
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
                        <!-- <i class="mdi mdi-plus text-cha-primary text-xl"></i> -->

                        <div id="imgBtn" class="flex items-center justify-center top-2 right-2 h-8 w-8 cursor-pointer rounded-full">
                            <input id="imageInput" type="file" class="h-0 w-0" accept="image/*" />
                            <i class="mdi mdi-camera-image text-cha-primary text-xl cursor-pointer media-upload image"></i>
                        </div>
                        <!-- <i class="mdi mdi-video-plus text-cha-primary text-xl cursor-pointer media-upload video"></i> -->
                        <!-- <img src="{{
                                                    asset('img/icons/GIF.svg')
                                                }}" class="w-5 cursor-pointer" alt="" /> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="feeds-container duration-300">
    <x-feed-card :has_comments="1" />

    <div class="w-full md:w-1/2 reply-chat fixed z-20 text-white bottom-0 hidden">
        <div class="w-full mx-auto shadow-xl rounded-full flex items-center mb-3 px-4 md:space-x-1 space-x-2">
            <div class="textarea flex space-x-4 items-center pr-3 w-11/12 rounded-full bg-white">
                <textarea name="" id="reply-message" cols="30" class="px-4 py-1 text-xs text-gray-600 border-0 resize-none rounded-full w-full placeholder-gray-400" placeholder="Write something.."></textarea>
                <i class="mdi mdi-emoticon-happy-outline text-xl hidden  text-gray-400"></i>
                <i class="mdi mdi-send text-xl text-cha-primary cursor-pointer reply-send"></i>
            </div>
            <div class="w-1/12 items-center flex justify-start">
                <span class="rounded-full p-1 flex items-center justify-center bg-cha-primary">
                    <i class="mdi mdi-close text-sm cursor-pointer reply-close"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="feeds-spinner space-y-1 p-5 flex items-center justify-center flex-col">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-cha-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="text-xs text-cha-primary opacity-80">

            Loading feeds
        </p>
    </div>
    <div class="feeds">

    </div>
</section>

<div class="modal micromodal-slide" id="feed-open-modal" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header text-cha-primary">
                <h2 class="modal__title" id="modal-1-title">

                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content p-3" id="modal-1-content">
                <img src="{{asset('img/placeholders/smileys.jpg')}}" class="feed-modal-image rounded-xl" alt="" srcset="">
            </main>
        </div>
    </div>
</div>

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

<div class="modal micromodal-slide" id="media-upload-modal" aria-hidden="true">
    <div class="modal__overlay md:pb-64" tabindex="-1" data-micromodal-close>
        <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header text-cha-primary">
                <h2 class="modal__title" id="modal-1-title">
                    Upload media
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content p-3" id="modal-1-content">
                <div class="w-full texting space-y-8 flex flex-col ">
                    <div class="flex items-center justify-center h-36 w-2/3 mx-auto relative">
                        <img id="media-preview" class="h-32 w-full rounded-xl object-cover" />
                        <span data-micromodal-close class="media-modal-close cursor-pointer rounded-full -top-1 -right-1 shadow h-4 w-4 absolute bg-gray-800 text-white flex items-center justify-center">
                            <i class="mdi mdi-close text-xs-10"></i>
                        </span>
                        <div class="upload-spinner-overlay flex items-center justify-center bg-black opacity-0 absolute w-full h-32 rounded-xl">

                        </div>
                        <div class="upload-spinner flex items-center justify-center absolute w-full h-32 rounded-xl hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-1/6 px-2">
                            <img src="{{
                                            asset('img/placeholders/profile.jpg')
                                        }}" class="rounded-full float-right w-4 h-4 md:w-8 md:h-8 object-cover" alt="" />
                        </div>
                        <div class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white w-5/6">
                            <textarea name="" id="media-message" cols="30" rows="3" class="text-xs text-gray-600 border-0 resize-none rounded-xl w-full py-1 placeholder-gray-400" placeholder="Write something.."></textarea>
                            <i class="mdi mdi-emoticon-happy-outline text-xl hidden  text-gray-400"></i>
                            <i class="mdi mdi-send text-xl text-cha-primary media-send cursor-pointer"></i>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var CLOUDINARY_FOLDER_ID = "{{cloudinary_folder_id()}}"
    var CLOUDINARY_API_KEY = "{{cloudinary_api_key()}}"
    var CLOUDINARY_UPLOAD_PRESET = "{{cloudinary_upload_preset()}}"
    var CLOUDINARY_UPLOAD_URL = "{{cloudinary_upload_url()}}"
    var auth = "{{auth()->check()}}" ? true : false;
    var shouldFetchFeeds = true;
    var message = $("#message")
    var palette = $("#palette");
    var palette_close = $(".palette-close");
    var palette_preview = $("#palette-preview");
    var palette_preview_box = $("#palette-preview-box");
    var modal = $("#modal");
    var palette_color = $(".palette-color");
    var palette_selector = $("#palette-selector");
    var feeds = []
    var feeds_url = "{{route('feed.fetch')}}";
    var feeds_spinner = $('.feeds-spinner')
    var feed = $('#feed-placeholder');
    var feeds_container = $('.feeds');
    var feed_reply_input = $('.reply-chat')
    var reply_send_btn = feed_reply_input.find('.reply-send')
    var reply_close_btn = feed_reply_input.find('.reply-close')
    var media_upload = $('.media-upload')
    var media_message = $('#media-message')
    var media_send = $('.media-send')
    var image = {}
    var new_media_feed = {}

    media_upload.click(function(e) {
        e.stopPropagation();
        // console.log('aaa')
        $("#imageInput")[0].click();
    });

    $('.media-modal-close').click(function() {
        MicroModal.close("media-upload-modal")
    })
    media_send.click(async function() {
        var fd = new FormData();
        var image_url = null
        fd.append('file', image);
        image.uniqid = Date.now()
        fd.append('api_key', CLOUDINARY_API_KEY);
        fd.append('folder', CLOUDINARY_FOLDER_ID + "/feeds");
        fd.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);
        $('.upload-spinner-overlay').toggleClass('opacity-0').toggleClass('opacity-50')
        $('.upload-spinner').toggleClass('hidden')
        await $.ajax({
            url: CLOUDINARY_UPLOAD_URL,
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response != 0) {
                    image_url = [{
                        public_id: response.secure_url,
                        url: response.secure_url
                    }]
                } else {
                    alert('Something went wrong');
                }
            },
        });
        if (media_message.val() !== "") {
            clog(media_message.val());
        }

        await $.post("{{url()->to('/feeds')}}", {
            message: media_message.val(),
            image_url: image_url
        }).done(function(response) {
            new_media_feed = response.data
        }).fail(function(response) {
            clog(response)
        })
        generateFeedUi(new_media_feed, prepend = true)
        $('.upload-spinner-overlay').toggleClass('opacity-0').toggleClass('opacity-50')
        $('.upload-spinner').toggleClass('hidden')

        MicroModal.close("media-upload-modal")

    })

    $("#imageInput").change(function(e) {

        MicroModal.show("media-upload-modal", {
            onShow: modal => console.info(`${modal.id} is shown`), // [1]
            onClose: function(modal) {
                media_message.val('')
                $("#imageInput").val('')
            },
        });
        preview = $("#media-preview");
        image = event.target.files[0];
        preview.attr("src", URL.createObjectURL(image));
        preview.onload = function() {
            URL.revokeObjectURL(preview.src);
        };
        // MicroModal.show("media-upload-modal")
        media_message.val($('#feed-message').val())
        media_message.focus()
    });



    reply_close_btn.click(function() {
        feed_reply_input.find('#reply-message').val('')
        feed_reply_input.hide()
    })

    reply_send_btn.click(function() {
        feed_id = ($(this).parents('.reply-chat').attr('reply-feed-id'))
        feed_attr = `[feed-id=${feed_id}]`
        feed = feeds_container.find(feed_attr);
        reply_message = feed_reply_input.find('#reply-message').val()
        if (reply_message !== "") {
            showReplies(feed, [{
                message: reply_message,
                media_type: "text",
                created_at: Date.now()
            }], true)

            $.post("{{url()->to('/feeds')}}" + "/" + feed_id, {
                message: reply_message,
            }).done(function(response) {
                clog(response)
            }).fail(function(response) {
                clog(response)
            })

            feed_reply_input.find('#reply-message').val('')
            feed_reply_input.hide()
        }


    })

    function doLogin() {
        MicroModal.show("login-loader-modal");
        window.location = "{{route('login')}}"
    }


    function replyToFeed(replying_feed) {
        // application_card = $(this).parents("[type=application-card]")
        if (!auth) {
            doLogin();
            return
        }

        clog(replying_feed.parents("#feed-placeholder").attr('feed-id'))
        feed_reply_input.attr('reply-feed-id', replying_feed.parents("#feed-placeholder").attr('feed-id'))
        feed_reply_input.show()
        feed_reply_input.find('#reply-message').focus()
    }

    $('.create-feed').click(function() {
        if (!auth) {
            doLogin();
            return
        }
    })


    function generateFeedUi(data, prepend = false) {
        gradients = ["gra-orange text-white", 'gra-oxblood text-white', 'gra-quepal text-white', 'gra-cherry text-white', 'gra-amin text-white', 'gra-veryblue text-white']
        gra_bg = Math.floor(Math.random() * 8);
        img = false
        message = data.message
        type = data.media_type
        // if (type == "text-and-image") {
        images = data.image_url
        if (images !== null && images.length) {
            img = true;
        }
        // }
        var new_feed = feed.clone()
        grad = gradients[gra_bg]
        new_feed.attr('feed-id', data.id)
        new_feed.attr('replies-count', data.replies.length)
        // new_feed.find('.feed-body').addClass(grad + ' py-3 rounded-2xl')
        new_feed.find('.feed-message').html(message)
        new_feed.find('.feed-comments-link').attr('href', "{{config('app.url').'/feeds/'}}" + data.id)
        // prepend ? feeds_container.append(new_feed) : feeds_container.append(new_feed)
        prepend ? feeds_container.prepend(new_feed) : feeds_container.append(new_feed)
        new_feed.find('.image').addClass('hidden')
        if (img) {
            new_feed.find('.image').removeClass('hidden')
            new_feed.find('.feed-img').attr('src', images[0].url)
            new_feed.find('.feed-img').bind('click', function() {
                modal_image = $(this)

                $('#feed-open-modal').find('.feed-modal-image').attr('src', modal_image.attr('src'))
                MicroModal.show("feed-open-modal");

            })
        }

        // REACTIONS UI
        new_feed.find('.add-reaction').bind('mouseup', function() {
            $('.current').find('.reactions-container').addClass('hidden')
            reactionManager($(this))
        })

        // REPLY UI

        new_feed.attr('has-initial-replies', data.replies.length > 0)
        showReplies(new_feed, data.replies)

        new_feed.show()

    }

    function reactionManager(frs) {
        frs.parent('.reactions').addClass('current').find('.reactions-container').removeClass('hidden')
        clog(frs.parent('.reactions'))
    }

    function makeReply(r) {
        if (r) {
            reply_template = replies.find('.reply-template')
            new_reply = reply_template.clone()
            new_reply.removeClass('reply-template').removeClass('hidden').addClass('reply')
            new_reply.find('.reply-text').html(r.message !== '' ? r.message : r.media_type)
            new_reply.find('.reply-date').text(new Date(r.created_at).toDateString())

            return new_reply
        }

    }

    function showReplies(f, data, new_reply = false) {

        replies = f.find('.replies-container')
        f.find('.feed-comments-link').bind('click', function() {
            replyToFeed($(this))
        })
        if (new_reply) {
            f.attr('replies-count', parseInt(f.attr('replies-count')) + 1)
            f.find('.replies-icon-count').text(f.attr('replies-count'))
            clog('prepending new comment')
            replies.prepend(makeReply(
                data[0]
            ))

            f.find('.replies-count').text("Replies").show()
            f.find('.see-more').show()
            f.find('.replies-count').show()
            replies.removeClass('hidden')
        } else {
            f.find('.replies-icon-count').text(data.length > 0 ? data.length : '')
            if (data.length > 0) {
                f.find('.replies-count').text("Replies").show()
                f.find('.see-more').show()
                f.find('.replies-count').show()
                data.slice(0, 2).map(r => {
                    replies.removeClass('hidden')
                    replies.append(makeReply(r))
                })
            }
        }

        // f.find('.replies-count').hide()
        // replies.addClass('hidden')
    }


    async function showFeeds() {
        feeds_container.append(feeds_spinner)
        feeds_spinner.addClass('my-16')
        feeds_spinner.show()
        if (feeds_url) {
            shouldFetchFeeds = false
            try {
                await $.get(feeds_url).done(function(data, status) {
                    console.log(data)
                    feeds = data.data.feeds.data
                    feeds_url = data.data.feeds.next_page_url + "&client_token=anonymous-api-token"
                }).fail(function(response) {
                    console.log(response.responseJSON)
                })

                shouldFetchFeeds = true
                if (feeds.length > 0) {
                    feeds.map(feed => {
                        $(generateFeedUi(feed))
                    })
                    feeds_spinner.hide()
                }

            } catch (e) {
                clog(e)
                feeds_spinner.html("<p class='bg-red-200 rounded p-3 text-xs text-red-500'> <i class='mdi mdi-alert-remove mr-3'></i>Something went wrong, please reload page</p>")
                feeds_spinner.show()
            }


        } else {
            feeds_spinner.removeClass('mb-64')
            feeds_spinner.html("<p class='text-xs text-gray-600'>No more feeds</p>")
            feeds_spinner.show()
        }


    }

    showFeeds()

    $(document.body).on('touchmove', onScroll);
    $(window).on('scroll', onScroll);

    function onScroll() {
        if (($(window).scrollTop() + window.innerHeight >= document.body.scrollHeight && shouldFetchFeeds)) {
            showFeeds()
        }
    }

    message.keyup(function(e) {
        var text = $(this).val();
        palette_preview.children(".preview-text").text(text)
    })

    function paintPalettePreview(color) {
        previous_color = palette_preview.attr('gradient-bg')
        palette_preview.removeClass(previous_color);
        palette_preview.addClass(color)
        palette_preview.attr('gradient-bg', color)
    }


    palette_color.click(function() {
        palette_preview_box.removeClass('hidden')
        paintPalettePreview($(this).attr('gradient-bg'))
    });

    palette_close.click(function() {
        palette_preview_box.addClass('hidden')
        message_color = null;
        // paintPalettePreview($(this).attr('gradient-bg'))
    });

    palette_selector.mouseup(function(e) {
        palette.removeClass("hidden");
    });

    notif_icon.mouseup(function(e) {
        console.log(notif_dropdown);
        notif_dropdown.removeClass("hidden");
    });

    $(document).mouseup(function(e) {
        // console.log(palette_selector.has(e.target));
        // if the target of the click isn't the container nor a descendant of the container
        if (
            !palette_selector.is(e.target) &&
            palette_selector.has(e.target).length === 0 &&
            !palette.hasClass("hidden")
        ) {
            palette.addClass("hidden");
        }

        if (
            !notif_icon.is(e.target) &&
            notif_icon.has(e.target).length === 0 &&
            !notif_dropdown.hasClass("hidden")
        ) {
            notif_dropdown.addClass("hidden");
        }

        if (
            !$('.reactions').is(e.target) &&
            $('.reactions').has(e.target).length === 0 
            &&
            !$(e.target).hasClass("current")
        ) {
            $('.reactions-container').addClass("hidden");
        }
    });
</script>
@endsection