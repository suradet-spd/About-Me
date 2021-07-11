@php
    // Define variable
    $show_register = true;
    $show_login = true;
    $lang = Config::get('app.locale');;
@endphp
@extends('layouts.main-master')

@section('GetTitleName')
    {{-- Generate profile [home] --}}
    {{ trans('home.TitleTab') }}
@endsection

@section('AnotherLink')

@endsection

@section('GetStyle')
    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @php
            $backgroundType = ($system["background_color"] == null) ? null : $system["background_color"]->background_type;
            $bg_primary = ($system["background_color"] == null) ? "#00000" : (($system["background_color"]->primary_color == null) ? "#FFFFF" : $system["background_color"]->primary_color);
            $bg_secondary = ($system["background_color"] == null ) ? "#FFFFF" : (($system["background_color"]->secondary_color == null) ? "#FFFFF" : $system["background_color"]->secondary_color);

            $fontColor = ($system["font_color"] == null) ? "#FFFFF" : (($system["font_color"]->font_color == null) ? "#FFFFF" : $system["font_color"]->font_color);

            $btn_color = ($system["button_color"] == null) ? "btn-outline-dark" : (($system["button_color"]->button_color == null) ? "btn-outline-light" : $system["button_color"]->button_color);
            $account = array(
                "line" => ($system["account_detail"] == null ) ? null : (($system["account_detail"]->LineAccount == null) ? null : $system["account_detail"]->LineAccount),
                "mail" => ($system["account_detail"] == null) ? null : (($system["account_detail"]->MailAccount == null) ? null : $system["account_detail"]->MailAccount)
            );
        @endphp
        @if ($backgroundType == "G")
            <style>
                body{
                    background: linear-gradient( -500deg, {{ $bg_secondary }}, {{ $bg_primary }} , {{ $bg_primary }} , {{ $bg_secondary }} );
                    background-size: 800% 800%;
                    animation: gradient 20s ease infinite;
                    color: {{ $fontColor }};
                }
                .animate-bg{
                    background: linear-gradient( -500deg, {{ $bg_secondary }}, {{ $bg_primary }} , {{ $bg_primary }} , {{ $bg_secondary }} );
                    background-size: 800% 800%;
                    animation: gradient 20s ease infinite;
                }

                .footer {
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    background: linear-gradient( -500deg, {{ $bg_secondary }}, {{ $bg_primary }} , {{ $bg_primary }} , {{ $bg_secondary }} );
                    background-size: 800% 800%;
                    animation: gradient 20s ease infinite;
                    text-align: center;
                    color: {{ $fontColor }};

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
        @else
            <style>
                body{
                    background-color: {{ $bg_primary }};
                    color: {{ $fontColor }};
                }
                .footer {
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    color: {{ $fontColor }};
                    text-align: center;
                    background-color: {{ $bg_primary }};
                }
            </style>
        @endif

    <style>
        .set-center {
            margin: 0;
            position: absolute;
            align-items: center;
            text-align: center;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>
@endsection

@section('GetBody')
    <div id="app">
        {{-- Menu Zone --}}
        <nav class="navbar navbar-expand-md navbar-light shadow-sm animate-bg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="color: {{ $fontColor }}">
                    <h4>{{ trans('home.LogoName') }}</h4>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    {{-- Right Side Of Navbar --}}
                    <ul class="navbar-nav ml-auto">
                        {{-- Authentication Links --}}

                        @guest
                            @if (Route::has('login'))

                                <li class="nav-item">

                                    <a id="LoginBTN" class="nav-link text-white" style="cursor: pointer" data-toggle="modal" data-target="#md_login">
                                        <button class="btn {{ $btn_color }}">
                                            <i class="fas fa-sign-in-alt"></i> {{ trans('home.LoginMenu') }}
                                        </button>
                                    </a>

                                </li>

                            @endif
                            <li class="nav-item">
                                <a id="RegisterBTN" class="nav-link text-white" style="cursor: pointer" data-toggle="modal" data-target="#md_register">
                                    <button class="btn {{ $btn_color }}">
                                        <i class="fas fa-user-plus"></i> {{ trans('home.RegisterMenu') }}
                                    </button>
                                </a>
                            </li>
                        @else
                            @if (Auth::user()->admin_flag == "Y")
                                <li class="nav-item dropdown">
                                    <h5>
                                        <a id="AdminMenuID" class="nav-link text-white" style="cursor: pointer" data-toggle="modal" data-target="#md_adminmenu">
                                            <button class="btn {{ $btn_color }}">
                                                <i class="fas fa-tools"></i> {{ trans('home.AdminMenu') }}
                                            </button>
                                        </a>
                                    </h5>
                                </li>
                                {{-- <a href="#" class="nav-link text-white"><b><h3>|</h3></b></a> --}}
                            @endif

                            @if (Auth::user()->gen_profile_flag == "N")
                                <li class="nav-item">
                                    <a href="{{ route('MyProfile' , 'about') }}" target="_blank" class="nav-link text-white" style="cursor: pointer">
                                        <button class="btn {{ $btn_color }}">
                                            <i class="fas fa-plus-square"></i> {{ trans('home.CreateMenu') }}
                                        </button>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('MyProfile' , 'about') }}" class="nav-link text-white" style="cursor: pointer">
                                        <button class="btn {{ $btn_color }}">
                                            <i class="far fa-user"></i> {{ trans('home.ViewMenu') }}
                                        </button>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <h5>
                                    <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <button class="btn {{ $btn_color }}">
                                            <i class="fas fa-sign-out-alt"></i> {{ trans('home.LogoutMenu') }}
                                        </button>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </h5>
                            </li>
                        @endguest

                        <li class="nav-item">

                            @if ($lang == "en")
                                <a href="{{ url('change' , 'th') }}" class="nav-link text-white" style="cursor: pointer">
                                    <button class="btn {{ $btn_color }}">
                                        <i class="fas fa-globe-asia"></i> TH
                                    </button>
                                </a>
                            @else
                                <a href="{{ url('change' , 'en') }}" class="nav-link text-white" style="cursor: pointer">
                                    <button class="btn {{ $btn_color }}">
                                        <i class="fas fa-globe-americas"></i> EN
                                    </button>
                                </a>

                            @endif

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
                    <div class="container mx-auto text-center">
                        <p><h1 class="display-4" style="color: {{ $fontColor }}">{{ trans('home.PromoteTextHead') }}</h1></p>
                    </div>

                    <form action="{{ route('search.profile') }}" id="SerchNameId" method="POST">
                        @csrf
                        <div class="form-group">
                            <input class="form-control input-lg" id="SearchTXT_id" name="SearchTXT" type="text" placeholder="{{ trans('home.PlaceHolderText') }}">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </form>

                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <button class="btn {{ $btn_color }}" onclick="Javascript:submitSearchForm()">
                                    <i class="fas fa-search"></i> {{ trans('home.SearchButton') }}
                                </button>
                                <button class="btn {{ $btn_color }}" onclick="Javascript:ResetText()">
                                    <i class="fas fa-eraser"></i> {{ trans('home.ResetButton') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('OtherModal')
    @if (isset($list_profile))
        {{-- Search profile Modal --}}
        <div class="modal fade" id="Md_SearchProfile">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">

                {{-- Modal Header --}}
                <div class="modal-header">
                <h4 class="modal-title">{{ trans('home.view_md_header_search') }}</h4>
                </div>

                {{-- Modal body --}}
                <div class="modal-body">
                    <div class="table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>
                                        <h5><b>{{ trans('home.view_md_tab_search1') }}</b></h5>
                                    </th>
                                    <th>
                                        <h5><b>{{ trans('home.view_md_tab_search2') }}</b></h5>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_profile as $lp)
                                    <tr>
                                        <td>
                                            <h5>{{ ($lang == "th") ? $lp->name_th : $lp->name_en }} ({{ $lp->nickname }})</h5>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('ViewProfile' , ["user_name" => str_replace(' ' , '.' , $lp->name_en) , "type" => "about"]) }}"><i class="fas fa-search fa-2x" style="color: rgb(16, 32, 119);cursor: pointer;"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Modal footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
            </div>
        </div>
    @endif

    @auth
        @if (Auth::user()->admin_flag == "Y")
            <!-- The Modal -->
            <div class="modal fade" id="md_adminmenu">
                <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">{{ trans('home.home_md_config_header') }}</h4>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="container">
                            <div class="col col-sm-12">
                                <form id="AdminConfig" action="{{ route('systemConfig') }}" method="POST">
                                    @csrf
                                    <label for="modify" class="col-form-label">{{ trans('home.md_config_type_label') }}</label>
                                    <select name="modify" id="modifyID" class="custom-select mb-3" onchange="SwitchRender();">
                                        <option value="" selected>{{ trans('home.md_config_type_default') }}</option>
                                        <option value="BG">{{ trans('home.md_config_type_1') }}</option>
                                        <option value="FC">{{ trans('home.md_config_type_2') }}</option>
                                        <option value="BC">{{ trans('home.md_config_type_3') }}</option>
                                        <option value="AD">{{ trans('home.md_config_type_4') }}</option>
                                    </select>

                                    <hr width="95%">

                                    <div id="RenderBackgroundColorID" hidden>
                                        <div class="form-group">
                                            <label for="SetBackgroundType" class="col-form-label text-md-left">{{ trans('background.LabelColorType') }}</label>
                                                <select name="SetBackgroundType" id="SetBackgroundTypeID" class="custom-select" onchange="fnc_setbackground()">
                                                    <option value="" selected="" disabled>{{ trans('background.SelectLabelDefault') }}</option>
                                                    <option value="G">{{ trans('background.GardientLabel') }}</option>
                                                    <option value="C">{{ trans('background.CommonLabel') }}</option>
                                                </select>

                                                @error('SetBackgroundType')
                                                    <script>
                                                        swal("{{ trans('background.header_error') }}" , "{{ $message }}" , 'error');
                                                    </script>
                                                @enderror
                                        </div>

                                        <div id="backgroundColorDet"></div>
                                    </div>

                                    <div id="RenderFontColorID" hidden>
                                        <div class="form-group">
                                            <label for="SetFontColor" class="col-form-label text-md-left">{{ trans('home.md_config_font_color') }}</label>
                                            <input type="color" class="form-control" name="SetFontColor" id="SetFontColorID" value="{{ $fontColor }}">
                                        </div>
                                    </div>

                                    <div id="RenderButtonColorID" hidden>
                                        <div class="form-group">
                                            <label for="SetButtonColor" class="col-form-label text-md-left">{{ trans('home.md_config_btn_color') }}</label>
                                            <select name="SetButtonColor" id="SetButtonColorID" class="custom-select" onchange="SetButtonColorExam()">
                                                <option value="" selected disabled>{{ trans('home.md_config_btn_default') }}</option>
                                                <option value="btn-primary">Primary Button</option>
                                                <option value="btn-secondary">Secondary Button</option>
                                                <option value="btn-success">Success Button</option>
                                                <option value="btn-info">Info Button</option>
                                                <option value="btn-warning">Warning Button</option>
                                                <option value="btn-danger">Danger Button</option>
                                                <option value="btn-dark">Dark Button</option>
                                                <option value="btn-light">Light Button</option>

                                                <option value="btn-outline-primary">Primary Outline Button</option>
                                                <option value="btn-outline-secondary">Secondary Outline Button</option>
                                                <option value="btn-outline-success">Success Outline Button</option>
                                                <option value="btn-outline-info">Info Outline Button</option>
                                                <option value="btn-outline-warning">Warning Outline Button</option>
                                                <option value="btn-outline-danger">Danger Outline Button</option>
                                                <option value="btn-outline-dark">Dark Outline Button</option>
                                                <option value="btn-outline-light">Light Outline Button</option>
                                            </select>
                                        </div>
                                        <div id="ExampleButton"></div>
                                    </div>

                                    <div id="RenderAccountDetailID" hidden>
                                        <div class="form-group">
                                            <label for="SetLineAccount" class="col-form-label text-md-left">{{ trans('home.md_line_acc') }}</label>
                                            <input type="text" class="form-control" name="SetLineAccount" id="SetLineAccountID" placeholder="Ex : @LineAccount" value="{{ $account["line"] }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="SetMailAccount" class="col-form-label text-md-left">{{ trans('home.md_mail_acc') }}</label>
                                            <input type="email" class="form-control" name="SetMailAccount" id="SetMailAccountID" placeholder="Ex : AdminEmail@loocal.com" value="{{ $account["mail"] }}">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="submitConfig()">{{ trans('home.md_config_confirm') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('home.md_config_cancel') }}</button>
                    </div>

                </div>
                </div>
            </div>
        @endif
    @endauth
