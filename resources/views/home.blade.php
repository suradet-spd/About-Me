@php
    // Define variable
    $show_register = true;
    $show_login = true;
@endphp
@extends('layouts.main-master')

@section('GetTitleName')
    {{-- Generate profile [home] --}}
    {{ trans('home.TitleTab') }}
@endsection

@section('AnotherLink')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            background: linear-gradient( -500deg, rgb(34, 36, 70), rgb(38,40,92), rgb(77,80,152), rgb(117,120,205) );
            background-size: 800% 800%;
            animation: gradient 20s ease infinite;
        }
        .animate-bg{
            background: linear-gradient( -500deg, rgb(34, 36, 70), rgb(38,40,92), rgb(77,80,152), rgb(117,120,205) );
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
                    <h4>{{ trans('home.LogoName') }}</h4>
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
                                            <b>{{ trans('home.LoginMenu') }}</b>
                                        </h5>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a id="RegisterBTN" class="nav-link text-white" style="cursor: pointer" data-toggle="modal" data-target="#md_register">
                                    <h5>
                                        <b>{{ trans('home.RegisterMenu') }}</b>
                                    </h5>
                                </a>
                            </li>
                        @else
                            @if (Auth::user()->gen_profile_flag == "N")
                                <li class="nav-item">
                                    <a href="{{ route('MyProfile' , 'about') }}" target="_blank" class="nav-link text-white" style="cursor: pointer">
                                        <h5>
                                            <b>{{ trans('home.CreateMenu') }}</b>
                                        </h5>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-white" style="cursor: pointer">
                                        <h5>
                                            <b>{{ trans('home.ViewMenu') }}</b>
                                        </h5>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <h5>
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <b>
                                            @if (Config::get('app.locale') == "th")
                                                {{ Auth::user()->name_th }}
                                            @else
                                                {{ Auth::user()->name_en }}
                                            @endif
                                        </b>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ trans('home.LogoutMenu') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>

                                </h5>

                            </li>
                        @endguest

                        <li class="nav-item dropdown">
                            <h5>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <b>
                                        @if (Config::get('app.locale') == "th")
                                            ไทย
                                        @else
                                            {{ strtoupper(Config::get('app.locale')) }}
                                        @endif
                                    </b>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Config::get('app.locale') == "en")
                                        <a class="dropdown-item" href="{{ url('change' , 'th') }}">
                                            ไทย
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ url('change' , 'en') }}">
                                            EN
                                        </a>
                                    @endif
                                </div>
                            </h5>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {{-- Menu Zone --}}

        <main class="py-4">
            <div class="container">
                <div class="col-md-8 mx-auto mb-5">
                    <br>
                    <div class="container mx-auto text-white text-center">
                        <p><h1 class="display-4">{{ trans('home.PromoteTextHead') }}</h1></p>
                    </div>
                    <form action="">
                        <div class="form-group">
                            <input class="form-control input-lg" id="SearchTXT_id" name="SearchTXT" type="text" placeholder="{{ trans('home.PlaceHolderText') }}">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </form>
                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <button class="btn btn-secondary">{{ trans('home.SearchButton') }}</button>
                                <button class="btn btn-secondary">{{ trans('home.ResetButton') }}</button>
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
        <h4 class="modal-title">{{ trans('login.LoginModalHeader') }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form method="POST" action="{{ route('login') }}" id="Login_Form">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('login.EmailUser') }}</label>

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
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('login.PasswordUser') }}</label>

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
                                {{ trans('login.RememberButton') }}
                            </label>
                        </div>
                    </div>
                </div>

                {{-- <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div> --}}
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="SubmitForm('login' , 'Login_Form');">{{ trans('login.LoginButton') }}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('login.CloseLoginButton') }}</button>
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
        <h4 class="modal-title">{{ trans('register.RegisterModalHeader') }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
        <form action="{{ route('submit-register') }}" id="Regist_Form" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <label for="profile_img" class="col-md-4 col-form-label text-md-right">{{ trans('register.ImageUser') }}</label>

                <div class="col-md-6">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input @error('regist_profile_img') is-invalid @enderror" id="regist_profile_img_id" name="regist_profile_img" value="{{ old('regist_profile_img') }}" required autocomplete="regist_profile_img" autofocus>
                        <label class="custom-file-label" for="regist_profile_img">{{ trans('register.ImageDesc') }}</label>
                    </div>
                    <p style="color: red">{{ trans('register.ImageRemark') }}</p>
                    @error('regist_profile_img')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="regist_nickname" class="col-md-4 col-form-label text-md-right">{{ trans('register.NicknameUser') }}</label>

                <div class="col-md-6">
                    <input id="regist_nickname_id" type="text" class="form-control @error('regist_nickname') is-invalid @enderror" name="regist_nickname" value="{{ old('regist_nickname') }}" required autocomplete="regist_nickname" autofocus>

                    @error('regist_nickname')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="regist_name_th" class="col-md-4 col-form-label text-md-right">{{ trans('register.UserNameTH') }}</label>

                <div class="col-md-6">
                    <input id="regist_name_th_id" type="text" class="form-control @error('regist_name_th') is-invalid @enderror" name="regist_name_th" value="{{ old('regist_name_th') }}" required autocomplete="regist_name_th" autofocus>

                    @error('regist_name_th')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="regist_name_en" class="col-md-4 col-form-label text-md-right">{{ trans('register.UserNameEN') }}</label>

                <div class="col-md-6">
                    <input id="regist_name_en_id" type="text" class="form-control @error('regist_name_en') is-invalid @enderror" name="regist_name_en" value="{{ old('regist_name_en') }}" required autocomplete="regist_name_en" autofocus>

                    @error('regist_name_en')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="regist_email" class="col-md-4 col-form-label text-md-right">{{ trans('register.UserEmail') }}</label>

                <div class="col-md-6">
                    <input id="regist_email" type="email" class="form-control @error('regist_email') is-invalid @enderror" name="regist_email" value="{{ old('regist_email') }}" required autocomplete="regist_email">

                    @error('regist_email')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror

                </div>
            </div>

            {{-- <div class="form-group row">
                <label for="regist_address" class="col-md-4 col-form-label text-md-right">{{ trans('register.Address') }}</label>

                <div class="col-md-6">
                    <input id="regist_address" type="text" class="form-control @error('regist_address') is-invalid @enderror" name="regist_address" value="{{ old('regist_address') }}" require autocomplete="regist_address">

                    @error('regist_address')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div> --}}


            <div class="form-group row">
                <label for="regist_password" class="col-md-4 col-form-label text-md-right">{{ trans('register.UserPassword') }}</label>

                <div class="col-md-6">
                    <input id="regist_password" type="password" class="form-control @error('regist_password') is-invalid @enderror" name="regist_password" required autocomplete="new-password">
                    @error('regist_password')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="regist_password-confirm" class="col-md-4 col-form-label text-md-right">{{ trans('register.UserConfirmPassword') }}</label>

                <div class="col-md-6">
                    <input id="regist_password-confirm" type="password" class="form-control" name="regist_password_confirmation" required autocomplete="new-password">
                </div>
            </div>
        </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="SubmitForm('register' , 'Regist_Form');">{{ trans('register.RegisterButton') }}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('register.CancelButton') }}</button>
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

        $('.class_select_2').select2();
    });

    function SubmitForm(FunctionType , FormID) {
        if (FunctionType == 'login') {
                document.getElementById(FormID).submit();
        } else {
            swal({
                title: "{{ trans('home.HeaderRegist') }}",
                text: "{{ trans('home.ConfirmRegist') }}",
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
