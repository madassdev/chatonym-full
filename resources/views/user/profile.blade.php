@extends('layouts.profile') @section('content')
<div class="px-3 py-4 bg-cha-primary w-full text-gray-100">
    <div class="flex items-center justify-center flex-col pt-8">
        <div class="w-24 h-24 relative mb-2">
            <img
                src=" {{ asset('img/placeholders/profile.jpg') }}"
                alt=""
                class="border-2 border-gray-200 shadow-lg rounded-full h-24 w-24 object-cover"
            />
            <span
                class="bg-white absolute bottom-1 right-1 h-6 w-6 flex justify-center items-center rounded-full text-center"
            >
                <i class="text-cha-primary text-lg mdi mdi-incognito"></i>
            </span>
        </div>
        <div class="text my-2">
            <p class="font-light text-center">@_franksmith</p>
        </div>

        <div
            class="flex w-full md:w-1/2 my-5 items-center justify-between px-3"
        >
            <div class="dms text-center">
                <p class="text-sm">
                    <i class="mdi mdi-email"></i>
                    221
                </p>
                <p class="text-xs">Messages</p>
            </div>
            <div class="threads text-center">
                <p class="text-sm">
                    <i class="mdi mdi-forum"></i>
                    221
                </p>
                <p class="text-xs">Threads</p>
            </div>
            <div class="cta text-center">
                <a
                    href="#"
                    class="p-2 md:p-3 rounded-full bg-gray-100 text-xs text-cha-primary"
                >
                    <i class="mdi mdi-plus"></i>
                    Create thread
                </a>
            </div>
        </div>
    </div>
</div>

<div class="p-5 mx-3 md:mx-5 bg-white shadow-sm rounded my-12">
    <div class="mb-8">
        <p class="text-xs">Account settings</p>
        <p class="text-lg font-bold">Change password</p>
    </div>

    <form action="">
        <div
            class="form-group flex space-y-2 flex-col md:flex-row mb-6 items-start md:items-center"
        >
            <label for="" class="md:w-2/5 md:text-right md:pr-8"
                >Current password</label
            >
            <div class="input md:w-2/3 w-full">
                <input
                    type="password"
                    id="current-password"
                    class="rounded-xl border-gray-400 border w-full"
                />
            </div>
        </div>
        <div
            class="form-group flex space-y-2 flex-col md:flex-row mb-6 items-start md:items-center"
        >
            <label for="" class="md:w-2/5 md:text-right md:pr-8"
                >New password</label
            >
            <div class="input md:w-2/3 w-full">
                <input
                    type="password"
                    id="password"
                    class="rounded-xl border-gray-400 border w-full"
                />
            </div>
        </div>
        <div
            class="form-group flex space-y-2 flex-col md:flex-row mb-6 items-start md:items-center"
        >
            <label for="" class="md:w-2/5 md:text-right md:pr-8"
                >Re-enter password</label
            >
            <div class="input md:w-2/3 w-full">
                <input
                    type="password"
                    id="confirm-password"
                    class="rounded-xl border-gray-400 border w-full"
                />
            </div>
        </div>
        <div class="flex justify-end">
            <x-primary-button id="pwdSubmitBtn">Submit</x-primary-button>
        </div>
    </form>
</div>
@endsection
