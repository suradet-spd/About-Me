@php
    $lang = Config::get('app.locale');
@endphp
@extends('Profile.template.1.0-master')

@foreach ($master as $data)
    @section('section')
        <section class="resume-section" id="about">
            <div class="resume-section-content">
                @php
                    if ($lang == "th") {
                        $tmp_name = explode(" " , $data["name_th"]);
                    } else {
                        $tmp_name = explode(" " , $data["name_en"]);
                    }
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
                    @if ($data["location_id"] == null)
                        <a href="#" id="BTNAddaddress" data-toggle="modal" data-target="#SetProfileLocation">{{ trans('profile.MenuAddAddress') }}</a>
                    @else
                        @foreach ($location_det as $loc)
                            @if ($lang == "th")
                                {{ $loc["sub_district_th"] . " " . $loc["district_th"] . " " . $loc["province_th"] . " " . $loc["zip_code"] }}
                            @else
                                {{ $loc["sub_district_en"] . " " . $loc["district_en"] . " " . $loc["province_en"] . " " . $loc["zip_code"] }}
                            @endif
                        @endforeach
                        · {{ $data["telephone"] }} ·
                        <a href="mailto:{{ $data["email"] }}">{{ $data["email"] }}</a>
                    @endif
                </div>

                    @if ($data["about_th"] == null and $data["about_en"] == null)
                        <div class="subheading mb-5">
                            <a href="#" data-toggle="modal" data-target="#SetProfileAbout">Add about</a>
                        </div>
                    @else
                        <p class="lead mb-5">
                            @if ($lang == "th")
                                {{ $data["about_th"] }}
                            @else
                                {{ $data["about_en"] }}
                            @endif
                        </p>
                    @endif

                <div class="social-icons">
                    <a class="social-icon" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="social-icon" href="#"><i class="fab fa-github"></i></a>
                    <a class="social-icon" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="social-icon" href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
        </section>
    @endsection

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
                                                @if ($lang == "th")
                                                    {{ $Data_province->province_th }}
                                                @else
                                                    {{ $Data_province->province_en }}
                                                @endif
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
    @endsection
@endforeach

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
    </script>
@endsection
