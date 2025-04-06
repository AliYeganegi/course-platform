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
                @if ($course->file_path)
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
                {{-- Enrollment Status --}}
                <div class="card shadow-sm rounded p-3 mb-4">
                    <h5 class="mb-2">{{ __('cruds.enrollment.fields.status') }}</h5>
                    @php
                        $status = optional($course->enrollment)->status;
                        $statusColor = [
                            'pending' => 'warning',
                            'accepted' => 'success',
                            'rejected' => 'danger',
                        ][$status] ?? 'secondary';
                    @endphp
                    <span class="badge badge-{{ $statusColor }} text-capitalize">
                        {{ $status ? __($status) : __('cruds.enrollment.not_enrolled') }}
                    </span>
                </div>

                @if ($status === 'accepted')
                    {{-- Show course link and file --}}
                    <div class="card shadow-sm rounded p-3">
                        @if ($course->course_link)
                            <h5 class="mb-2">{{ __('cruds.course.fields.course_link') }}</h5>
                            <a href="{{ $course->course_link }}" target="_blank" class="btn btn-success w-100 mb-3">
                                {{ __('cruds.course.fields.access_course') }}
                            </a>
                        @endif

                        @if ($course->course_file)
                            <h5 class="mb-2">{{ __('cruds.course.fields.course_file') }}</h5>
                            <a href="{{ asset('storage/' . $course->course_file) }}" download class="btn btn-primary w-100">
                                {{ __('cruds.course.download_material') }}
                            </a>
                        @endif
                    </div>
                @else
                    {{-- Show Institution, Fee, Enroll --}}
                    <div class="card shadow-sm rounded p-3">
                        <ul class="list-unstyled mb-3">
                            @if ($course->institution)
                                <li class="mb-2">
                                    <strong>{{ __('main.institution') }}:</strong>
                                    <span class="float-right">{{ $course->institution->name }}</span>
                                </li>
                            @endif
                            <li class="mb-2">
                                <strong>{{ __('main.course_fee') }}:</strong>
                                <span class="float-right">{{ $course->getPrice() }}</span>
                            </li>
                        </ul>
                        <a href="{{ route('enroll.create', $course->id) }}" class="btn btn-primary btn-block">
                            {{ __('main.enroll') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
