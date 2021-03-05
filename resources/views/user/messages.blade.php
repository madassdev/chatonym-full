@extends('user.profile') @section('content-in')
<div
    class="mx-2 mt-8 flex flex-col md:mx-auto md:w-2/3 space-y-8 items-center justify-center text-gray-100"
>
    <p class="text-xl text-gray-900">Messages</p>
    @foreach($user->messages as $message)
    <x-private-message :message="$message"></x-private-message>
    @endforeach
</div>

@endsection @push('scripts')
<script></script>
@endpush
