@extends('layouts.chatonym')

@section('content')
@auth
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
                    <textarea name="" id="message" cols="30" rows="3" class="text-xs text-gray-600 border-0 resize-none rounded-xl w-full py-1 placeholder-gray-400" placeholder="Write something.."></textarea>
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
                        <i class="mdi mdi-camera-image text-cha-primary text-xl cursor-pointer"></i>
                        <i class="mdi mdi-video-plus text-cha-primary text-xl cursor-pointer"></i>
                        <img src="{{
                                                    asset('img/icons/GIF.svg')
                                                }}" class="w-5 cursor-pointer" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endauth
<section class="feeds-container duration-300">
    <x-feed-card :has_comments="1" />
    <x-feed-card :has_comments="1" />

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
<div class="hidden">
</div>


<div class="modal micromodal-slide" id="feed-open-modal" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container p-3 w-full mx-2" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header text-cha-primary">
                <h2 class="modal__title" id="modal-1-title">

                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content p-3" id="modal-1-content">
                <img src="{{asset('img/placeholders/smileys.jpg')}}" class="feed-modal-image" alt="" srcset="">
            </main>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
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


    // MicroModal.show("feed-open-modal");


    function generateFeedUi(data) {
        gradients = ["gra-orange text-white", 'gra-oxblood text-white', 'gra-quepal text-white', 'gra-cherry text-white', 'gra-amin text-white', 'gra-veryblue text-white']
        gra_bg = Math.floor(Math.random() * 8);
        img = false
        message = data.message
        type = data.media_type
        if (type == "text-and-image") {
            images = data.image_url
            if (images.length) {
                img = true;
            }
        }
        var new_feed = feed.clone()
        grad = gradients[gra_bg]
        new_feed.attr('feed-id', data.id)
        // new_feed.find('.feed-body').addClass(grad + ' py-3 rounded-2xl')
        new_feed.find('.feed-message').html(message)
        new_feed.find('.feed-comments-link').attr('href', "{{config('app.url').'/feeds/'}}" + data.id)
        feeds_container.append(new_feed)
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

        // REPLY UI
        new_feed.find('.replies-count').text("Replies")
        replies = new_feed.find('.replies-container')
        old_reply = replies.find('.reply')
        new_feed.find('.see-more').hide()
        new_feed.find('.replies-icon-count').text(data.replies.length > 0 ? data.replies.length : '')
        new_feed.find('.replies-count').hide()
        replies.addClass('hidden')
        


        if (data.replies.length > 0) {
            // replies.removeClass('hidden')
            new_feed.find('.replies-count').show()
            old_reply.remove()
            data.replies.slice(0, 2).map(r => {
                var new_reply = old_reply.clone()
                new_reply.find('.reply-text').text(r.message ?? 'reply goes here')
                new_reply.find('.reply-date').text(new Date(r.created_at).toDateString())
                replies.append(new_reply)
            })
            replies.removeClass('hidden')
            if (data.replies.length > 2) {
                new_feed.find('.see-more').show()
            }

        }

        new_feed.show()

    }
    // feeds_spinner.hide()

    // async function showComments(feed_id)
    // {

    //     $('.create-feed').toggleClass('hidden')
    //     clog('feed is' +feed_id)
    // }

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

    $('.comments').click(function() {
        clog('ccck')
    })
    // console.log(palette)
    // palette.hide();

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
    });
</script>
@endsection