@extends('user.profile') @section('content-in')
<div class="mx-2 mt-8 flex flex-col md:mx-auto md:w-2/3 space-y-8 items-center justify-center text-gray-100">
    <p class="text-xl text-gray-900">Threads</p>

    <!-- @foreach(auth()->user()->messages as $message)
    <x-private-message :message="$message"></x-private-message>
    @endforeach -->
</div>
<div class="threads-container flex flex-col space-y-4 mx-4 my-5">
    @foreach(auth()->user()->threads as $t)
    <div class="bg-cha-secondary w-full md:w-3/4 mx-auto px-5 pt-5 pb-3 rounded-xl">
        <div class="flex items-center justify-between">
            <p class="text-cha-primary font-bold">
                <a href="{{route('thread.show',$t)}}">
                    <strong>#</strong> {{ucfirst($t->name)}}
                </a>
            </p>
            <span class="share-thread-btn cursor-pointer text-xs text-cha-primary" data-thread-link="{{route('thread.show', $t)}}" data-share-link="{{shareThreadLink(route('thread.show', $t))}}">
                <i class="mdi mdi-share"></i> Share
            </span>
        </div>
        <div class="desc my-2">
            <p class="font-light text-xs font-gray-600">
                {{$t->description}}
            </p>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-xs text-cha-primary mt-6">
                <a href="{{route('thread.show',$t)}}">
                    <i class="mdi mdi-comment-outline mr-1"></i>
                    {{$t->messages_count}}
                    messages
                </a>
            </span>
            <div class="actions mt-6 flex items-center justify-end space-x-6 text-cha-primary text-xs">
                <form action="{{route('thread.destroy', $t)}}" class="inline-flex" method="post" onsubmit="return confirm('Thread will be deleted, proceed?');">
                    @csrf
                    @method('delete')
                    <div class="input-group mb-3">
                        <input name="balance" type="hidden" value="{{$t->id}}">
                        <div class="input-group-append">
                            <button class="btn btn-danger text-xs" type="submit">
                                <i class="mdi mdi-delete"></i> Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection @push('scripts')
@if(session()->has('success'))
<script>
    notyf.success({
        message: "{{session()->get('success')}}",
        duration: 1500
    })
</script>
@endif()
@endpush