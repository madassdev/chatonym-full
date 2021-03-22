<div class="logo p-3">
    Chatonym<strong class="text-green-600 font-bold">.</strong>
</div>
@auth
<div class="profile flex  flex-col items-center justify-center my-5 space-y-2">
    <div class="dp text-center">
        <img src="{{asset('img/placeholders/profile.jpg')}}" class="object-cover rounded-full w-24 h-24 my-2" alt="" />
        <p class="text-xs">{{'@'.auth()->user()->username}}</p>
    </div>

    <div title="Click to copy" class="rounded-full border-gray-100 border p-1 text-xs cursor-pointer hover:border-0 hover:bg-gray-100 hover:text-cha-primary hover:font-bold hover:px-2">
        <p class="ref-link">
            {{auth()->user()->ref_link}}
            <i class="mdi mdi-content-copy"></i>
        </p>
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
            Messages <span class="bg-white text-cha-primary px-1 font-bold rounded-full text-xs">5</span>
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
    <li>
        <a href="{{route('logout')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-account-arrow-right-outline text-xl mr-1"></i>
            Logout
        </a>
    </li>
</ul>
@endauth
@guest
<div class="profile flex items-center justify-center my-5">
    <div class="dp text-center">
        <img src="{{asset('img/placeholders/profile.jpg')}}" class="object-cover rounded-full w-24 h-24 my-2" alt="" />
        <p class="text-xs">Sign in</p>
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
        <a href="{{route('feed.index')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-rss text-xl mr-1"></i>
            Feeds
        </a>
    </li>
    <li>
        <a href="{{route('login')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-login text-xl mr-1"></i>
            Sign in 
        </a>
    </li>
    <li>
        <a href="{{route('register')}}" class="hover:text-purple-200 hover:no-underline">
            <i class="mdi mdi-account-plus text-xl mr-1"></i>
            Sign up 
        </a>
    </li>
</ul>
@endguest