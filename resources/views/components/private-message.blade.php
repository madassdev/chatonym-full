<div class="w-full p-3 gra-cherry rounded-xl">
    <div class="message-body mb-8 p-5 h-16 overflow-scroll">
        <p class="font-light text-gray-100 text-sm">{!!$message->message!!}</p>
    </div>
    <div class="message-footer px-5 flex justify-between items-center">
        <div class="">
            <p class="text-xs-8 text-right">
                {{$message->created_at->format('d M Y')}}
            </p>
        </div>
        @if($message->replyable && $message->replier_token)
        <div class="">
            <a
                href="{{route('user.chat.show', ['message' => $message->id])}}"
            >
                <i class="mdi mdi-chat"></i>
                <span class="text-xs-8">Open chat</span>
            </a>
        </div>
        @endif
        <div class="">
            <i class="mdi mdi-share"></i>
        </div>
    </div>
    <div class="details my-2">
        <p class="text-xs-6 text-right">
            Chatonym.com
        </p>
    </div>
</div>
