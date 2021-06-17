@php
    $lang = Config::get('app.locale');
@endphp
@extends('Profile.template.1.0-master')

@foreach ($master as $data)
    @section('section')
        <section class="resume-section" id="about">
            <div class="resume-section-content">
                @php
                    $tmp_name = ($lang == "th") ? explode(" " , $data["name_th"]) : explode(" " , $data["name_en"]) ;
                @endphp

                @if ($lang == "th")
                    <h2 class="mb-2">
                        {{ max($tmp_name) }}
                        <span class="text-primary">{{ min($tmp_name) }}</span>
                    </h2>
                @else
                    <h1 class="mb-0">
                        {{ max($tmp_name) }}
                        <span class="text-primary">{{ min($tmp_name) }}</span>
                    </h1>
                @endif
                <div class="subheading mb-2">
                    @if ($modifyFlag)
                        {{ ($data["location_id"] == null) ? (($lang == "th") ? "ที่อยู่ : " : "Address : ") : null }}
                        <a class="social-icon" id="SetProfileLocationID" style="cursor: pointer" data-toggle="modal" data-target="#SetProfileLocation">
                            <b><u>{{ trans('profile.EditLabel') }}</u></b>
                        </a>
                    @endif

                    @if ($data["location_id"] != null)
                        @foreach ($location_det as $loc)
                            {{ (($lang) == "th") ? ($loc["sub_district_th"] . " " . $loc["district_th"] . " " . $loc["province_th"] . " " . $loc["zip_code"]) : ($loc["sub_district_en"] . " " . $loc["district_en"] . " " . $loc["province_en"] . " " . $loc["zip_code"]) }}
                        @endforeach
                        · {{ $data["telephone"] }} ·
                        <a href="mailto:{{ $data["email"] }}">{{ $data["email"] }}</a>
                    @endif
                </div>

                        <p class="lead mb-5">
                            @if ($modifyFlag)
                                {{-- {{ (($data["about_th"] == null or $data["about_th"] == "") and ($data["about_en"] == null or $data["about_en"] == "")) }} --}}
                                <a class="social-icon" id="SetProfileAboutID" style="cursor: pointer" data-toggle="modal" data-target="#SetProfileAbout">
                                    <b><u>{{ trans('profile.EditLabel') }}</u></b>
                                </a>
                            @endif
                            {{ ($data["about_th"] == null and $data["about_en"] == null) ? trans('profile.NonAssignabout') : (($lang == "th") ? $data["about_th"] : $data["about_en"]) }}
                        </p>

                <div class="subheading mb-2">
                    {{ trans('profile.SocialAccount') }}
                    @if ($modifyFlag)
                        <i class="fas fa-plus-circle" id="SetProfileSocialID" style="cursor: pointer" data-toggle="modal" data-target="#SetProfileSocial"></i>
                    @endif
                </div>
                <ul class="list-inline dev-icons">
                    @foreach ($tmp_social as $ts)
                        @foreach ($social_list as $tmp_si)
                            @if ($ts->social_list_id == $tmp_si["social_list_id"])
                                <li class="list-inline-item">
                                    <div class="social-icons mb-5">
                                        <a class="social-icon" style="cursor: pointer" href="{{ $ts->social_account_link }}" target="_blank">
                                            <i class="{{ $tmp_si["social_list_icon_name"] }}"></i>
                                        </a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    @endforeach
                </ul>
            </div>
        </section>
    @endsection

    @if ($modifyFlag)
        @section('OtherModal')
            <!-- The Modal [set Address]-->
            <div class="modal fade" id="SetProfileLocation">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">{{ trans('profile.ModaladdrHeader') }}</h4>
                        </div>
                    <!-- Modal body -->
                        <div class="modal-body">
                            <form action="{{ route('ctl.set.profileAddress') }}" method="POST" id="SetAddressForm">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="home_province" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalPVBody') }}</label>
                                        <select class="form-control" name="home_province" id="home_province_id" style="width: 100%" onchange="SelectAmphoe(this , '{{ $lang }}')" required>
                                            <option disabled="" value="" selected>{{ trans('profile.SelectProvinceLabel') }}</option>
                                            @foreach ($addr_province as $Data_province)
                                                <option value="{{ $Data_province->province_code }}">
                                                    {{ ($lang == "th") ? $Data_province->province_th : $Data_province->province_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="home_district" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalDTBody') }}</label>
                                        <select class="form-control" name="home_district" id="home_district_id" style="width: 100%" onchange="SelectDistrict(this , '{{ $lang }}')" disabled></select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="home_sub_district" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalSTBody') }}</label>
                                        <select class="form-control" name="home_sub_district" id="home_sub_district_id" style="width: 100%" onchange="GetZipCode(this)" disabled></select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="home_zip_code" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalZipCodeBody') }}</label>
                                        <div class="form-control" id="home_zip_code_id"></div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="Javascript:ValidateFormAddress();">{{ trans('profile.BtnSave') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- The Modal [set Address]-->

            <!-- The Modal [set About]-->
            <div class="modal fade" id="SetProfileAbout">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">{{ trans('profile.ModalAboutHeader') }}</h4>
                        </div>
                    <!-- Modal body -->
                        <div class="modal-body">
                            <form action="{{ route('ctl.set.profileAbout') }}" method="POST" id="SetAboutForm">
                                @csrf

                                @if ($data["language_flag"] == "A" or $data["language_flag"] == "E" or $data["language_flag"] == "T")
                                    @if ($data["language_flag"] == "T")
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="about_tag" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalAboutLabel_th') }}</label>
                                                <div class="container">
                                                    <textarea name="about_tag_th" id="about_tag_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.ModalPlaceHolder_th') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($data["language_flag"] == "E")
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="about_tag" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalAboutLabel_en') }}</label>
                                                <div class="container">
                                                    <textarea name="about_tag_en" id="about_tag_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.ModalPlaceHolder_en') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="about_tag" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalAboutLabel_th') }}</label>
                                                <div class="container">
                                                    <textarea name="about_tag_th" id="about_tag_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.ModalPlaceHolder_th') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="about_tag" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalAboutLabel_en') }}</label>
                                                <div class="container">
                                                    <textarea name="about_tag_en" id="about_tag_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.ModalPlaceHolder_en') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </form>
                        </div>
                    <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="Javascript:ValidateFormAbout('{{ Auth::user()->language_flag }}');">{{ trans('profile.BtnSave') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- The Modal [set About]-->

            <!-- The Modal [set Social list]-->
            <div class="modal fade" id="SetProfileSocial">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">{{ trans('profile.ModalSocialHeader') }}</h4>
                        </div>
                    <!-- Modal body -->
                        <div class="modal-body">
                            <form action="{{ route('ctl.set.SocialAccount') }}" method="POST" id="SetSocialAccountForm">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="social_select" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalOptionSocial') }}</label>
                                        <select class="form-control" name="social_select" id="social_select_id" style="width: 100%">
                                            <option value="" selected disabled>Select social account type</option>
                                            @foreach ($social_list as $si)
                                                <option value="{{ $si["social_list_id"] }}">{{ $si["social_list_name"] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="profile_link" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalUrlSocial') }}</label>
                                        <input type="text" name="profile_link" id="profile_link_id" class="form-control">
                                    </div>
                                </div>

                            </form>
                        </div>
                    <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="Javascript:ValidateFormSocialAccount();">{{ trans('profile.BtnSave') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- The Modal [set Social list]-->

        @endsection
    @endif
@endforeach

@if ($modifyFlag)
    @section('LockModal-modify')
        <script>
            // Onload Function
            $(document).ready(function() {
                $("#SetProfileLocationID").click(function() {
                    $("#SetProfileLocation").modal({
                        backdrop: "static"
                    }, 'show');
                });

                $("#SetProfileAboutID").click(function() {
                    $("#SetProfileAbout").modal({
                        backdrop: "static"
                    }, 'show');
                });

                $("#SetProfileSocialID").click(function() {
                    $("#SetProfileSocial").modal({
                        backdrop: "static"
                    }, 'show');
                });
            });
        </script>
    @endsection
    @section('OtherJsFunction')
        <script>

            function SelectAmphoe(province_code , lang) {

                var amphoe_arr = @json($addr_amphoe);
                var amphoe_opt = '<option selected value="" disabled>{{ trans("profile.SelectDistrictLabel") }}</option>';
                for (let i = 0; i < amphoe_arr.length; i++) {
                    if (amphoe_arr[i]["province_code"] == province_code.value) {
                        if (lang == "th") {
                            amphoe_opt += '<option value="' + amphoe_arr[i]["district_code"] + '">' + amphoe_arr[i]["district_th"] + '</option>';
                        } else {
                            amphoe_opt += '<option value="' + amphoe_arr[i]["district_code"] + '">' + amphoe_arr[i]["district_en"] + '</option>';
                        }
                    }
                }

                document.getElementById('home_district_id').innerHTML = amphoe_opt;
                document.getElementById('home_district_id').disabled = false;
            }

            function SelectDistrict(amphoe_code , lang) {
                var district_arr = @json($addr_district);
                var district_opt = '<option selected value="" disabled>{{ trans("profile.SelectSubDistrictLabel") }}</option>';
                for (let i = 0; i < district_arr.length; i++) {
                    if (district_arr[i]["district_code"] == amphoe_code.value) {
                        if (lang == "th") {
                            district_opt += '<option value="' + district_arr[i]["sub_district_code"] + '">' + district_arr[i]["sub_district_th"] + '</option>';
                        } else {
                            district_opt += '<option value="' + district_arr[i]["sub_district_code"] + '">' + district_arr[i]["sub_district_en"] + '</option>';
                        }
                    }
                }

                document.getElementById('home_sub_district_id').innerHTML = district_opt;
                document.getElementById('home_sub_district_id').disabled = false;
            }

            function GetZipCode(district_code) {
                var ZipCode_arr = @json($addr_post_code);
                var zipCodeHTML = "";
                for (let i = 0; i < ZipCode_arr.length; i++) {
                    if (ZipCode_arr[i]["sub_district_code"] == district_code.value) {
                        zipCodeHTML = ZipCode_arr[i]["zip_code"];
                    }
                }

                document.getElementById('home_zip_code_id').innerHTML = zipCodeHTML;
            }

            function ValidateFormAddress() {
                var formMast = document.getElementById("SetAddressForm");
                var province_val = formMast.elements["home_province"].value;
                var district_val = formMast.elements["home_district"].value;
                var sub_district_val = formMast.elements["home_sub_district"].value;

                if ( province_val == "" || province_val == null) {
                    swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ValidProvince') }}" , "error");
                } else if (district_val == "" || district_val == null) {
                    swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ValidDistrict') }}" , "error");
                } else if (sub_district_val == "" || sub_district_val == null) {
                    swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ValidSubDistrict') }}" , "error");
                } else {
                    document.getElementById("SetAddressForm").submit();
                }
            }

            function ValidateFormAbout(lang) {
                var formMast = document.getElementById("SetAboutForm");

                if (lang == "T") {
                    var About_th_val = formMast.elements["about_tag_th"].value;
                    var About_en_val = null;
                } else if(lang == "E"){
                    var About_th_val = null;
                    var About_en_val = formMast.elements["about_tag_en"].value;
                } else {
                    var About_th_val = formMast.elements["about_tag_th"].value;
                    var About_en_val = formMast.elements["about_tag_en"].value;
                }

                if (
                    lang == "A" &&
                    (About_th_val != "" && About_th_val != null) &&
                    (About_en_val != "" && About_en_val != null)
                ) {
                    document.getElementById("SetAboutForm").submit();
                } else if (lang == "T" && (About_th_val != "" && About_th_val != null)) {
                    document.getElementById("SetAboutForm").submit();
                } else if (lang == "E" && (About_en_val != "" && About_en_val != null)){
                    document.getElementById("SetAboutForm").submit();
                } else {
                    if (lang == "A") {
                        if (About_th_val == "" || About_th_val == null) {
                            swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ErrJsAboutTH') }}" , "error");
                        } else if (About_en_val == "" || About_en_val == null) {
                            swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ErrJsAboutEN') }}" , "error");
                        }
                    } else if (lang == "T" && (About_th_val == "" || About_th_val == null)) {
                        swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ErrJsAboutTH') }}" , "error");
                    } else if (lang == "E" && (About_en_val == "" || About_en_val == null)) {
                        swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ErrJsAboutEN') }}" , "error");
                    } else {
                        swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.ErrJsOther') }}" , "error");
                    }
                }
            }

            function ValidateFormSocialAccount() {
                var formMast = document.getElementById("SetSocialAccountForm");
                var optionSelect = formMast.elements["social_select"].value;
                var linkValue = formMast.elements["profile_link"].value;

                if(optionSelect == "" || optionSelect == null){
                    swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.JsValidateSocialOption') }}" , "error");
                } else if(linkValue == "" || linkValue == null) {
                    swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.JsValidateSocialUrl') }}" , "error");
                } else {
                    document.getElementById("SetSocialAccountForm").submit();
                }
            }

            function ValidateFormProgrammingSkill() {
                var formMast = document.getElementById("SetProgrammingForm");
                console.log(formMast);
            }
        </script>
    @endsection
@endif
