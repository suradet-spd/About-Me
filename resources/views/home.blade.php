@php
    // Define variable
    $show_register = true;
    $show_login = true;
@endphp
@extends('layouts.main-master')

@section('GetTitleName')
    Generate profile [home]
@endsection

@section('GetStyle')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body{
            background: linear-gradient( -500deg, rgb(244, 223, 204), rgb(250, 149, 131), rgb(47, 65, 89), rgb(64, 151, 170) );
            background-size: 800% 800%;
            animation: gradient 20s ease infinite;
        }
        .animate-bg{
            background: linear-gradient( -500deg, rgb(196, 178, 163), rgb(202, 120, 105), rgb(70, 97, 133), rgb(53, 125, 141) );
            background-size: 800% 800%;
            animation: gradient 20s ease infinite;
        }

        .set-center {
            margin: 0;
            position: absolute;
            align-items: center;
            text-align: center;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

    </style>
@endsection

@section('GetBody')
    <div id="app">
        {{-- Menu Zone --}}
        <nav class="navbar navbar-expand-md navbar-light shadow-sm animate-bg">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    <h4>Generate Profile</h4>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    {{-- <a class="nav-link text-white" href="{{ route('login') }}"><h5>{{ __('Login') }}</h5></a> --}}
                                    <a id="LoginBTN" class="nav-link text-white" style="cursor: pointer" data-toggle="modal" data-target="#md_login">
                                        <h5>
                                            <b>Login</b>
                                        </h5>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a id="RegisterBTN" class="nav-link text-white" style="cursor: pointer" data-toggle="modal" data-target="#md_register">
                                    <h5>
                                        <b>register</b>
                                    </h5>
                                </a>
                            </li>
                        @else
                            @if (Auth::user()->gen_profile_flag == "N")
                                <li class="nav-item">
                                    <a href="{{ route('your.profile' , 'create') }}" target="_blank" class="nav-link text-white" style="cursor: pointer">
                                        <h5>
                                            <b>Create your profile</b>
                                        </h5>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-white" style="cursor: pointer">
                                        <h5>
                                            <b>Your profile</b>
                                        </h5>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link text-white" style="cursor: pointer">
                                        <h5>
                                            <b>Manage your profile</b>
                                        </h5>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item dropdown">
                                <h5>
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <b>{{ Auth::user()->name_en }}</b>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </h5>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        {{-- Menu Zone --}}

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            {{-- Show Image promote --}}
                            <div id="demo" class="carousel slide" data-ride="carousel">

                                <!-- Indicators -->
                                <ul class="carousel-indicators">
                                  <li data-target="#demo" data-slide-to="0" class="active"></li>
                                  <li data-target="#demo" data-slide-to="1"></li>
                                  <li data-target="#demo" data-slide-to="2"></li>
                                </ul>

                                <!-- The slideshow -->
                                <div class="carousel-inner">
                                  <div class="carousel-item active">
                                    <img src="{{ asset('assets/PromoteImg/pic1.jpg') }}" style="width: 100%;height: 400px;" alt="Pic1">
                                  </div>
                                  <div class="carousel-item">
                                    <img src="{{ asset('assets/PromoteImg/pic2.jpg') }}" style="width: 100%;height: 400px;" alt="Pic2">
                                  </div>
                                  <div class="carousel-item">
                                    <img src="{{ asset('assets/PromoteImg/pic3.jpg') }}" style="width: 100%;height: 400px;" alt="Pic3">
                                  </div>
                                </div>

                                <!-- Left and right controls -->
                                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                  <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#demo" data-slide="next">
                                  <span class="carousel-control-next-icon"></span>
                                </a>

                            </div>
                            {{-- Show Image promote --}}
                        </div>
                        <br><br>
                        <div class="container">
                            <div class="col-12 set-center">
                                {{-- <div class="row">
                                    <div class="col">
                                        <button class="btn-lg btn-primary">Test2</button>
                                    </div>
                                    <div class="col">
                                        <button class="btn-lg btn-primary">Test2</button>
                                    </div>
                                    <div class="col">
                                        <button class="btn-lg btn-primary">Test2</button>
                                    </div>
                                </div> --}}
                                <button class="btn-lg btn-primary">
                                    ตัวอย่างผลงาน
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('LoginModal')
<!-- The Modal -->
<div class="modal fade" id="md_login">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Login form</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form method="POST" action="{{ route('login') }}" id="Login_Form">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="SubmitForm('login' , 'Login_Form');">{{ __('register') }}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

    </div>
    </div>
</div>
@endsection

@section('RegisterModal')
<!-- The Modal -->
<div class="modal fade" id="md_register">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Register form</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
        <form action="{{ route('submit-register') }}" id="Regist_Form" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <label for="profile_img" class="col-md-4 col-form-label text-md-right">{{ __('Profile image') }}</label>

                <div class="col-md-6">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input @error('profile_img') is-invalid @enderror" id="profile_img_id" name="profile_img" value="{{ old('profile_img') }}" required autocomplete="profile_img" autofocus>
                        <label class="custom-file-label" for="profile_img">Choose file</label>
                    </div>
                    <p style="color: red">เฉพาะไฟล์ jpeg , jpg , png ขนาดไม่เกิน 10 MB เท่านั้น</p>
                    @error('profile_img')
                        <script>
                            swal("Your name can't verify !" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('Nickname') }}</label>

                <div class="col-md-6">
                    <input id="nickname_id" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>

                    @error('nickname')
                        <script>
                            swal("Your nickname can't verify !" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="name_th" class="col-md-4 col-form-label text-md-right">{{ __('Name (thai)') }}</label>

                <div class="col-md-6">
                    <input id="name_th_id" type="text" class="form-control @error('name_th') is-invalid @enderror" name="name_th" value="{{ old('name_th') }}" required autocomplete="name_th" autofocus>

                    @error('name_th')
                        <script>
                            swal("Your name can't verify !" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ __('Name (eng)') }}</label>

                <div class="col-md-6">
                    <input id="name_en_id" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en" autofocus>

                    @error('name_en')
                        <script>
                            swal("Your name can't verify !" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <script>
                            swal("Email can't verify !" , "{{ $message }}" , 'error');
                        </script>
                    @enderror

                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <script>
                            swal("Your password can't verify !" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
        </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="SubmitForm('register' , 'Regist_Form');">{{ __('register') }}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

    </div>
    </div>
</div>
@endsection

@section('AnotherLink')

@endsection

@section('FunctionJs')
<script>
    $(document).ready(function() {
        $("#RegisterBTN").click(function() {
            $("#md_register").modal({
                backdrop: "static"
            }, 'show');
        });
        $("#LoginBTN").click(function() {
            $("#md_login").modal({
                backdrop: "static"
            }, 'show');
        });
    });

    function SubmitForm(FunctionType , FormID) {
        if (FunctionType == 'login') {
                document.getElementById(FormID).submit();
        } else {
            swal({
                title: "Are you sure to submit form?",
                text: "you submitting form for this site!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    document.getElementById(FormID).submit();
                }
            });
        }
    }

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    // Show image name
</script>
@endsection
