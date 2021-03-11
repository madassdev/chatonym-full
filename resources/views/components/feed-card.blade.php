<div class="feed rounded-xl bg-cha-secondary m-3 my-1 p-3 hidden" id="feed-placeholder">
    <div class="feed-body mb-1 max-sh-40 zoverflow-hidden relative">
        @php
        $reactions = ['love', 'smile', 'laugh', 'applaud', 'surprise', 'angry'];
        @endphp
        <div class="image cursor-pointer my-2 w-5/6 m:w-2/3 mx-auto flex items-center justify-center hiddesn">
            <img src="{{asset('img/placeholders/image-loading.gif')}}" class="rounded-2xl feed-img object-cover h-44 w-full" alt="" srcset="" />
        </div>
        <div class="text w-full mx-auto p-3 rounded-xl max-h-24 md:max-h-40 overflow-hidden overflow-scroll">
            <p class="font-light  text-sm feed-message font-light">
                I don't care about that, just get your
                bag mama - American rapper, Young M.A
                reacts to the viral video of her ex, Mya
                YafaiÂ Â holding hands with Davido
                (Video)
            </p>
            <p class="font-light text-gray-500 text-xs-10 flex items-center space-x-1 mt-1">
                <i class="mdi mdi-circle text-gray-400" style="font-size:4px"></i>
                <span class="feed-date">
                    Feb 12
                </span>
            </p>
        </div>

        <!-- <div class="overflow-blocker hidden absolute bg-gradient-to-b from-transparent to-cha-secondary bottom-0 h-16 w-full">
        </div> -->
    </div>
    <div class="w-full my-2 text-xs text-gray-600 mx-auto feed-footer flex items-center px-3">
        <div class="w-2/3 reactions flex items-center justify-between relative">
            <div class="w-full add-reaction flex space-x-4 cursor-pointer items-center">
                <img src="{{asset('img/icons/add-smiley.svg')}}" class="h-6" />
                <div class="w-1/3 flex items-center text-lg text-cha-primary">
                    😅
                    <span class="reactions_count text-xs"> 218</span>
                </div>
            </div>
            <div class="reactions-container hidden absolute z-10  left-0 -bottom-6">
                <div class="reaction-container flex items-center shadow-lg flex-auto space-x-2 md:space-x-4 rounded-full px-2 py-1 bg-gray-50">
                    @foreach($reactions as $reaction)
                    <img src="{{asset('img/icons/'.$reaction.'.svg')}}" alt="" class="h-6 w-6 cursor-pointer reaction" reaction="{{$reaction}}">
                    @endforeach
                </div>
            </div>

        </div>
        <div class="replies">
            <span class="cursor-pointer feed-comments-link flex items-center space-x-1">
                <i class="mdi mdi-message-text-outline text-lg text-cha-primary"></i>
                <span class="replies-icon-count text-cha-primary">43</span>
            </span>
        </div>
        <!-- <div class="">
                <i class="mdi mdi-heart-outline text-cha-primary"></i>
                <span class="likes">322</span>
            </div>
            <div class="feed-comments cursor-pointer">
                <a href="" class="feed-comments-link">
                    <i class="mdi mdi-message-text text-cha-primary"></i>
                    <span class="replies">43</span>
                </a>
            </div>
            <div class="">
                <i class="mdi mdi-export-variant text-cha-primary"></i>
                <span class="shares">44</span>
            </div> -->
    </div>
    <div class="feed-replies">
        <p class="replies-count text-cha-primary text-xs mx-4 hidden">

        </p>
        <div class="replies-container hidden flex flex-col space-y-2">
            <div class="reply-template w-5/6 mx-auto px-4  my-1 border-l border-gray-300 hidden">
                <p class="font-light truncate-2 text-gray-600 text-xs-12 leading-1 reply-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste eaque, voluptatibus ab, neque libero aut eos, facilis natus dicta quisquam aliquam quos similique excepturi velit iusto cupiditate aliquid earum odit!
                </p>
                <p class="font-light text-gray-400 text-xs-10 flex items-center space-x-1">
                    <i class="mdi mdi-circle text-gray-400" style="font-size:4px"></i>
                    <span class="reply-date">
                        Feb 12
                    </span>
                </p>
            </div>
        </div>
        <div class="see-more hidden mx-auto w-3/4">
            <a href="#" class="text-cha-primary text-xs">See more...</a>
        </div>
    </div>
</div>