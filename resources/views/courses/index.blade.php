@extends('layouts.main')

@section('content')
    <section class="special_cource padding_top">
        <div class="container">

            @if ($institution)
            <div class="row justify-content-center mb-5">
                <div class="col-xl-10">
                    <div class="card p-4 shadow-lg text-center">
                        <h2 class="mb-3">{{ $institution->name }}</h2>
                        <p class="mb-3 text-muted">{{ $institution->description }}</p>
                        <img src="{{ optional($institution->logo)->getUrl() ?? asset('img/no_image.png') }}"
                            alt="Institution Logo" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </div>
            </div>
        @endif


            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <h2>{{ __('main.courses') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($courses as $course)
                <div class="col-sm-6 col-lg-4 d-flex">
                    <div class="single_special_cource flex-fill d-flex flex-column mt-5">
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
                                        class="btn_3 mr-1 mb-1 mt-2">{{ $discipline->name }}</a>
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

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="float-right">
                        {{ $courses->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
