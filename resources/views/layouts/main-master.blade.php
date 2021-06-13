<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('GetTitleName')</title>
    {{-- Font Awesome icons (free version)--}}
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
    {{-- Using Sweet alert --}}
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    {{-- Using Jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    @yield('AnotherLink')

    @yield('GetStyle')

    <style>
        .footer {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: red;
            color: white;
            text-align: center;
        }
    </style>
</head>
    <body>
        {{-- check Error Log and show --}}
        @if (\Session::has('success'))
            <script>
                swal("สำเร็จ!", "{{ \Session::get('success') }}", "success");

            </script>
        @elseif (\Session::has('error'))
            <script>
                swal("ล้มเหลว!", "{{ \Session::get('error') }}", "error");

            </script>
        @endif
        {{-- Check success return --}}

        @yield('GetBody')

        @if ($show_register)
            @yield('RegisterModal')
        @endif

        @if ($show_login)
            @yield('LoginModal')
        @endif

        @yield('OtherModal')

        @yield('FunctionJs')

    </body>
    <footer>
        <div class="container-fluid">

        </div>
    </footer>
</html>
