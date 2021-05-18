@extends('Profile.template.1.0-master')

@section('section')
<section class="resume-section" id="about">
    <div class="resume-section-content">
        @php
            if (Config::get('app.locale') == "th") {
                $tmp_name = explode(" " , Auth::user()->name_th);
            } else {
                $tmp_name = explode(" " , Auth::user()->name_en);
            }
        @endphp
        <h1 class="mb-0">
            {{ max($tmp_name) }}
            <span class="text-primary">{{ min($tmp_name) }}</span>
        </h1>
        <div class="subheading mb-5">
            3542 Berry Street · Cheyenne Wells, CO 80810 · (317) 585-8468 ·
            <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
        </div>
        <p class="lead mb-5">{{ Auth::user()->about }}</p>
        <div class="social-icons">
            <a class="social-icon" href="#"><i class="fab fa-linkedin-in"></i></a>
            <a class="social-icon" href="#"><i class="fab fa-github"></i></a>
            <a class="social-icon" href="#"><i class="fab fa-twitter"></i></a>
            <a class="social-icon" href="#"><i class="fab fa-facebook-f"></i></a>
        </div>
    </div>
</section>
@endsection
