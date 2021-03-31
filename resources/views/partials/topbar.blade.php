    <div class="flex items-center justify-between shadow-md p-2 px-3">
        <div class="openNavBtn md:w-1/2 px-3 flex space-x-2">
            <i class="mdi mdi-menu font-bold text-2xl {{$togglenav}} md:{{$togglenav}}"></i>
        </div>
        <div class="icons flex items-center space-x-4 md:w-1/2 justify-end">
            @auth
            <div id="notif-icon" class="relative cursor-pointer rounded-full text-center text-cha-primary h-8 w-8 flex items-center justify-center bg-purple-200 hover:bg-purple-300">
                <i class="mdi mdi-email"></i>
                <span class="hidden notif-count absolute -top-1 -right-1 bg-red-500 w-1 h-1 text-white px-1 rounded-full" style="font-size: 8px">
                    0
                </span>
                <div id="notif-dropdown" class="hidden notif-dropdown absolute shadow top-6 -right-5 p-3 rounded bg-white z-10 w-64 cursor-default">
                    <p class="text-cha-primary text-sm font-bold mb-2">Notifications</p>
                    <ul class="notifications-list flex flex-col items-start space-y-2 text-xs text-gray-500">
                        <li class="no-new">
                            <a href="#" class="notif-link">
                                <i class="mdi mdi-bell"></i>
                                <span class="notif-text ml-4">
                                    No new notification
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            @endauth
            <!-- <div class="mock-notif relative p-1 h-8 w-8 z-30 rounded-full cursor-pointer flex items-center justify-center bg-cha-primary">
                <i class="mdi mdi-email text-sm text-white text-center"></i>
            </div> -->

            <div class="dp openNavBtn">
                <img src="{{
                                        asset('img/placeholders/anonymous.jpeg')
                                    }}" alt="" class="rounded-full w-6 h-6 object-cover cursor-pointer" />
            </div>
        </div>
    </div>