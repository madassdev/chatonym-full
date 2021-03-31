@extends('user.profile') @section('content-in')
<div class="mx-2 mt-8 flex flex-col md:mx-auto md:w-2/3 space-y-8 items-center justify-center text-gray-100">
    < <div class="flex items-center w-full px-8 justify-between">
        <p class="text-xl text-gray-900">Replies</p>
        <a href="{{route('user.messages.show')}}" class="text-cha-primary text-xs px-4 py-1 rounded-full border border-cha-primary">Messages</a>
    </div>
    @forelse($user->replies as $message)
    <x-private-message :message="$message"></x-private-message>
    @empty
    <p class="text-2xl text-gray-400">No messages yet</p>
    Non
    @endforelse
</div>

@endsection @push('scripts')
<script></script>
@endpush