@extends('layouts.main')

@section('content')
    <section class="special_cource padding_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <h2>{{ __('main.enrollment_application') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($userEnrollments as $enrollment)
                    <div class="col-sm-6 col-lg-4">
                        <div class="single_special_cource">
                            <img src="{{ optional($enrollment->course->photo)->getUrl() ?? asset('img/no_image.png') }}"
                                class="special_img" alt="">
                            <div class="special_cource_text">
                                <h4>{{ $enrollment->course->getPrice() }}</h4>
                                <a href="{{ route('courses.show', $enrollment->course->id) }}">
                                    <h3>{{ $enrollment->course->name }}</h3>
                                </a>
                                <p>{{ Str::limit($enrollment->course->description, 100) }}</p>
                                @foreach ($enrollment->course->disciplines as $discipline)
                                    <a href="{{ route('courses.index') }}?discipline={{ $discipline->id }}"
                                        class="btn_3 mr-1 mb-1">{{ $discipline->name }}</a>
                                @endforeach
                                @if ($enrollment->course->institution)
                                    <div class="author_info">
                                        <div class="author_img">
                                            <img src="{{ optional($enrollment->course->institution->logo)->thumbnail ?? asset('img/no_image.png') }}"
                                                alt="" class="rounded-circle">
                                            <div class="author_info_text">
                                                <p>{{ __('main.institution') }}</p>
                                                <h5><a
                                                        href="{{ route('courses.index') }}?institution={{ $enrollment->course->institution->id }}">{{ $enrollment->course->institution->name }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="author_info">
                                    <p>{{ __('main.status') }}</p>
                                    <h5>{{ App\Enrollment::STATUS_RADIO[$enrollment->status] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="float-right">
                        {{ $userEnrollments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
