@extends('layouts.vue')

@section('content')
<section>
    <div id="peep" class="p-3">
        <p class="text-cha-primary text-2xl">Peeping {{$user->username}}</p>

        <div class="flex flex-col space-y-4">
        @foreach($user->messages as $message)
        <x-private-message :message="$message"></x-private-message>
        @endforeach
        </div>
    </div>
</section>
@endsection
