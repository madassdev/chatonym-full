
        <div class="flex items-center justify-center mt-5">
            <p class="text-xl font-bold text-center"># HOT TRENDS</p>
        </div>

        <div class="flex flex-col px-3">
            @foreach(App\Models\Thread::whereVisibility('public')->withCount('messages')->orderBy('messages_count', 'desc')->take(5)->get() as $t)
            <div class="p-1 my-1">
                <strong>#</strong>
                <a href="{{route('thread.show', $t)}}">
                    {{ucfirst($t->name)}}
                </a> 
                <p class="text-xs truncate-2">{{$t->description}}</p>
                <div class="stats flex items-center justify-between my-3">
                    <!-- <p class="text-xs text-cha-accent">4</p> -->
                    <p class="text-xs text-cha-accent">{{$t->messages_count}} messages</p>
                </div>
                <img src="{{asset('img/icons/divider.svg')}}" class="h-full" alt="">
            </div>
            @endforeach
        </div>

        <div class="flex items-center justify-center my-12">
            <a href="#" class="h-12 w-12 flex rounded-full shadow-lg items-center justify-center bg-white text-cha-primary">
                <i class="mdi mdi-trending-up"></i>
            </a>
        </div>
    </div>
</div>