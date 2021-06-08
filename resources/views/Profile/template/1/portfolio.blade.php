@php
    $lang = Config::get('app.locale');

    foreach ($master as $ms) {
        $lang_flag = $ms["language_flag"];
    }
@endphp

@extends('Profile.template.1.0-master')

@section('section')
<section class="resume-section" id="portfolio">
    <div class="resume-section-content">
        <h2 class="mb-5">
            {{ trans('profile.MenuPortfolio') }}
            <i class="fas fa-plus-circle" style="cursor: pointer" data-toggle="modal" data-target="#SetPortfolioModal"></i>
        </h2>

        @foreach ($portfolio as $pf)
            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ ($lang == "th") ? $pf["portfolio_name_th"] : $pf["portfolio_name_en"] }}</h3>
                    <div class="subheading mb-3">{{ $pf["portfolio_tag"] }}</div>
                    <p>{{ ($lang == "th") ? $pf["portfolio_desc_th"] : $pf["portfolio_desc_en"] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="text-primary" style="cursor: pointer" data-toggle="modal" data-target="#md_show_portfolio_{{ $pf["portfolio_seq"] }}">
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
<!-- The Modal [set Portfolio]-->
<div class="modal fade" id="SetPortfolioModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('profile.md_PortfolioHeader') }}</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('ctl.set.portfolio') }}" method="POST" id="SetPortFolioForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="lang_flag" value="{{ $lang_flag }}">

                    @if ($lang_flag == "A")

                    {{-- Get portfolio name --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioNameTH') }}</label>
                                <input type="text" name="port_name_th" id="port_name_th_id" class="form-control" placeholder="{{ trans('profile.md_ph_port_name_th') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioNameEN') }}</label>
                                <input type="text" name="port_name_en" id="port_name_en_id" class="form-control" placeholder="{{ trans('profile.md_ph_port_name_en') }}">
                            </div>
                        </div>

                    {{-- Get Description --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_desc_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioDescTH') }}</label>
                                <textarea name="port_desc_th" id="port_desc_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_port_desc_th') }}"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_desc_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioDescEN') }}</label>
                                <textarea name="port_desc_en" id="port_desc_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_port_desc_en') }}"></textarea>
                            </div>
                        </div>
                    @elseif ($lang_flag == "T")

                    {{-- Get portfolio name --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_name_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioNameTH') }}</label>
                                <input type="text" name="port_name_th" id="port_name_th_id" class="form-control" placeholder="{{ trans('profile.md_ph_port_name_th') }}">
                            </div>
                        </div>

                    {{-- Get Description --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_desc_th" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioDescTH') }}</label>
                                <textarea name="port_desc_th" id="port_desc_th_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_port_desc_th') }}"></textarea>
                            </div>
                        </div>
                    @elseif ($lang_flag == "E")

                    {{-- Get portfolio name --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_name_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioNameEN') }}</label>
                                <input type="text" name="port_name_en" id="port_name_en_id" class="form-control" placeholder="{{ trans('profile.md_ph_port_name_en') }}">
                            </div>
                        </div>

                    {{-- Get Description --}}
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="port_desc_en" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioDescEN') }}</label>
                                <textarea name="port_desc_en" id="port_desc_en_id" style="width: 100%;" rows="5" placeholder="{{ trans('profile.md_ph_port_desc_en') }}"></textarea>
                            </div>
                        </div>
                    @endif

                {{-- Get Port tag --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="port_tag" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioTag') }}</label>
                            <textarea name="port_tag" id="port_tag_id" style="width: 100%;" rows="3" placeholder="{{ trans('profile.md_ph_port_tag') }}"></textarea>
                        </div>
                    </div>

                {{-- Get images --}}
                    <div class="form-group row">
                        <label for="profile_img" class="col-md-12 col-form-label text-md-left">{{ trans('profile.md_PortfolioImages') }}</label>

                        <div class="col-md-12">
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" id="port_images_id" name="port_images[]" multiple>
                                <label class="custom-file-label" for="port_images">{{ trans('profile.md_PortfolioImageList') }}</label>
                            </div>
                            <div class="mb-2" id="RenderFilename"></div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="Javascript:ValidatePortFolio('{{ $lang_flag }}');">{{ trans('profile.BtnSave') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.BtnClose') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- The Modal [set Portfolio]-->

    @foreach ($portfolio as $md_port)

        <!-- The Modal [show portfolio image]-->
        <div class="modal fade" id="md_show_portfolio_{{ $md_port["portfolio_seq"] }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('profile.md_PortfolioImageList') }}</h4>
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
                                        <img class="img-fluid" style="width: 100%; height: 400px;" src="{{ route('GetPortImage' , ["id"=>$md_port["profile_id"] , "file_name"=> $fn]) }}">
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
    @error('port_name_th')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('port_name_en')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('port_desc_th')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('port_desc_en')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('port_tag')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror

    @error('port_images')
        <script>
            swal("{{ trans('home.Error_msg_header') }}" , "{{ $message }}" , 'error');
        </script>
    @enderror
@endsection

@section('OtherJsFunction')
    <script>
        function ValidatePortFolio(lang) {
            var formMast = document.getElementById("SetPortFolioForm");
            var validate_elements = {
                "port_name_th" : ((lang == "A" || lang == "T") ? formMast.elements["port_name_th"].value : null),
                "port_name_en" : ((lang == "A" || lang == "E") ? formMast.elements["port_name_en"].value : null),
                "port_desc_th" : ((lang == "A" || lang == "T") ? formMast.elements["port_desc_th"].value : null),
                "port_desc_en" : ((lang == "A" || lang == "E") ? formMast.elements["port_desc_en"].value : null),
                "port_tag" : formMast.elements["port_tag"].value,
                "port_images" : formMast.elements["port_images[]"].files,
            };

            if ((validate_elements["port_name_th"] == null || validate_elements["port_name_th"] == "") || (validate_elements["port_name_en"] == null || validate_elements["port_name_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_validate_port_name') }}" , "error");
            } else if ((validate_elements["port_desc_th"] == null || validate_elements["port_desc_th"] == "") || (validate_elements["port_desc_en"] == null || validate_elements["port_desc_en"] == "")) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_validate_port_desc') }}" , "error");
            } else if (validate_elements["port_tag"] == null || validate_elements["port_tag"] == "") {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_validate_port_tag') }}" , "error");
            } else if (validate_elements["port_images"].length < 1) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_validate_port_img_req') }}" , "error");
            } else if (validate_elements["port_images"].length > 5) {
                swal("{{ trans('profile.AlertError') }}" , "{{ trans('profile.js_validate_port_img_max') }}" , "error");
            } else {
                formMast.submit();
            }

        }

        $(".custom-file-input").on("change", function() {
            var fileName = document.getElementById("port_images_id").files;
            var cnt_file = fileName.length;

            if (cnt_file > 5) {
                var html = '<p style="color:red">{{ trans("profile.js_file_count_true") }} ' + cnt_file + ' / 5 {{ trans("profile.js_file_text") }}</p>';
            } else {
                var html = '<p style="color:green">{{ trans("profile.js_file_count_true") }} ' + cnt_file + ' / 5 {{ trans("profile.js_file_text") }}</p>';
            }

            document.getElementById("RenderFilename").innerHTML = html;
        });
        // Show image name
    </script>
@endsection
