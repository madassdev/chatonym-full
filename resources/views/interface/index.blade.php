<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <script src="{{ asset('js/app.js') }}"></script>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet"
        />

        <title>Chatonym</title>
    </head>

    <body class="font-normal">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.sidebar')
            <!-- Main -->
            <div class="w-1/2 p-0 m-0">
                @include('partials.topbar')
                <div class="content mt-16">
                    <div class="m-3 bg-cha-secondarys p-3 rounded-2xl">
                        <div class="row">
                            <div class="w-1/6 px-2">
                                <img
                                    src="{{
                                        asset('img/placeholders/profile.jpg')
                                    }}"
                                    class="rounded-full float-right w-12 h-12 object-cover"
                                    alt=""
                                />
                            </div>
                            <div class="w-5/6 texting flex flex-col pr-4">
                                <div
                                    class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white"
                                >
                                    <textarea
                                        name=""
                                        id=""
                                        cols="30"
                                        rows="1"
                                        class="border-0 resize-none rounded-full w-full py-1 placeholder-gray-300"
                                        placeholder="Write something.."
                                    ></textarea>
                                    <i
                                        class="mdi mdi-emoticon-happy-outline text-xl text-gray-400"
                                    ></i>
                                    <i
                                        class="mdi mdi-send text-xl text-cha-primary"
                                    ></i>
                                </div>

                                <div
                                    class="styling px-4 flex items-center relative"
                                >
                                    <div class="w-3/4">
                                        <img
                                            src="{{
                                                asset('img/icons/rainbow.svg')
                                            }}"
                                            class="rounded-full cursor-pointer w-8"
                                            alt=""
                                            id="palette-selector"
                                        />
                                        <div
                                            id="palette"
                                            class="absolute z-10 bg-cha-secondarys bg-gray-50 shadow-lg left-10 top-3 p-2 grid grid-cols-8 gap-2 rounded w-5/6"
                                        >
                                            @foreach(['a', 'b', 'c'] as $c)
                                            <div
                                                class="bg-red-200 w-8 h-8 rounded"
                                            ></div>
                                            <div
                                                class="bg-blue-200 w-8 h-8 rounded"
                                            ></div>
                                            <div
                                                class="bg-green-200 w-8 h-8 rounded"
                                            ></div>
                                            <div
                                                class="bg-pink-200 w-8 h-8 rounded"
                                            ></div>
                                            <div
                                                class="bg-yellow-200 w-8 h-8 rounded"
                                            ></div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div
                                        class="icons flex items-center w-1/2 justify-end space-x-4"
                                    >
                                        <i
                                            class="mdi mdi-plus text-cha-primary text-xl"
                                        ></i>
                                        <i
                                            class="mdi mdi-camera-image text-cha-primary text-xl"
                                        ></i>
                                        <i
                                            class="mdi mdi-video-plus text-cha-primary text-xl"
                                        ></i>
                                        <img
                                            src="{{
                                                asset('img/icons/GIF.svg')
                                            }}"
                                            class="w-5"
                                            alt=""
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="feeds">
                        @foreach(['a', 'b', 'c'] as $c)
                        <div class="feed rounded-xl bg-cha-secondarsy m-3 p-3">
                            <div
                                class="feed-body mb-1 p-3 h-48 overflow-hidden overflow-ellipsis relative"
                            >
                                <div class="text">
                                    <p class="text-xs font-light text-gray-600">
                                        I don't care about that, just get your
                                        bag mama - American rapper, Young M.A
                                        reacts to the viral video of her ex, Mya
                                        YafaiÂ Â holding hands with Davido
                                        (Video)
                                    </p>
                                </div>
                                <div class="image my-2 w-2/3 mx-auto">
                                    <img
                                        src="{{
                                            asset('img/placeholders/horse.jpg')
                                        }}"
                                        class="rounded-2xl"
                                        alt=""
                                        srcset=""
                                    />
                                </div>
                                <div
                                    class="absolute bg-gradient-to-b from-transparent to-purple-100 bottom-0 h-16 w-full"
                                ></div>
                            </div>
                            <div
                                class="w-4/5 text-gray-600 mx-auto feed-footer flex items-center justify-between p-3"
                            >
                                <div class="">
                                    <i
                                        class="mdi mdi-heart-outline text-xl"
                                    ></i>
                                    320
                                </div>
                                <div class="">
                                    <i
                                        class="mdi mdi-message-text-outline text-xl"
                                    ></i>
                                    58
                                </div>
                                <div class="">
                                    <i
                                        class="mdi mdi-export-variant text-xl"
                                    ></i>
                                    16
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @include('partials.rightbar')
        </div>
        <script>
            var palette = $("#palette");
            var palette_selector = $("#palette-selector");
            // console.log(palette)
            palette.hide();

            palette_selector.mouseup(function (e) {
                palette.show();
            });

            $(document).mouseup(function (e) {
                // console.log(palette_selector.has(e.target));
                // if the target of the click isn't the container nor a descendant of the container
                if (
                    !palette_selector.is(e.target) &&
                    palette_selector.has(e.target).length === 0
                ) {
                    palette.hide();
                }
            });
        </script>
    </body>
</html>
