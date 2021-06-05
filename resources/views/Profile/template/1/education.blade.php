@php
    $lang = Config::get('app.locale');

    foreach ($master as $ms) {
        $lang_flag = $ms["language_flag"];
    }
@endphp

@extends('Profile.template.1.0-master')

@section('section')
<section class="resume-section" id="education">
    <div class="resume-section-content">
        <h2 class="mb-5">
            {{ trans('profile.MenuEducation') }}
            <i class="fas fa-plus-circle" style="cursor: pointer" data-toggle="modal" data-target="#SetEducateModal"></i>
        </h2>

        @foreach ($education as $edu)
            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="flex-grow-1">
                    <h3 class="mb-0">
                        @foreach ($learning_list as $ll)
                            @if ($edu["learning_list_id"] == $ll["learning_list_id"])
                                {{ ($lang == "th") ? $ll["learning_desc_th"] : $ll["learning_desc_en"] }}
                            @endif
                        @endforeach
                    </h3>
                    <div class="subheading mb-3">
                        {{ ($lang == "th") ? $edu["college_name_th"] : $edu["college_name_en"] }}
                    </div>
                    <div>
                        {{ ($lang == "th") ? $edu["faculty_name_th"] : $edu["faculty_name_en"] }}
                    </div>
                    <p>{{ trans('profile.GPALabel') }} : {{ $edu["gpa"] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="text-primary">
                        @if ($lang == "th")
                            @php
                                $THMonth = array(
                                    '1' => 'มกราคม',
                                    '2' => 'กุมภาพันธ์' ,
                                    '3' => 'มีนาคม' ,
                                    '4' => 'เมษายน' ,
                                    '5' => 'พฤษภาคม' ,
                                    '6' => 'มิถุนายน' ,
                                    '7' => 'กรกฎาคม' ,
                                    '8' => 'สิงหาคม' ,
                                    '9' => 'กันยายน' ,
                                    '10' => 'ตุลาคม' ,
                                    '11' => 'พฤศจิกายน' ,
                                    '12' => 'ธันวาคม' ,
                                );
                            @endphp

                            @for ($i = 0; $i < count($THMonth); $i++)
                                @if ($i == date_format(date_create($edu["efft_date"]) , 'n'))
                                   {{ $THMonth[$i] }}
                                   @break
                                @endif
                            @endfor

                            {{ ' ' . (date_format(date_create($edu["efft_date"]) , 'Y') + 543) . '-' }}

                            @if ($edu["exp_date"] != null)
                                @for ($i = 0; $i < count($THMonth); $i++)
                                    @if ($i == date_format(date_create($edu["exp_date"]) , 'n'))
                                        {{ $THMonth[$i] }}
                                        @break
                                    @endif
                                @endfor

                                {{ ' ' . (date_format(date_create($edu["exp_date"]) , 'Y') + 543) }}
                            @else
                                {{ trans('profile.WorkEndDateRender') }}
                            @endif
                        @else
                            {{ date_format(date_create($edu["efft_date"]) , 'M Y') }} - {{ ($edu["exp_date"] == null) ? trans('profile.WorkEndDateRender') : date_format(date_create($edu["exp_date"]) , "M Y") }}
                        @endif
                    </span>
                </div>
            </div>
        @endforeach

    </div>
</section>
@endsection

@section('OtherModal')
<!-- The Modal [set Social list]-->
<div class="modal fade" id="SetEducateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('profile.ModalEducateHeader') }}</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('ctl.set.education') }}" method="POST" id="SetEducationForm">
                    @csrf
                    <input type="hidden" name="lang_flag" value="{{ $lang_flag }}">

                    {{-- Get learning list --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="learning_list" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalEducateLevel') }}</label>
                            <select name="learning_list" id="learning_list_id" class="form-control">
                                <option value="" disabled selected>{{ trans('profile.ModalEducateOption') }}</option>
                                @foreach ($learning_list as $ll)
                                    <option value="{{ $ll["learning_list_id"] }}">{{ ($lang == "th") ? $ll["learning_desc_th"] : $ll["learning_desc_en"] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Get College Name --}}
                    @if ($lang_flag == "A")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="college_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalCollegeNameTH') }}</label>
                                <input type="text" name="college_name_th" id="college_name_th_id" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="college_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalCollegeNameEN') }}</label>
                                <input type="text" name="college_name_en" id="college_name_en_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "T")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="college_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalCollegeNameTH') }}</label>
                                <input type="text" name="college_name_th" id="college_name_th_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "E")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="college_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalCollegeNameEN') }}</label>
                                <input type="text" name="college_name_en" id="college_name_en_id" class="form-control">
                            </div>
                        </div>
                    @endif

                    {{-- Get Faculty --}}
                    @if ($lang_flag == "A")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="faculty_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalFacultyNameTH') }}</label>
                                <input type="text" name="faculty_name_th" id="faculty_name_th_id" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="faculty_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalFacultyNameEN') }}</label>
                                <input type="text" name="faculty_name_en" id="faculty_name_en_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "T")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="faculty_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalFacultyNameTH') }}</label>
                                <input type="text" name="faculty_name_th" id="faculty_name_th_id" class="form-control">
                            </div>
                        </div>
                    @elseif ($lang_flag == "E")
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="faculty_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalFacultyNameEN') }}</label>
                                <input type="text" name="faculty_name_en" id="faculty_name_en_id" class="form-control">
                            </div>
                        </div>
                    @endif

                    {{-- Get GPA --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="gpa_value" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalGpaValue') }}</label>
                            <input type="number" name="gpa_value" id="gpa_value_id" class="form-control" min="0.00" max="4.00" step="0.1">
                        </div>
                    </div>

                    {{-- Get Start date --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="start_date" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalStartDate') }}</label>
                            <input type="date" name="start_date" id="start_date_id" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    {{-- Get End date --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="exp_date" class="col-md-12 col-form-label text-md-left">{{ trans('profile.ModalEndDate') }}</label>
                            <input type="date" name="exp_date" id="exp_date_id" class="form-control" value="{{ date('Y-m-d') }}" disabled>
                        </div>
                    </div>

                    {{-- Get Recheck end date flag --}}
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" onchange="Javascript:DisabledText()" id="chk_disableExpiredate" name="chk_disable" checked>
                        <label class="custom-control-label" for="chk_disableExpiredate">{{ trans('profile.ModalCheckLeavingFlag') }}</label>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="Javascript:ValidateFormEducate('{{ $lang_flag }}');">{{ trans('profile.BtnSave') }}</button>
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

        function ValidateFormEducate(lang) {
            var formMast = document.getElementById("SetEducationForm");
            var validate_elements = {
                "learning_type" : formMast.elements["learning_list"].value ,
                "college_name_th" : ((lang == "A" || lang == "T") ? formMast.elements["college_name_th"].value : null) ,
                "college_name_en" : ((lang == "A" || lang == "E") ? formMast.elements["college_name_en"].value : null) ,
                "faculty_name_th" : ((lang == "A" || lang == "T") ? formMast.elements["faculty_name_th"].value : null) ,
                "faculty_name_en" : ((lang == "A" || lang == "E") ? formMast.elements["faculty_name_en"].value : null) ,
                "gpa_value" : formMast.elements["gpa_value"].value ,
                "start_date" : formMast.elements["start_date"].value ,
                "end_date" : (formMast.elements["chk_disable"].checked ? null : formMast.elements["exp_date"].value)
            };

            // validation
            if (validate_elements["learning_type"] == null || validate_elements["learning_type"] == "") {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_learning_type') }}" , "error");
            } else if ((validate_elements["college_name_th"] == null || validate_elements["college_name_th"] == "") && (validate_elements["college_name_en"] == null || validate_elements["college_name_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_college_name') }}" , "error");
            } else if ((validate_elements["faculty_name_th"] == null || validate_elements["faculty_name_th"] == "") && (validate_elements["faculty_name_en"] == null || validate_elements["faculty_name_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_faculty_name') }}" , "error");
            } else if (validate_elements["gpa_value"] < 0 || validate_elements["gpa_value"] > 4 || validate_elements["gpa_value"] == null || validate_elements["gpa_value"] == "") {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_GpaValue') }}" , "error");
            } else if (validate_elements["start_date"] == null || validate_elements["start_date"] == "") {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_start_date') }}" , "error");
            } else if ((validate_elements["end_date"] == null || validate_elements["end_date"] == "") && formMast.elements["chk_disable"].checked == false) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_end_date') }}" , "error");
            } else if (validate_elements["start_date"] >= validate_elements["end_date"]) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.Js_recheck_date') }}" , "error");
            } else {
                document.getElementById("SetEducationForm").submit();
            }
        }
    </script>
@endsection

@section('GetError')
    @error('learning_list')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('college_name_th')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('college_name_en')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('faculty_name_th')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('faculty_name_en')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('gpa_value')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror
@endsection
