@extends('layouts.chatonym')

@section('content')

<div id="palette-preview" class="hidden h-24 m-3 px-5 py-3 rounded-2xl gra-orange text-white" gradient-bg="gra-orange">
    <p class="preview-text text-xs">
        Type a message in the input box below to preview
    </p>
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
                        <div id="palette" class="hidden absolute z-10 bg-cha-secondarys bg-gray-50 shadow-lg left-10 top-3 p-2 grid grid-cols-8 gap-2 rounded w-5/6">
                            @foreach(['a', 'b', 'c'] as $c)
                            <div class="gra-orange w-8 h-8 rounded palette-color" gradient-bg="gra-orange"></div>
                            <div class="gra-oxblood w-8 h-8 rounded palette-color" gradient-bg="gra-oxblood"></div>
                            <div class="gra-tealgreen w-8 h-8 rounded palette-color" gradient-bg="gra-tealgreen"></div>
                            <div class="gra-cherry w-8 h-8 rounded palette-color" gradient-bg="gra-cherry"></div>
                            <div class="gre-mello w-8 h-8 rounded palette-color" gradient-bg="gra-mello"></div>
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

<div class="feeds">
    @foreach(['a', 'b', 'c', 'd'] as $c)
    @php
    $rand = rand(0,1);
    $img_array = ['img/placeholders/horse.jpg', 'img/placeholders/smileys.jpg']
    @endphp
    <div class="feed rounded-xl bg-cha-secondary m-3 p-3">
        <div class="feed-body mb-1 p-3 h-48 overflow-hidden overflow-ellipsis relative">
            <div class="text">
                <p class="font-light text-gray-600">
                    I don't care about that, just get your
                    bag mama - American rapper, Young M.A
                    reacts to the viral video of her ex, Mya
                    YafaiÂ Â holding hands with Davido
                    (Video)
                </p>
            </div>
            <div class="image my-2 w-2/3 mx-auto">
                <img src="{{
                                            asset($img_array[$rand])
                                        }}" class="rounded-2xl" alt="" srcset="" />
            </div>
            <div class="absolute bg-gradient-to-b from-transparent to-cha-secondary bottom-0 h-16 w-full"></div>
        </div>
        <div class="w-4/5 text-xs text-gray-600 mx-auto feed-footer flex items-center justify-between p-3">
            <div class="">
                <i class="mdi mdi-heart-outline"></i>
                320
            </div>
            <div class="">
                <i class="mdi mdi-message-text-outline"></i>
                58
            </div>
            <div class="">
                <i class="mdi mdi-export-variant"></i>
                16
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    var message = $("#message")
    var palette = $("#palette");
    var palette_preview = $("#palette-preview");
    var modal = $("#modal");
    var palette_color = $(".palette-color");
    var palette_selector = $("#palette-selector");
    var notif_icon = $("#notif-icon");
    var notif_dropdown = $("#notif-dropdown");
    // console.log(palette)
    // palette.hide();

    message.keyup(function(e) {
        var text = $(this).val();
        palette_preview.children(".preview-text").removeClass('text-xs').text(text)
    })

    function paintPalettePreview(color) {
        previous_color = palette_preview.attr('gradient-bg')
        palette_preview.removeClass(previous_color);
        palette_preview.addClass(color)
        palette_preview.attr('gradient-bg', color)
    }


    palette_color.click(function() {
        palette_preview.removeClass('hidden')
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