    <div class="flex items-center justify-between shadow-md p-2 px-3">
        <div class="openNavBtn md:w-1/2 px-3 flex space-x-2">
            <i class="mdi mdi-menu font-bold text-2xl text-cha-primary"></i>
        </div>
        <div class="icons flex items-center space-x-4 md:w-1/2 justify-end">
            <div id="notif-icon" class="relative cursor-pointer rounded-full text-center text-cha-primary w-6 flex items-center justify-center h-6 bg-purple-200 hover:bg-purple-300">
                <i class="mdi mdi-bell"></i>
                <span class="absolute -top-1 -right-1 notif-count bg-cha-primary text-white px-1 rounded-full" style="font-size: 8px">
                    9
                </span>
                <div id="notif-dropdown" class="hidden notif-dropdown absolute shadow top-6 -right-5 p-3 rounded bg-white z-10 w-64">
                    <p class="text-cha-primary font-medium mb-2">Notifications</p>
                    <ul class="notifications-list flex flex-col items-start space-y-2 text-xs text-gray-500">
                        <li>
                            <i class="mdi mdi-bell"></i>
                            O my god
                        </li>
                        <li>
                            <i class="mdi mdi-bell"></i>
                            O my god
                        </li>
                        <li>
                            <i class="mdi mdi-bell"></i>
                            O my god
                        </li>
                        <li>
                            <i class="mdi mdi-bell"></i>
                            O my god
                        </li>
                        <li>
                            <i class="mdi mdi-bell"></i>
                            O my god
                        </li>
                    </ul>
                </div>
            </div>

            <div class="dp">
                <img src="{{
                                        asset('img/placeholders/profile.jpg')
                                    }}" alt="" class="rounded-full w-6 h-6 object-cover cursor-pointer" />
            </div>
        </div>
    </div>