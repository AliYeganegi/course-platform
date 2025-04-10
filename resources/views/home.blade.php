@extends('layouts.main')

@section('content')
    <section class="special_cource padding_top">
        <div class="container">
            <div class="row justify-content-center align-items-center mb-5">
                <!-- Left Side: Image -->
                <div class="col-md-6 mt-3">
                    <img src="{{ asset('img/home_page_image.png') }}" alt="Robotics for Kids" class="img-fluid">
                </div>

                <!-- Right Side: Details -->
                <div class="col-md-6 mt-3">
                    <div class="section_tittle">
                        <h2 class="mb-2 text-center">{{ trans('main.start_journey') }}</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fa fa-robot fa-3x" aria-hidden="true"></i>
                                <h4 class="text-center">{{ trans('main.start_building') }}</h4>
                                <p class="text-center">{{ trans('main.start_building_text') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fa fa-cogs fa-3x mb-3" aria-hidden="true"></i>
                                <h4 class="text-center">{{ trans('main.hand_on_learning') }}</h4>
                                <p class="text-center">{{ trans('main.hand_on_learning_text') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fa fa-trophy fa-3x mb-3" aria-hidden="true"></i>
                                <h4 class="text-center">{{ trans('main.fun_challenges') }}</h4>
                                <p class="text-center">{{ trans('main.fun_challenges_text') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="fa fa-users fa-3x mb-3" aria-hidden="true"></i>
                                <h4 class="text-center">{{ trans('main.support') }}</h4>
                                <p class="text-center">{{ trans('main.support_text') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                <div class="col-sm-6 col-lg-4 d-flex">
                    <div class="single_special_cource flex-fill d-flex flex-column">
                            <img src="{{ $course->photo ? $course->photo->getUrl() : asset('img/no_image.png') }}"
                                class="special_img fixed-course-img" alt="">
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
                <div class="col-sm-6 col-lg-4 col-xl-4 d-flex">
                    <div class="single-home-blog flex-fill d-flex flex-column">
                        <div class="card h-100 d-flex flex-column">
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