@endsection



@section('LoginModal')
{{-- The Modal --}}
<div class="modal fade" id="md_login">
    <div class="modal-dialog">
    <div class="modal-content">

        {{-- Modal Header --}}
        <div class="modal-header">
        <h4 class="modal-title">{{ trans('login.LoginModalHeader') }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        {{-- Modal body --}}
        <div class="modal-body">
            <form method="POST" action="{{ route('login') }}" id="Login_Form">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('login.EmailUser') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <script>
                                swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                            </script>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('login.PasswordUser') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <script>
                                swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                            </script>
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
            </form>
        </div>

        {{-- Modal footer --}}
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="SubmitForm('login' , 'Login_Form');">{{ trans('login.LoginButton') }}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('login.CloseLoginButton') }}</button>
        </div>

    </div>
    </div>
</div>
@endsection

@section('RegisterModal')
{{-- The Modal --}}
<div class="modal fade" id="md_register">
    <div class="modal-dialog">
    <div class="modal-content">

        {{-- Modal Header --}}
        <div class="modal-header">
        <h4 class="modal-title">{{ trans('register.RegisterModalHeader') }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        {{-- Modal body --}}
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

            <div class="form-group row">
                <label for="regist_telephone" class="col-md-4 col-form-label text-md-right">{{ trans('register.UserTelephone') }}</label>

                <div class="col-md-6">
                    <input id="regist_telephone" type="tel" class="form-control @error('regist_telephone') is-invalid @enderror" name="regist_telephone" value="{{ old('regist_telephone') }}" required autocomplete="regist_telephone">

                    @error('regist_telephone')
                        <script>
                            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
                        </script>
                    @enderror
                </div>
            </div>

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

        {{-- Modal footer --}}
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="SubmitForm('register' , 'Regist_Form');">{{ trans('register.RegisterButton') }}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('register.CancelButton') }}</button>
        </div>

    </div>
    </div>
