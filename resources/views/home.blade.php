@extends('layouts.main')

@section('content')
    <section class="special_cource padding_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <p>{{ __('main.courses') }}</p>
                        <h2>{{ __('main.newest_courses') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($newestCourses as $course)
                    <div class="col-sm-6 col-lg-4">
                        <div class="single_special_cource">
                            <img src="{{ $course->photo ? $course->photo->getUrl() : asset('img/no_image.png') }}"
                                class="special_img" alt="">
                            <div class="special_cource_text">
                                <h4>{{ $course->getPrice() }}</h4>
                                <a href="{{ route('courses.show', $course->id) }}">
                                    <h3>{{ $course->name }}</h3>
                                </a>
                                <p>{{ Str::limit($course->description, 100) }}</p>
                                @foreach ($course->disciplines as $discipline)
                                    <a href="{{ route('courses.index') }}?discipline={{ $discipline->id }}"
                                        class="btn_3 mr-1 mb-1">{{ $discipline->name }}</a>
                                @endforeach
                                @if ($course->institution)
                                    <div class="author_info">
                                        <div class="author_img">
                                            <img src="{{ optional($course->institution->logo)->thumbnail ?? asset('img/no_image.png') }}"
                                                alt="" class="rounded-circle">
                                            <div class="author_info_text">
                                                <p>{{ __('main.institution') }}</p>
                                                <h5><a
                                                        href="{{ route('courses.index') }}?institution={{ $course->institution->id }}">{{ $course->institution->name }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <section class="blog_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <p>{{ __('main.institutions') }}</p>
                        <h2>{{ __('main.random_institutions') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($randomInstitutions as $institution)
                    <div class="col-sm-6 col-lg-4 col-xl-4">
                        <div class="single-home-blog">
                            <div class="card">
                                <img src="{{ optional($institution->logo)->url ?? asset('img/no_image.png') }}"
                                    class="card-img-top" alt="{{ $institution->name }}">
                                <div class="card-body">
                                    <a href="{{ route('courses.index') }}?institution={{ $institution->id }}">
                                        <h5 class="card-title">{{ $institution->name }}</h5>
                                    </a>
                                    <p>{{ Str::limit($institution->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
