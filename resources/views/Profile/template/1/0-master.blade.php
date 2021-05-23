{{-- Validate session language and language_flag --}}
@php
    $tmp_lang = Auth::user()->language_flag;
    if ($tmp_lang == "T") {
        $lang = "th";
    } elseif ($tmp_lang = "E") {
        $lang = "en";
    } else {
        $lang = null;
    }

@endphp

@if(Auth::user()->language_flag != "N" && Auth::user()->language_flag != "A" && ($lang != null && $lang != Config::get('app.locale')))
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
            <!-- Font Awesome icons (free version)-->
            <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
            <!-- Google fonts-->
            <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
            <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
            <!-- Core theme CSS (includes Bootstrap)-->
            <link href="{{ asset('css/template-profile/styles_type_1.css') }}" rel="stylesheet" />

            <!-- Bootstrap core JS-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Third party plugin JS-->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
            <!-- Core theme JS-->
            <script src="{{ asset('js/template-profile/scripts_type_1.js') }}"></script>

            {{-- Using Sweet alert --}}
            <script src="{{ asset('js/sweetalert.min.js') }}"></script>
            {{-- Another script link --}}
        </head>
        <body id="page-top">
            {{-- check Error Log and show --}}
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
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">
                    <span class="d-block d-lg-none">{{ Auth::user()->name_en }}</span>
                    <span class="d-none d-lg-block">
                        <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="{{ route('GetImage' , Auth::user()->photo_name) }}" alt="" />
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">

                        @if (Auth::user()->language_flag == "N")
                        <script>
                            $(function() {
                                $('#SetLanguage').modal({backdrop: "static"} , 'show');
                            });
                        </script>
                            {{-- set language (create modal and this modal can't close if user close modal redirect to home) --}}
                        @else
                        <hr width="95%">
                            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#">{{ trans('profile.MenuCustomBG') }}</a></li>
                        <hr width="95%">
                        <li class="nav-item" disabled><a class="nav-link js-scroll-trigger" href="{{ route('MyProfile' , 'about') }}">{{ trans('profile.MenuAbout') }}</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('MyProfile' , 'experience') }}">{{ trans('profile.MenuExperience') }}</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('MyProfile' , 'education') }}">{{ trans('profile.MenuEducation') }}</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('MyProfile' , 'portfolio') }}">{{ trans('profile.MenuPortfolio') }}</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('MyProfile' , 'skills') }}">{{ trans('profile.MenuSkill') }}</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('MyProfile' , 'awards') }}">{{ trans('profile.MenuAward') }}</a></li>

                            @if (Auth::user()->language_flag == "A")
                                <hr width="95%">
                                    @if (Config::get('app.locale') == "en")
                                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('change' , 'th') }}">{{ trans('profile.MenuChangeLang') }}</a></li>
                                    @else
                                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('change' , 'en') }}">{{ trans('profile.MenuChangeLang') }}</a></li>
                                    @endif
                                <hr width="95%">
                            @endif
                        @endif
                    </ul>
                </div>
            </nav>
            <!-- Page Content-->
            <div class="container-fluid p-0">
                @yield('section')
                <hr class="m-0" />
            </div>

        <!-- The Modal [set language]-->
            <div class="modal fade" id="SetLanguage">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">{{ trans('profile.SetLangHeader') }}</h4>
                        </div>
                    <!-- Modal body -->
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
                    <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="Javascript:SubmitSetLanguage();">{{ trans('profile.BtnSave') }}</button>
                            <button type="button" class="btn btn-danger" onclick="Javascript:FncCloseModal('SetLanguage');">{{ trans('profile.BtnClose') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- The Modal [set language]-->

        <!-- Javascript -->
        <script>
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
        </script>
        <!-- Javascript -->
        </body>
    </html>
@endif
