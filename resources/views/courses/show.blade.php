@extends('layouts.main')

@section('content')

<section class="course_details_area section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 course_details_left">
                <div class="main_image">
                    <img class="img-fluid" src="{{ optional($course->photo)->getUrl() ?? asset('img/no_image.png') }}" alt="">
                </div>
                <div class="content_wrapper">
                    <h4 class="title_top">{{ __('main.description') }}</h4>
                    <div class="content">
                        {{ $course->description ?? 'No description provided' }}
                    </div>
                </div>

                <!-- File Download Section -->
                @if($course->file_path)
                <div class="content_wrapper mt-4">
                    <h4 class="title_top">{{ __('main.download_material') }}</h4>
                    <div class="content">
                        <a href="{{ asset('storage/' . $course->file_path) }}" class="btn btn-primary" download>
                            {{ __('main.download_file') }}
                        </a>
                    </div>
                </div>
                @endif

            </div>

            <div class="col-lg-4 right-contents">
                <div class="sidebar_top">
                    <ul>
                        @if($course->institution)
                            <li>
                                <a class="justify-content-between d-flex">
                                    <p>{{ __('main.institution') }}</p>
                                    <span class="color">{{ $course->institution->name }}</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="justify-content-between d-flex">
                                <p>{{ __('main.course_fee') }}</p>
                                <span>{{ $course->getPrice() }}</span>
                            </a>
                        </li>
                    </ul>
                    <a href="{{ route('enroll.create', $course->id) }}" class="btn_1 d-block">{{ __('main.enroll') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
