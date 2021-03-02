<div class="rightbar w-1/4 text-white">
    <div class="w-1/4 fixed m-0 p-0 bg-cha-primary h-screen oberflow-scroll">
        <div class="flex items-center justify-center p-5">
            <p class="text-4xl font-bold text-center"># HOT TRENDS</p>
        </div>

        <div class="flex flex-col px-5">
            @foreach([1,2,3,4] as $c)
            <div class="p-1 my-3">
                <strong>#</strong> Platoon-8
                <p class="text-xs">Nobody knows who is who</p>
                <div class="stats flex items-center justify-between my-3">
                    <p class="text-xs text-cha-accent">4 Likes</p>
                    <p class="text-xs text-cha-accent">221 Comments</p>

                </div>
                <img src="{{asset('img/icons/divider.svg')}}" class="h-full" alt="">
            </div>
            @endforeach
        </div>
    </div>
</div>