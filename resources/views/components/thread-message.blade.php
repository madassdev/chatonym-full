<div class="feed rounded-xl bg-cha-secondary m-3 my-1 p-3" id="feed-placeholder">
    <div class="feed-body mb-1 max-sh-40 zoverflow-hidden relative">
        @php
        $reactions = ['love', 'like', 'smile', 'laugh', 'applaud', 'surprise', 'angry'];
        @endphp
        <div class="hidden image cursor-pointer my-2 w-5/6 m:w-2/3 mx-auto flex items-center justify-center hiddesn">
            <img src="{{asset('img/placeholders/image-loading.gif')}}" class="rounded-2xl feed-img object-cover h-44 w-full" alt="" srcset="" />
        </div>
        <div class="text w-full mx-auto p-3 rounded-xl max-h-24 md:max-h-40 overflow-scroll">
            <p class="font-light  text-sm feed-message">
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
    </div>
    <div class="w-full my-2 text-xs text-gray-600 mx-auto feed-footer flex items-center px-3">
        <div class="w-2/3 reactions flex items-center justify-between relative">
            <div class="w-full add-reaction flex space-x-4 cursor-pointer items-center">
                <img src="{{asset('img/icons/add-smiley.svg')}}" class="h-6 select-reaction" />
                <div class="w-1/3 flex items-center text-lg text-cha-primary">
                    😅
                    <span class="reactions_count text-xs"> 218</span>
                </div>
            </div>
            <div class="reactions-container hidden absolute z-1  left-0 -bottom-6">
                <div class="reaction-container flex items-center shadow-lg flex-auto space-x-2 md:space-x-4 rounded-full px-2 py-1 bg-gray-50">
                    @foreach($reactions as $reaction)
                    <img src="{{asset('img/icons/'.$reaction.'.svg')}}" alt="" class="h-6 w-6 cursor-pointer reaction" reaction="{{$reaction}}">
                    @endforeach
                </div>
            </div>

        </div>
        <div class="reply text-cha-primary">
                <i class="mdi mdi-reply"></i>
                Reply
        </div>
    </div>
</div>