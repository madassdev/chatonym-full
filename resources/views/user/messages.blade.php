@extends('user.profile') @section('content-in')
<div class="mx-2 mt-8 flex flex-col md:mx-auto md:w-2/3 space-y-8 items-center justify-center text-gray-100">
    <p class="text-xl text-gray-900">Messages</p>
    @forelse($user->messages as $message)
    <x-private-message :message="$message"></x-private-message>
    @empty
    <p class="text-2xl text-gray-400">No messages yet</p>
    Non
    @endforelse
</div>

@endsection @push('scripts')
<script></script>
@endpush