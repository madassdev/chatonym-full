<div class="logo p-3">
    Chatonym<strong class="text-green-600 font-bold">.</strong>
</div>

<div class="profile flex items-center justify-center my-5">
    <div class="dp text-center">
        <img src="{{asset('img/placeholders/profile.jpg')}}" class="object-cover rounded-full w-24 h-24 my-2" alt="" />
        <p class="">Victor Joseph</p>
        <p class="text-xs">@joewin_</p>
    </div>
</div>

<ul class="flex-flex-col space-y-4 px-5">
    <li>
        <a href="{{route('home')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-trending-up text-xl mr-1"></i>
            Trending
        </a>
    </li>
    <li>
        <a href="{{route('user.messages.show')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-email text-xl mr-1"></i>
            Messages <span class="badge badge-danger">5</span>
        </a>
    </li>
    <li>
        <a href="{{route('user.threads.show')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-forum text-xl mr-1"></i>
            Threads
        </a>
    </li>
    <li>
        <a href="{{route('user.profile.show')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-cog text-xl mr-1"></i>
            Settings
        </a>
    </li>
</ul>