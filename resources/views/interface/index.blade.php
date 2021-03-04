@extends('layouts.chatonym')

@section('content')
@auth
<section class="create-feed">
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
                                            asset('img/placeholders/profile.jpg')
                                        }}" class="rounded-full float-right w-8 h-8 md:w-12 md:h-12 object-cover" alt="" />
            </div>
            <div class="w-5/6 texting flex flex-col pr-4">
                <div class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white">
                    <textarea name="" id="message" cols="30" rows="1" class="text-xs text-gray-600 border-0 resize-none rounded-full w-full py-1 placeholder-gray-400" placeholder="Write something.."></textarea>
                    <i class="mdi mdi-emoticon-happy-outline text-xl text-gray-400"></i>
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
</section>
@endauth
<section class="feeds-container">
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
    <x-feed-card />
</div>
@endsection

@section('scripts')
<script>
    var shouldFetchFeeds = true;
    var message = $("#message")
    var palette = $("#palette");
    var palette_preview = $("#palette-preview");
    var palette_preview_box = $("#palette-preview-box");
    var modal = $("#modal");
    var palette_color = $(".palette-color");
    var palette_selector = $("#palette-selector");
    var notif_icon = $("#notif-icon");
    var notif_dropdown = $("#notif-dropdown");
    var feeds = []
    var feeds_url = "{{config('app.feeds_url')}}" + "&client_token=anonymous-api-token";
    var feeds_spinner = $('.feeds-spinner')
    var feed = $('#feed-placeholder');
    var feeds_container = $('.feeds');


    function generateFeedUi(data) {
        img = false
        message = data.message
        type = data.media_type
        if (type == "text-and-image") {
            images = data.image_url
            if (images.length) {
                clog(images[0].url)
                img = true;
            }
        }
        var new_feed = feed.clone()
        new_feed.find('.feed-message').html(message)
        feeds_container.append(new_feed)
        if (img) {
            new_feed.find('.image').removeClass('hidden')
            new_feed.find('.feed-img').attr('src', images[0].url)
        }
        // clog('clientheight is ' + new_feed.find('.feed-body').prop('clientHeight'))
        // clog('offsetHeight is ' + new_feed.find('.feed-body').prop('offsetHeight'))
        // clog('scrollHeight is ' + new_feed.find('.feed-body').prop('scrollHeight'))

        if (new_feed.find('.feed-body').prop('clientHeight') > 100) {
            new_feed.find('.overflow-blocker').show()
        }

    }
    // feeds_spinner.hide()
    async function showFeeds() {
        feeds_container.append(feeds_spinner)
        feeds_spinner.addClass('mb-64')
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

    $(window).scroll(function() {
        if (($(window).scrollTop() == $(document).height() - $(window).height() && shouldFetchFeeds)) {
            showFeeds()
        }
    });
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