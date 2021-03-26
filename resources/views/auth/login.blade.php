<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .login-accent {
            width: 10em;
            height: 10em;
            top: -2.5em;
            left: -2.5em;
        }

        .widen {
            width: 150%;
            height: 150%;
            top: -30%;
            left: -30%;
        }

        @media (min-width: 768px) {
            .login-accent {
                width: 12em;
                height: 12em;
                top: -2.5em;
                left: -2.5em;
            }

            .widen {
                width: 150%;
                height: 200%;
                top: -30%;
                left: -30%;
            }
        }
    </style>
    <title>Login to Chatonym</title>
</head>

<body>
    <div class="relative flex items-center justify-center p-3 h-screen w-full">
        <div class="login-accent duration-300 transiiton-all  absolute rounded-full bg-cha-primary">
        </div>
        <div class="absolute top-4 left-2 text-white">
            Chatonym.
        </div>
        <div class="w-full md:w-1/3 mb-24 md:mb-64 p-3 login-container z-10">
            <form action="{{route('login')}}" method="post" class="form">
                @if(session()->has('error'))
                <div class="bg-red-300 text-red-800 rounded text-xs p-3 border-l-4 border-red-800">
                    {{session('error')}}
                </div>
                @endif
                <div class="form-group flex space-y-1 flex-col my-5 items-start">
                    <!-- <label for="" class="md:pr-8 md:w-1/3">Username</label> -->
                    <input type="text" name="username" class="input border-0 rounded-full px-5 bg-cha-secondary w-full @error('username') border border-red-500 @enderror" id="username" placeholder="Username" required @error('username') value="{{ old('username') }}" @enderror />

                    @error('username')
                    <span class="text-red-500 font-medium px-4 text-xs" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group flex space-y-1 flex-col my-5 items-start">
                    <!-- <label for="" class="md:pr-8 md:w-1/3">Password</label> -->
                    <input type="password" name="password" class="input border-0 rounded-full px-5 bg-cha-secondary w-full @error('password') border border-red-500 @enderror" id="password" placeholder="Password" required />
                    @error('password')
                    <span class="text-red-500 font-medium px-4 text-xs" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group flex space-y-1 flex-col my-5 items-start">
                    <button class="input cta-btn tracking-widest rounded-full bg-cha-primary text-center text-white p-2 w-full">LOGIN</button>
                </div>

                <div class="sub-cta text-cha-primary text-xs text-center">
                    <a href="{{route('register')}}">Create an account</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        var shouldAnimate = true;
        $('.form').bind('focusin', function() {
            if (shouldAnimate) {
                $('.login-accent').addClass('widen')
                // $('.login-accent').addClass('w-large-2500').addClass('h-large-2500')
                $('.cta-btn, .sub-cta').toggleClass('bg-cha-primary').toggleClass('bg-white').toggleClass('text-white').toggleClass('text-cha-primary')
            }
            shouldAnimate = false
        })


        $(document).mouseup(function(e) {
            // console.log(palette_selector.has(e.target));
            // if the target of the click isn't the container nor a descendant of the container
            if (
                !$('.form').is(e.target) &&
                $('.form').has(e.target).length === 0
            ) {
                if (!shouldAnimate) {
                    $('.login-accent').removeClass('widen')
                    $('.cta-btn, .sub-cta').toggleClass('bg-cha-primary').toggleClass('bg-white').toggleClass('text-white').toggleClass('text-cha-primary')
                    shouldAnimate = true;
                }
            }
        });
    </script>
</body>

</html>