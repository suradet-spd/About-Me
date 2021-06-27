@foreach ($master as $mast)
    {{-- Validate session language and language_flag --}}
    @php
        $tmp_lang = $mast["language_flag"];
        if ($tmp_lang == "T") {
            $lang = "th";
        } elseif ($tmp_lang = "E") {
            $lang = "en";
        } else {
            $lang = null;
        }

    @endphp

    @if($mast["language_flag"] != "N" && $mast["language_flag"] != "A" && ($lang != null && $lang != Config::get('app.locale')))
        <script>
            var lang = "{{ $lang }}"
            var tmp_url = "{{ url('change' , 'lang') }}";
            var url = tmp_url.replace("lang" , lang);
            window.location = url;
        </script>
    @else
        <!DOCTYPE html>
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
            <head>
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                <meta name="description" content="" />
                <meta name="author" content="" />
                <title>{{ trans('profile.TabTitle') }}</title>
                {{-- <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" /> --}}
                {{-- Font Awesome icons (free version)--}}
                <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
                {{-- Google fonts--}}
                <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
                <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
                {{-- Core theme CSS (includes Bootstrap)--}}
                <link href="{{ asset('css/template-profile/styles_type_1.css') }}" rel="stylesheet" />

                {{-- Bootstrap core JS--}}
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
                {{-- Third party plugin JS--}}
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
                {{-- Core theme JS--}}
                <script src="{{ asset('js/template-profile/scripts_type_1.js') }}"></script>

                {{-- Using Sweet alert --}}
                <script src="{{ asset('js/sweetalert.min.js') }}"></script>

                {{-- Another script link --}}

                @if ($ConfigProfile != null)
{{-- {{ dd($ConfigProfile) }} --}}
                    @if ($ConfigProfile["background"]->color_type == "C")
                        <style>
                            body{
                                background-color: {{ $ConfigProfile["background"]->background_color }};
                            }

                            .bg-primary{
                                background-color:{{ $ConfigProfile["background"]->menu_color }};
                            }
                        </style>
                    @else
                        <style>
                            body{
                                background: linear-gradient( -500deg, {{ $ConfigProfile["background"]->background_color }} , rgb(255, 255, 255) , {{ $ConfigProfile["background"]->background_color }});
                                background-size: 800% 800%;
                                animation: gradient 20s ease infinite;
                            }

                            .bg-primary{
                                background: linear-gradient( -500deg,rgb(255, 255, 255) , {{ $ConfigProfile["background"]->menu_color }} , rgb(255, 255, 255));
                                background-size: 800% 800%;
                                animation: gradient 20s ease infinite;
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
                    @endif
                    <style>
                        body ,.text-primary , .text-secondary , a , a:link{
                            color: {{ $ConfigProfile["font"]->main_color }};
                        }
                        h1,h2,h3,h4,h5,h6, .h1,.h2,.h3,.h4,.h5,.h6 , a:hover{
                            /* font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; */
                            color: {{ $ConfigProfile["font"]->sub_color }};
                        }
                        .social-icons .social-icon:hover{
                            background-color: {{ $ConfigProfile["background"]->menu_color }};
                        }

                        .footer {
                            position: absolute;
                            left: 0;
                            bottom: 0;
                            width: 100%;
                            text-align: center;
                        }

                    </style>
                @endif

            </head>
            <body id="page-top">
                @if (\Session::has('success'))
                    <script>
                        swal("{{ trans('profile.AlertSuccess') }}", "{{ Session::get('success') }}", "success");
                    </script>
                @elseif (\Session::has('error'))
                    <script>
                        swal("{{ trans('profile.AlertError') }}", "{{ Session::get('error') }}", "error");
                    </script>
                @endif
                {{-- Check success return --}}

                {{-- Navigation --}}
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
                    <a class="navbar-brand js-scroll-trigger" href="#page-top">
                        <span class="d-block d-lg-none">{{ $mast["name_en"] }}</span>
                        <span class="d-none d-lg-block">
                            <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="{{ route('GetDataImage' , ["id"=> str_pad($mast["profile_id"],5,"0",STR_PAD_LEFT) , "file_name"=> $mast["photo_name"] , "img_type" => "Profile"]) }}" />
                        </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">

                            @if ($mast["language_flag"] == "N")
                            <script>
                                $(function() {
                                    $('#SetLanguage').modal({backdrop: "static"} , 'show');
                                });
                            </script>
                                {{-- set language (create modal and this modal can't close if user close modal redirect to home) --}}
                            @else

                                @if ($modifyFlag)
                                    <hr width="95%">
                                    @if (Auth::user()->gen_profile_flag == "N" or Auth::user()->gen_profile_flag == null)
                                        <li class="nav-item">
                                            <a class="nav-link js-scroll-trigger" style="cursor: pointer" id="BtnPublic" onclick="Javascript:PublicProfile('{{ str_pad($mast["profile_id"],5,"0",STR_PAD_LEFT) }}')">{{ trans('profile.PublicProfile') }}</a>
                                        </li>
                                    @endif
                                    <li class="nav-item"><a class="nav-link js-scroll-trigger" style="cursor: pointer" id="BtnReset" onclick="Javascript:ResetProfile();" >{{ trans('profile.ResetProfile') }}</a></li>
                                    <li class="nav-item"><a class="nav-link js-scroll-trigger" style="cursor: pointer" id="BtnCustomBackground" data-toggle="modal" data-target="#SetBackground">{{ trans('profile.MenuCustomBG') }}</a></li>
                                @endif
                            <hr width="95%">
                            <li class="nav-item" disabled><a class="nav-link js-scroll-trigger" href="{{ ($modifyFlag) ? route('MyProfile' , 'about') : route('ViewProfile' , ["type" => "about" , "user_name" => session()->get('search_name')]) }}">{{ trans('profile.MenuAbout') }}</a></li>
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ ($modifyFlag) ? route('MyProfile' , 'experience') : route('ViewProfile' , ["type" => "experience" , "user_name" => session()->get('search_name')]) }}">{{ trans('profile.MenuExperience') }}</a></li>
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ ($modifyFlag) ? route('MyProfile' , 'education') : route('ViewProfile' , ["type" => "education" , "user_name" => session()->get('search_name')]) }}">{{ trans('profile.MenuEducation') }}</a></li>
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ ($modifyFlag) ? route('MyProfile' , 'portfolio') : route('ViewProfile' , ["type" => "portfolio" , "user_name" => session()->get('search_name')]) }}">{{ trans('profile.MenuPortfolio') }}</a></li>
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ ($modifyFlag) ? route('MyProfile' , 'certificate') : route('ViewProfile' , ["type" => "certificate" , "user_name" => session()->get('search_name')]) }}">{{ trans('profile.MenuAward') }}</a></li>

                                <hr width="95%">
                                <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('MainPage') }}">{{ trans('profile.MenuBackToHome') }}</a></li>
                                @if ($mast["language_flag"] == "A")
                                    @if (Config::get('app.locale') == "en")
                                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('change' , 'th') }}">{{ trans('profile.MenuChangeLang') }}</a></li>
                                    @else
                                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('change' , 'en') }}">{{ trans('profile.MenuChangeLang') }}</a></li>
                                    @endif
                                @endif
                                <hr width="95%">
                            @endif
                        </ul>
                    </div>
                </nav>
                {{-- Page Content --}}
                <div class="container-fluid p-0">
                    @yield('section')
                    <hr class="m-0" />
                </div>

            @if ($modifyFlag)
                {{-- The Modal [set language]--}}
                <div class="modal fade" id="SetLanguage">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        {{-- Modal Header --}}
                            <div class="modal-header">
                                <h4 class="modal-title">{{ trans('profile.SetLangHeader') }}</h4>
                            </div>
                        {{-- Modal body --}}
                            <div class="modal-body">
                                {{ trans('profile.SetLangLabel') }}
                                <form action="{{ route('ctl.set.lang') }}" method="POST" id="SetLangForm">
                                    @csrf
                                    <select name="Lang" id="LangID" class="custom-select mb-3">
                                        <option value="" selected="" disabled="">{{ trans('profile.OptionList') }}</option>
                                        <option value="T">{{ trans('profile.OptionListT') }}</option>
                                        <option value="E">{{ trans('profile.OptionListE') }}</option>
                                        <option value="A">{{ trans('profile.OptionListA') }}</option>
                                    </select>
                                </form>
                            </div>
                        {{-- Modal footer --}}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="Javascript:SubmitSetLanguage();">{{ trans('profile.BtnSave') }}</button>
                                <button type="button" class="btn btn-danger" onclick="Javascript:FncCloseModal('SetLanguage');">{{ trans('profile.BtnClose') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- The Modal [set language]--}}

                {{-- The Modal [Set Background] --}}
                <div class="modal fade" id="SetBackground">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ trans('background.ModalHeader') }}</h4>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('ctl.set.background') }}" method="POST" id="SetBackgroundForm">
                                    @csrf
                                    @php

                                        $bg_color = (isset($ConfigProfile["background"]->background_color)) ? $ConfigProfile["background"]->background_color : "#ffffff";
                                        $mn_color = (isset($ConfigProfile["background"]->menu_color)) ? $ConfigProfile["background"]->menu_color : "#bd5d38";
                                        $f_m_color = (isset($ConfigProfile["font"]->main_color)) ? $ConfigProfile["font"]->main_color : "#bd5d38";
                                        $f_s_color = (isset($ConfigProfile["font"]->sub_color)) ? $ConfigProfile["font"]->sub_color : "#6c757d";

                                    @endphp

                                    <div class="form-group row">
                                        <label for="SetBackgroundType" class="col-md-4 col-form-label text-md-right">{{ trans('background.LabelColorType') }}</label>
                                        <div class="col-md-6">
                                            <select name="SetBackgroundType" id="SetBackgroundTypeID" class="custom-select mb-3">
                                                <option value="" selected="" disabled>{{ trans('background.SelectLabelDefault') }}</option>
                                                    @if ($mast["admin_flag"] == "Y")
                                                        <option value="G">{{ trans('background.GardientLabel') }}</option>
                                                    @endif
                                                <option value="C">{{ trans('background.CommonLabel') }}</option>
                                            </select>

                                            @error('SetBackgroundType')
                                                <script>
                                                    swal("{{ trans('background.header_error') }}" , "{{ $message }}" , 'error');
                                                </script>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="SelectBackgroundColor" class="col-md-4 col-form-label text-md-right">{{ trans('background.LabelBackgroundColor') }}</label>
                                        <div class="col-md-6">
                                            <input type="color" name="BackgroundColor" id="BackgroundColorID"  class="form-control @error('BackgroundColor') is-invalid @enderror" value="{{ $bg_color }}" required autocomplete="BackgroundColor" autofocus>
                                            @error('BackgroundColor')
                                                <script>
                                                    swal("{{ trans('background.header_error') }}" , "{{ $message }}" , 'error');
                                                </script>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="MenuColor" class="col-md-4 col-form-label text-md-right">{{ trans('background.LabelMenuColor') }}</label>
                                        <div class="col-md-6">
                                            <input type="color" name="MenuColor" id="MenuColorID" class="form-control @error('MenuColor') is-invalid @enderror" value="{{ $mn_color }}" required autocomplete="MenuColor" autofocus>
                                            @error('MenuColor')
                                                <script>
                                                    swal("{{ trans('background.header_error') }}" , "{{ $message }}" , 'error');
                                                </script>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr width="90%">

                                    <div class="form-group row">
                                        <label for="TextMainColor" class="col-md-4 col-form-label text-md-right">{{ trans('background.LabelFontMain') }}</label>
                                        <div class="col-md-6">
                                            <input type="color" name="TextMainColor" id="TextMainColorID" class="form-control @error('TextMaincolor') is-invalid @enderror" value="{{ $f_m_color }}" required autocomplete="TextMainColor" autofocus>
                                            @error('TextMainColor')
                                                <script>
                                                    swal("{{ trans('background.header_error') }}" , "{{ $message }}" , 'error');
                                                </script>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="TextSubColor" class="col-md-4 col-form-label text-md-right">{{ trans('background.LabelFontSub') }}</label>
                                        <div class="col-md-6">
                                            <input type="color" name="TextSubColor" id="TextSubColorID" class="form-control @error('TextSubColor') is-invalid @enderror" value="{{ $f_s_color }}" required autocomplete="TextSubColor" autofocus>
                                            @error('TextSubColor')
                                                <script>
                                                    swal("{{ trans('background.header_error') }}" , "{{ $message }}" , 'error');
                                                </script>
                                            @enderror
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="Javascript:SubmitSetBackground();">{{ trans('profile.BtnSave') }}</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- The Modal [Set Background] --}}
            @endif

            {{-- Other Modal --}}
                @yield('OtherModal')
            {{-- Other Modal --}}

            {{-- error return --}}
                @yield('GetError')
            {{-- error return --}}

            {{-- Javascript --}}
                @yield('LockModal-view')

            @if ($modifyFlag)
                @yield('LockModal-modify')
                <script>
                // Onload Function
                    $(document).ready(function() {
                        $("#BtnCustomBackground").click(function() {
                            $("#SetBackground").modal({
                                backdrop: "static"
                            }, 'show');
                        });
                    });
                // Other Function
                    function FncCloseModal(ModalName) {
                        if (ModalName == "SetLanguage") {
                            var tmp_url = "{{ route('MainPage') }}";
                            window.location = tmp_url;
                        }
                    }

                    function SubmitSetLanguage() {
                        var formMaster = document.getElementById('SetLangForm');
                        var tmp_lang = formMaster.elements["Lang"].value;
                        if (tmp_lang === "" || tmp_lang == null) {
                            swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.AlertLangNull') }}" , "error");
                        } else {
                            document.getElementById('SetLangForm').submit();
                        }
                    }

                    function SubmitSetBackground() {
                        var formMaster = document.getElementById('SetBackgroundForm');
                        var tmp_color_type = formMaster.elements["SetBackgroundType"].value;

                        if (tmp_color_type == "" || tmp_color_type == null) {
                            swal("{{ trans('profile.AlertError') }}" , "{{ trans('background.color_type') }}" , "error");
                        } else {
                            document.getElementById('SetBackgroundForm').submit();
                        }
                    }

                    function PublicProfile(id) {

                        swal({
                            title: "{{ trans('profile.js_public_header') }}",
                            text: "{{ trans('profile.js_public_body') }}",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willSubmit) => {
                            if (willSubmit) {
                                const tmp_url = "{{ route('public.profile' , 'id_send') }}".replace('id_send' , id);
                                window.location = tmp_url;
                            }
                        });

                    }

                    function ResetProfile() {
                        swal({
                            title: "{{ trans('profile.js_reset_header') }}",
                            text: "{{ trans('profile.js_reset_body') }}",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willSubmit) => {
                            if (willSubmit) {
                                window.location = "{{ route('reset.profile') }}";
                            }
                        });
                    }
                </script>
            @endif

                {{-- Other Function Js --}}
                @yield('OtherJsFunction')
            {{-- Javascript --}}

            </body>
        </html>
    @endif
@endforeach
