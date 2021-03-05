@extends('user.profile')
@section('content-in')
<div class="p-5 mx-3 md:mx-5 bg-white shadow-sm rounded my-12">
    <div class="mb-8">
        <p class="text-xs">Account settings</p>
        <p class="text-lg font-bold">Change password</p>
    </div>

    <form action="">
        <div class="form-group flex space-y-2 flex-col md:flex-row mb-6 items-start md:items-center">
            <label for="" class="md:w-2/5 md:text-right md:pr-8">New password</label>
            <div class="input md:w-2/3 w-full">
                <input type="password" id="password" class="rounded-xl border-gray-400 border w-full" />
                <p class="hidden password-error text-red-500 text-xs p-2">
                    Error
                </p>
            </div>
        </div>
        <div class="form-group flex space-y-2 flex-col md:flex-row mb-6 items-start md:items-center">
            <label for="" class="md:w-2/5 md:text-right md:pr-8">Re-enter password</label>
            <div class="input md:w-2/3 w-full">
                <input type="password" id="c_password" class="rounded-xl border-gray-400 border w-full" />
                <p class="hidden c_password-error text-red-500 text-xs px-2">
                    Error
                </p>
            </div>
        </div>
        <div class="flex justify-end">
            <x-primary-button id="pwdBtn">Submit</x-primary-button>
        </div>
    </form>
</div>
@endsection