</div>
@endsection

@section('class-footer')
    <br>
    <div class="container">
        <div class="col-md-12 align-items-center">
            <center>
                <div class="col-md-8">
                    <h5>ABOUT US</h5>
                    {{-- <div class="col-sm-12">
                        <button class="btn {{ $btn_color }}"><i class="fas fa-book"></i> {{ trans('home.btn_usermanual') }}</button>
                        <button class="btn {{ $btn_color }}"><i class="fas fa-bug"></i> {{ trans('home.btn_reportbug') }}</button>
                    </div> --}}
                    <hr width="50%">
                    <h6>{{ trans('home.credit-text') }}</h6>
                    <h6>
                        @if ($account["mail"] != null )
                            <i class="fas fa-envelope-open-text fa-2x"></i> : <a href="mailto:{{ $account["mail"] }}">{{ $account["mail"] }} </a>
                        @endif

                        @if ($account["line"] != null )
                            <i class="fab fa-line fa-2x"></i> : {{ $account["line"] }}
                        @endif

                    </h6>
                    <hr width="20%">
                    <h6>
                        <p>Copyright © {{ date('Y') }} <b>Bigfat-Dev</b> All rights reserved.</p>
                    </h6>
                </div>
            </center>
        </div>
    </div>
    <br>
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

        $("#AdminMenuID").click(function(){
            $("#md_adminmenu").modal({
                backdrop: "static"
            } , 'show');
        });


        var chk_list = "{{ isset($list_profile) }}";
        if (chk_list == 1) {
            $("#Md_SearchProfile").modal({
                backdrop: "static"
            }, 'show');
        }
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

    function submitSearchForm() {
        var formMast = document.getElementById('SerchNameId');
        const text_chk = formMast.elements["SearchTXT"].value;
        if (text_chk == null || text_chk == "") {
            swal("{{ trans('home.Error_msg_header') }}" , "Please input some profile name" , 'error');
        } else if (text_chk.length < 5) {
            swal("{{ trans('home.Error_msg_header') }}" , "Minimum character is 5 character!" , 'error');
        } else {
            formMast.submit();
        }
    }

    function ResetText() {
        document.getElementById('SearchTXT_id').value = "";
        document.getElementById('SearchTXT_id').focus();


    }

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    // Show image name

    function fnc_setbackground() {
        const tmpHtml = '<div class="form-group">||</div>';
        const mast = document.getElementById("SetBackgroundTypeID").value;
        const color = {
            "Primary": (mast == "" || mast == null) ? null : '<label for="PrimaryColor" class="col-form-label text-md-left">Primary Color : </label><input type="color" class="form-control" name="PrimaryColor" id="PrimaryColorID" value="{{ $bg_primary }}">',
            "Secondary": (mast == "C" || mast == "" || mast == null) ? null : '<label for="SecondaryColor" class="col-form-label text-md-left">Secondary Color : </label><input type="color" class="form-control" name="SecondaryColor" id="SecondaryColorID" value="{{ $bg_secondary }}">',
        }
        document.getElementById("backgroundColorDet").innerHTML = "".concat((color["Primary"] == null) ? "" : tmpHtml.replace("||" , color["Primary"]) , (color["Secondary"] == null) ? "" : tmpHtml.replace("||" , color["Secondary"]));
    }

    function DivHiddenID(DivValue , returnType) {
        // returnType ["code" , "id" , "prop"]

        var ConfigCode = ["BG","FC","BC","AD"];

        var ConfigDivID = {
            "BG" : "RenderBackgroundColorID",
            "FC" : "RenderFontColorID",
            "BC" : "RenderButtonColorID",
            "AD" : "RenderAccountDetailID"
        };

        const tmp = document.getElementById("SetBackgroundTypeID").value;
        var ConfigDivProp = {
            "BG" : [((tmp == "" || tmp == null) ? null : "SetBackgroundTypeID") , ((tmp == 'G' || tmp == 'C') ? "PrimaryColorID" : null) , ((tmp == 'G') ? "SecondaryColorID" : null)],
            "FC" : ["SetFontColorID"],
            "BC" : ["SetButtonColorID"],
            "AD" : ["SetLineAccountID" , "SetMailAccountID"]
        }
        return (returnType == "code") ? ConfigCode : ((returnType == "id" && (DivValue != null || DivValue != "")) ? ConfigDivID[DivValue] : ((returnType == "prop" && (DivValue != null || DivValue != "")) ? ConfigDivProp[DivValue] : null))};

    function SwitchRender() {

        const Master = document.getElementById("modifyID").value;
        var tmpArr = DivHiddenID(null , 'code');

        if (Master != "" || Master != null) {
            tmpArr.forEach(element => {
                if (element == Master) {
                    document.getElementById(DivHiddenID(element , 'id')).hidden = false;
                } else {
                    document.getElementById(DivHiddenID(element , 'id')).hidden = true;
                }
            });
        }
    }

    function swAlert(Message , RefreshPage) {
        if (RefreshPage == false) {
            swal("{{ trans('background.header_error') }}" , Message , 'error');
        } else {
            swal({
                title: "{{ trans('background.header_error') }}",
                text: Message,
                icon: "warning",
                buttons: true,
            }).then((willTry) => {
                if (willTry) {
                    window.location.href = "";
                }
            });
        }
    }

    function chkInput(divID) {
        var ArrChk = DivHiddenID(null , 'code');
        var res = true;
        var value = {
            "BG" : null,
            "FC" : null,
            "BC" : null,
            "AD" : null
        };

        ArrChk.forEach(element => {
            const tmp_check = document.getElementById(DivHiddenID(element , 'id')).hidden;
            value[element] = (divID == element) ? ((tmp_check == false) ? true : false) : ((tmp_check == true) ? true : false);
        });
        // Assign value

        Object.keys(value).forEach(function (vl) {
            if (value[vl] == false) {
                res = false;

            }
        });

        return res;
        // return value

    }

    function SetButtonColorExam() {
        const tmpData = document.getElementById('SetButtonColorID').value;

        if (tmpData != "" && tmpData != null) {
            const tmpHtml = '<label class="col-form-label text-md-left"><b>Example Button : </b><a class="btn ButtonCode">Example</a></label>';

            document.getElementById("ExampleButton").innerHTML = tmpHtml.replace("ButtonCode",tmpData);
        }
    }

    function submitConfig() {
        var FormID = document.getElementById("AdminConfig");
        var GetSelectType = FormID.elements["modify"].value ;
        var ChkDivEnable = chkInput(GetSelectType);

        if (GetSelectType == null || GetSelectType == "") {
            swAlert("Please select config type!" , false);
        } else {

            if (!ChkDivEnable) {
                swAlert("Your form is invalid. Click OK to try again" , true);
            } else {
                const id_div = DivHiddenID(GetSelectType , 'id');
                const property_div = DivHiddenID(GetSelectType , 'prop');
                var res = false;
                var chk_val = [];
                property_div.forEach(pd => {
                    if (pd == null || pd == "") {
                        chk_val.push(true);
                    } else {
                        if (document.getElementById(pd).value == "" || document.getElementById(pd).value == null) {
                            chk_val.push(false);
                        } else {
                            chk_val.push(true);
                        }
                    }
                });

                chk_val.forEach(cv => {
                    if (cv == false) {
                        res = false;
                        return;
                    } else {
                        res = true;
                    }
                });

                if (!res) {
                    swAlert("pls enter value before submit form!" , false);
                } else {
                    FormID.submit();
                }
            }
        }

    }

</script>
@endsection
