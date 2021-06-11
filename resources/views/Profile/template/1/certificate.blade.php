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
            {{ trans('profile.MenuAward') }}
            <i class="fas fa-plus-circle" style="cursor: pointer" data-toggle="modal" data-target="#SetCertificateModal"></i>
        </h2>

        {{-- certificate --}}
        @foreach ($certificate as $cc)
            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ ($lang == "th") ? $cc["cert_name_th"] : $cc["cert_name_en"] }}</h3>
                    <div class="subheading mb-3">
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

                            if ($lang == "th") {
                                for ($i=0; $i < count($THMonth); $i++) {
                                    if ($i == date_format(date_create($cc["cert_get_date"]) , 'n')) {
                                        echo date_format(date_create($cc["cert_get_date"]), 'd') . " " . $THMonth[$i] . " " . (intval(date_format(date_create($cc["cert_get_date"]) , 'Y')) + 543);
                                    }
                                }
                            } else {
                                echo date_format(date_create($cc["cert_get_date"]) , 'd F Y');
                            }
                        @endphp
                    </div>
                    <p>{{ ($lang == "th") ? $cc["cert_desc_th"] : $cc["cert_desc_en"] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="text-primary" style="cursor: pointer" data-toggle="modal" data-target="#md_show_cert_{{ $cc["cert_seq"] }}">
                        <p style="text-align: center">
                            <i class="fas fa-search fa-2x"></i>
                            <br>
                            <b>{{ trans('profile.PortfolioViewImageLabel') }}</b>
                        </p>
                    </span>
                </div>
            </div>
        @endforeach

    </div>
</section>
@endsection

@section('OtherModal')
    <!-- The Modal [set Certificate]-->
    <div class="modal fade" id="SetCertificateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('profile.md_header_cert') }}</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('ctl.set.cert') }}" method="POST" id="SetCertForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="lang_flag" value="{{ $lang_flag }}">

                        @if ($lang_flag == "A")

                        {{-- Get certificate name --}}
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_name_th_label') }}</label>
                                    <input type="text" name="cert_name_th" id="cert_name_th_id" class="form-control" placeholder="{{ trans('profile.md_ph_name_th') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_name_en_label') }}</label>
                                    <input type="text" name="cert_name_en" id="cert_name_en_id" class="form-control" placeholder="{{ trans('profile.md_ph_name_en') }}">
                                </div>
                            </div>

                        {{-- Get certificate description --}}
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_desc_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_desc_th_label') }}</label>
                                    <textarea name="cert_desc_th" id="cert_desc_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_desc_th') }}"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_desc_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_desc_en_label') }}</label>
                                    <textarea name="cert_desc_en" id="cert_desc_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_desc_en') }}"></textarea>
                                </div>
                            </div>

                        @elseif ($lang_flag == "T")

                        {{-- Get certificate name --}}
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_name_th_label') }}</label>
                                    <input type="text" name="cert_name_th" id="cert_name_th_id" class="form-control" placeholder="{{ trans('profile.md_ph_name_th') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_desc_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_desc_th_label') }}</label>
                                    <textarea name="cert_desc_th" id="cert_desc_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_desc_th') }}"></textarea>
                                </div>
                            </div>

                        @elseif ($lang_flag == "E")

                        {{-- Get certificate name --}}
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_name_en_label') }}</label>
                                    <input type="text" name="cert_name_en" id="cert_name_en_id" class="form-control" placeholder="{{ trans('profile.md_ph_name_en') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cert_desc_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_desc_en_label') }}</label>
                                    <textarea name="cert_desc_en" id="cert_desc_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_desc_en') }}"></textarea>
                                </div>
                            </div>

                        @endif

                    {{-- Get get date --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="cert_date" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_get_date') }}</label>
                                <input type="date" name="cert_date" id="cert_date_id" class="form-control">
                            </div>
                        </div>

                    {{-- Get images --}}
                        <div class="form-group row">
                            <label for="cert_images" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_cert_images') }}</label>

                            <div class="col-md-12">
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="cert_images_id" name="cert_images[]" multiple>
                                    <label class="custom-file-label" for="cert_images">{{ trans('profile.md_cert_image_text') }}</label>
                                </div>
                                <div class="mb-2" id="RenderFilename"></div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Javascript:ValidateCertificate('{{ $lang_flag }}');">{{ trans('profile.BtnSave') }}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal [set Certificate]-->

    @foreach ($certificate as $md_cert)

        <!-- The Modal [show certificate image]-->
        <div class="modal fade" id="md_show_cert_{{ $md_cert["cert_seq"] }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('profile.md_cert_image_show') }}</h4>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">

                        <div id="img_list" class="carousel slide" data-ride="carousel">

                            @php
                                $cnt = 0;
                            @endphp

                            <ul class="carousel-indicators">
                                @for ($i = 0; $i < count($files_name); $i++)
                                    <li data-target="#img_list" data-slide-to="{{ $i }}" {{ ($i == 0) ? 'class="active"' : "" }}></li>
                                @endfor
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                @foreach ($files_name as $fn)
                                    <div class="carousel-item {{ ($cnt == 0) ? 'active' : '' }}">
                                        <img class="img-fluid" style="width: 100%; height: 400px;" src="{{ route('GetDataImage' , ["id"=>$md_cert["profile_id"] , "file_name"=> $fn , "img_type" => "Certificate"]) }}">
                                    </div>

                                    @php
                                        $cnt ++;
                                    @endphp
                                @endforeach
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#img_list" data-slide="prev">
                              <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#img_list" data-slide="next">
                              <span class="carousel-control-next-icon"></span>
                            </a>

                          </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal [show portfolio image]-->
    @endforeach
@endsection

@section('GetError')

@endsection

@section('OtherJsFunction')
    <script>
        function ValidateCertificate(lang) {
            var formMast = document.getElementById("SetCertForm");
            var tmp_data = {
                "cert_name_th" : (lang == "A" || lang == "T") ? formMast.elements["cert_name_th"].value : null ,
                "cert_name_en" : (lang == "A" || lang == "E") ? formMast.elements["cert_name_en"].value : null ,
                "cert_desc_th" : (lang == "A" || lang == "T") ? formMast.elements["cert_desc_th"].value : null ,
                "cert_desc_en" : (lang == "A" || lang == "E") ? formMast.elements["cert_desc_en"].value : null ,
                "cert_date" : formMast.elements["cert_date"].value ,
                "cert_images" : formMast.elements["cert_images[]"].files ,
            }

            var chk_date = "{{ date('Y-m-d') }}";

            if (lang == "A" && ((tmp_data["cert_name_th"] == "" || tmp_data["cert_name_th"] == null) || (tmp_data["cert_name_en"] == "" || tmp_data["cert_name_en"] == null) )) {
                if (tmp_data["cert_name_th"] == "" || tmp_data["cert_name_th"] == null) {
                    swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_cert_name_th') }}" , "error");
                } else if (tmp_data["cert_name_en"] == "" || tmp_data["cert_name_en"] == null) {
                    swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_cert_name_en') }}" , "error");
                }
            } else if ((tmp_data["cert_desc_th"] == null || tmp_data["cert_desc_th"] == "") && (tmp_data["cert_desc_en"] == null || tmp_data["cert_desc_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_cert_desc') }}" , "error");
            } else if (tmp_data["cert_images"].length < 1) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_cert_images') }}" , "error");
            } else if (tmp_data["cert_images"].length > 2) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_cert_max_image') }}" , "error");
            } else if (tmp_data["cert_date"] == "" || tmp_data["cert_date"] == null) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_cert_date') }}" , "error");
            } else if (tmp_date["cert_date"] > chk_date) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_cert_max_date') }}" , "error");
            } else {
                formMast.submit();
            }
        }

        $(".custom-file-input").on("change", function() {
            var fileName = document.getElementById("cert_images_id").files;
            var cnt_file = fileName.length;

            if (cnt_file > 2) {
                var html = '<p style="color:red">{{ trans("profile.js_file_count_true") }} ' + cnt_file + ' / 2 {{ trans("profile.js_file_text") }}</p>';
            } else {
                var html = '<p style="color:green">{{ trans("profile.js_file_count_true") }} ' + cnt_file + ' / 2 {{ trans("profile.js_file_text") }}</p>';
            }

            document.getElementById("RenderFilename").innerHTML = html;
        });
        // Show image count
    </script>
@endsection
