@php
    $lang = Config::get('app.locale');

    foreach ($master as $ms) {
        $lang_flag = $ms["language_flag"];
    }
@endphp

@extends('Profile.template.1.0-master')

@section('section')
<section class="resume-section" id="experience">
    <div class="resume-section-content">
        <h2 class="mb-5">
            {{ trans('profile.MenuExperience') }}
            <i class="fas fa-plus-circle" style="cursor: pointer" data-toggle="modal" data-target="#SetExperienceModal"></i>
        </h2>

        @foreach ($work as $wk)
            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ ($lang == "th") ? $wk["work_name_th"] : $wk["work_name_en"] }}</h3>
                    <div class="subheading mb-3">{{ ($lang == "th") ? $wk["work_office_th"] : $wk["work_office_en"] }}</div>
                    <p>{{ ($lang == "th") ? $wk["work_desc_th"] : $wk["work_desc_en"] }}</p>
                </div>
                <div class="flex-shrink-0"><span class="text-primary">{{ date_format(date_create($wk["work_start_date"]) , 'M Y') }} - {{ ($wk["work_end_date"] == null) ? trans('profile.WorkEndDateRender') : $wk["work_end_date"] }}</span></div>
            </div>
        @endforeach


    </div>
</section>
@endsection
{{-- {{ dd($master) }} --}}
@section('OtherModal')
<!-- The Modal [set Social list]-->
<div class="modal fade" id="SetExperienceModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('profile.ModalWorkHeader') }}</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('ctl.set.work') }}" method="POST" id="SetSocialAccountForm">
                    @csrf
                    <input type="hidden" name="lang_flag" value="{{ $lang_flag }}">
                    {{-- Get Office Name --}}
                    @if ($lang_flag == "A")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="office_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalOfficeNameTh') }}</label>
                                <input type="text" name="office_name_th" id="office_name_th_id" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="office_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalOfficeNameEN') }}</label>
                                <input type="text" name="office_name_en" id="office_name_en_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "T")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="office_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalOfficeNameTh') }}</label>
                                <input type="text" name="office_name_th" id="office_name_th_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "E")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="office_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalOfficeNameEN') }}</label>
                                <input type="text" name="office_name_en" id="office_name_en_id" class="form-control">
                            </div>
                        </div>
                    @endif

                {{-- Get work time --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="start_date" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalStartDate') }}</label>
                            <input type="date" name="start_date" id="start_date_id" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 mb-2">
                            <label for="end_date" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalEndDate') }}</label>
                            <input type="date" name="exp_date" id="exp_date_id" class="form-control" value="{{ date('Y-m-d') }}" disabled>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" onchange="Javascript:DisabledText()" id="chk_disableExpiredate" name="chk_disable" checked>
                        <label class="custom-control-label" for="chk_disableExpiredate">{{ trans('profile.label_ModalCheckRetireFlag') }}</label>
                    </div>

                {{-- Get position Name --}}
                    @if ($lang_flag == "A")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="position_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalPositionNameTH') }}</label>
                                <input type="text" name="position_name_th" id="position_name_th_id" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="position_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalPositionNameEN') }}</label>
                                <input type="text" name="position_name_en" id="position_name_en_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "T")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="position_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalPositionNameTH') }}</label>
                                <input type="text" name="position_name_th" id="position_name_th_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "E")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="position_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalPositionNameEN') }}</label>
                                <input type="text" name="position_name_en" id="position_name_en_id" class="form-control">
                            </div>
                        </div>
                    @endif

                {{-- Get wprk desc --}}
                    @if ($lang_flag == "A")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="work_desc_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalAboutTH') }}</label>
                                {{-- <div class="container"> --}}
                                    <textarea name="work_desc_th" id="work_desc_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.place_About') }}"></textarea>
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="work_desc_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalAboutEN') }}</label>
                                {{-- <div class="container"> --}}
                                    <textarea name="work_desc_en" id="work_desc_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.place_About') }}"></textarea>
                                {{-- </div> --}}
                            </div>
                        </div>
                    @elseif ($lang_flag == "T")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="work_desc_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalAboutTH') }}</label>
                                {{-- <div class="container"> --}}
                                    <textarea name="work_desc_th" id="work_desc_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.place_About') }}"></textarea>
                                {{-- </div> --}}
                            </div>
                        </div>
                    @elseif ($lang_flag == "E")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="work_desc_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.label_ModalAboutEN') }}</label>
                                {{-- <div class="container"> --}}
                                    <textarea name="work_desc_en" id="work_desc_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.place_About') }}"></textarea>
                                {{-- </div> --}}
                            </div>
                        </div>
                    @endif
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="Javascript:ValidateFormWork('{{ $lang_flag }}');">{{ trans('profile.BtnSave') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- The Modal [set Social list]-->
@endsection

@section('OtherJsFunction')
    <script>

        function DisabledText() {
            var tmp = document.getElementById("chk_disableExpiredate").checked;
            if (tmp) {
                document.getElementById("exp_date_id").disabled = true;
            } else {
                document.getElementById("exp_date_id").disabled = false;
            }
        }

        function ValidateFormWork(lang_flag) {

        // Declare variable
            var formMast = document.getElementById("SetSocialAccountForm");
            var validate_elements = {
                "office_name_th" : null ,
                "office_name_en" : null ,
                "start_date" : formMast.elements["start_date"].value ,
                "end_date" : formMast.elements["exp_date"].value ,
                "retire_flag" : formMast.elements["chk_disable"].checked,
                "position_name_th" : null ,
                "position_name_en" : null ,
                "work_desc_th" : null ,
                "work_desc_en" : null
            };

            if (lang_flag == "A") {
                validate_elements["office_name_th"] = formMast.elements["office_name_th"].value;
                validate_elements["office_name_en"] = formMast.elements["office_name_en"].value;
                validate_elements["position_name_th"] = formMast.elements["position_name_th"].value;
                validate_elements["position_name_en"] = formMast.elements["position_name_en"].value;
                validate_elements["work_desc_th"] = formMast.elements["work_desc_th"].value;
                validate_elements["work_desc_en"] = formMast.elements["work_desc_en"].value;
            } else if (lang_flag == "T") {
                validate_elements["office_name_th"] = formMast.elements["office_name_th"].value;
                validate_elements["position_name_th"] = formMast.elements["position_name_th"].value;
                validate_elements["work_desc_th"] = formMast.elements["work_desc_th"].value;
            } else if (lang_flag == "E"){
                validate_elements["office_name_en"] = formMast.elements["office_name_en"].value;
                validate_elements["position_name_en"] = formMast.elements["position_name_en"].value;
                validate_elements["work_desc_en"] = formMast.elements["work_desc_en"].value;
            } else {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_Workerror') }}" , "error");
            }

        // Validate
            if ((validate_elements["office_name_th"] == null || validate_elements["office_name_th"] == "") && (validate_elements["office_name_en"] == null || validate_elements["office_name_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_officeName_require') }}" , "error");
            } else if (validate_elements["retire_flag"] == false && validate_elements["start_date"] >= validate_elements["end_date"]) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_Recheck_workDate') }}" , "error");
            } else if ((validate_elements["position_name_th"] == null || validate_elements["position_name_th"] == "") && (validate_elements["position_name_en"] == null || validate_elements["position_name_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_position_require') }}" , "error");
            } else if ((validate_elements["work_desc_th"] == null || validate_elements["work_desc_th"] == "") && (validate_elements["work_desc_en"] == null || validate_elements["work_desc_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_About_require') }}");
            } else{
                document.getElementById("SetSocialAccountForm").submit();
            }
        }
    </script>
@endsection
