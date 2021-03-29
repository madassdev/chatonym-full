@extends('layouts.vue')
@section('content')
<div class="mx-2 mt-8 flex flex-col md:mx-auto md:w-full space-y-8 items-center justify-center text-gray-100 h-full overflow-y-scroll" id="messagesViewport">
    <p class="text-xl text-gray-900">Chat</p>

    <div class="flex flex-col space-y-2 px-8 w-full chats-container pb-32">
        @foreach($message->chats as $chat)
        @if($chat->is_sender)
        <div class="sender-chat flex justify-end w-full">
            <div class="max-w-3/4 bg-cha-primary text-white p-3 rounded-l-xl rounded-tr-xl">
                <p class="text-sm chat-message">
                    {{$chat->message}}
                </p>
                <!-- <p class="text-xs-8 mt-3 text-left chat-time">
                    {{$chat->created_at->diffForHumans()}}
                </p> -->
            </div>
        </div>
        @else
        <div class="flex justify-start w-full">
            <div class="max-w-3/4 bg-cha-secondary text-gray-600 p-3 rounded rounded-r-xl rounded-tl-xl">
                <p class="text-sm">
                    {{$chat->message}}
                </p>
                <!-- <p class="text-xs-8 mt-3 text-right">
                    {{$chat->created_at->diffForHumans()}}
                </p> -->
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
<div class="w-full md:w-1/2 reply-chat fixed z-20 text-white bottom-0 hiddens">
    <div class="w-full mx-auto shadow-xl rounded-full flex items-center mb-3 px-4 md:space-x-1 space-x-2">
        <div class="textarea flex space-x-4 items-center pr-3 w-11/12 rounded-full bg-white">
            <textarea name="" id="reply-message" cols="30" class="pl-4 py-1 text-xs text-gray-600 border-0 resize-none rounded-full w-full placeholder-gray-400" placeholder="Write something.." autofocus></textarea>
        </div>
        <span class="flex items-center justify-center bg-white rounded-full p-1">

            <i class="mdi mdi-send text-xl text-cha-primary cursor-pointer chat-send"></i>
        </span>
    </div>
</div>

@endsection
@section('scripts')
<script>
    var scrollToBottom = (duration = 0) => {
        $("html, body").animate({
            scrollTop: $(document).height()
        }, duration);
    }
    scrollToBottom();

    $('.chat-send').click(() => {
        scrollToBottom();

        var new_chat = $($('.sender-chat')[0]).clone();
        if ($('#reply-message').val() !== "") {
            var message = $('#reply-message').val()
            new_chat.find('.chat-message').html(message.replace(/\n/g, '<br />'))
            // new_chat.find('.chat-time').text(moment().format(Date.now()))
            $('.chats-container').append(new_chat)
            $('#reply-message').val('')
            //send to backend
            $.post('', {
                message: message,
                // replier_token: "{{}}"
            }).done((res) => {
                clog(res)
            })
        }
    })
</script>
@endsection