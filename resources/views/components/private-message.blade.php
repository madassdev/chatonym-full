<div class="w-full p-3 gra-cherry rounded-xl">
    <div
        class="message-body mb-8 p-5 h-16 overflow-scroll"
    >
        <p class="font-light text-gray-100 text-sm">{!!$message->message!!}</p>
    </div>
    <div class="message-footer px-5 flex justify-between items-center">
        <div class="">
            <p class="text-xs-8 text-right">
                {{$message->created_at->format('d M Y')}}
            </p>
        </div>
        <div class="">
            <i class="mdi mdi-share"></i>
        </div>
    </div>
    <div class="details my-2">
        <p class="text-xs-6 text-right">
            chatonym.com
        </p>
    </div>
</div>
