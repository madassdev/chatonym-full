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
                <i class="text-cha-primary text-lg mdi mdi-guy-fawkes-mask"></i>
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
                >New password</label
            >
            <div class="input md:w-2/3 w-full">
                <input
                    type="password"
                    id="password"
                    class="rounded-xl border-gray-400 border w-full"
                />
                <p class="hidden password-error text-red-500 text-xs p-2">
                    Error
                </p>
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
                    id="c_password"
                    class="rounded-xl border-gray-400 border w-full"
                />
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
@endsection @section('scripts')
<script>
    var pwd_btn = $("#pwdBtn");

    function popAlert(type) {
        switch (type) {
            case "success":
                theme = "bg-green-300 text-green-700";

                break;
            case "warning":
                theme = "bg-yellow-400 text-yellow-900";

                break;
            case "danger":
                theme = "bg-red-300 text-red-700";

                break;

            default:
                theme = "bg-red-300 text-blue-700";
                break;
        }
        var alert = $(".alert");
        alert.toggleClass(theme + " opacity-0 opacity-90 translate-y-16");
    }

    var notyf = new Notyf({
        duration: 3000,
        position: {
            x: "right",
            y: "top",
        },
        types: [
            {
                type: "primary",
                background: "#ff8000",
                icon: {
                    className: "material-icons",
                    tagName: "i",
                    text: "star",
                },
            },
        ],
        dismissible: true,
    });

    pwd_btn.click(function () {
        notyf.open({
            type: "primary",
            message: "Send us <b>an email</b> to get support",
        });
        var err = 0;
        var spinner = $(this).children("svg");

        password = $("#password");
        c_password = $("#c_password");

        password.focus(function () {
            $(".password-error").text("Password cannot be empty").hide();
            password.removeClass("border-red-500");
        });
        c_password.focus(function () {
            $(".c_password-error").text("Password cannot be empty").hide();
            c_password.removeClass("border-red-500");
        });

        if (password.val() === "") {
            err++;
            $(".password-error").text("Password cannot be empty").show();
            password.addClass("border-red-500");
            password = $("#password");
        }
        if (password.val().length < 5) {
            err++;
            $(".password-error")
                .text("Password must be at least 5 characters long")
                .show();
            password.addClass("border-red-500");
            password = $("#password");
        }

        if (c_password.val() != password.val()) {
            err++;
            $(".c_password-error").text("Passwords do not match!").show();
            c_password.addClass("border-red-500");
            c_password = $("#c_password");
        }

        if (err === 0) {
            spinner.toggleClass("hidden");

            $.post("{{route('user.password.update')}}", {
                password: password.val(),
                _token: "{{csrf_token()}}",
            })
                .done(function (response) {
                    spinner.toggleClass("hidden");
                    popAlert("success");
                    clog(response);
                })
                .fail();
        }

        console.log(password.val());
    });
</script>
@endsection
