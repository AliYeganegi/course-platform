@extends('layouts.main')

@section('content')

    <section class="course_details_area section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 course_details_left">
                    <div class="main_image">
                        <img class="img-fluid" src="{{ optional($course->photo)->getUrl() ?? asset('img/no_image.png') }}"
                            alt="">
                    </div>

                    {{-- Enrollment Status --}}
                    <div class="card shadow-sm rounded p-3 mt-4">
                        <h5 class="mb-2 text-center">{{ __('cruds.enrollment.fields.status') }}</h5>
                        @php
                            $status = optional($course->enrollment)->status;
                            $statusColor =
                                [
                                    'pending' => 'warning',
                                    'accepted' => 'success',
                                    'rejected' => 'danger',
                                ][$status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $statusColor }} text-capitalize">
                            {{ $status ? __($status) : __('cruds.enrollment.not_enrolled') }}
                        </span>
                    </div>

                    <!-- File Download Section -->
                    @if ($course->file_path)
                        <div class="content_wrapper mt-4">
                            <h4 class="title_top text-center">{{ __('main.download_material') }}</h4>
                            <div class="content">
                                <a href="{{ asset('storage/' . $course->file_path) }}" class="btn btn-primary" download>
                                    {{ __('main.download_file') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @php
                        $status = optional($course->enrollment)->status;
                        $statusColor =
                            [
                                'pending' => 'warning',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                            ][$status] ?? 'secondary';
                    @endphp
                    @if ($status === 'accepted')
                        {{-- Show course link and file --}}
                        <div class="card shadow-sm rounded p-3 mt-4">
                            @if ($course->course_link)
                                <h5 class="mb-2 text-center">{{ __('cruds.course.fields.course_link') }}</h5>
                                <a href="{{ $course->course_link }}" target="_blank" class="btn btn-success w-100 mb-3">
                                    {{ __('cruds.course.fields.access_course') }}
                                </a>
                            @endif

                            @if ($course->course_file)
                                <h5 class="mb-2 text-center">{{ __('cruds.course.fields.course_file') }}</h5>
                                <a href="{{ asset('storage/' . $course->course_file) }}" download
                                    class="btn btn-primary w-100">
                                    {{ __('cruds.course.download_material') }}
                                </a>
                            @endif
                        </div>
                    @else
                        {{-- Show Institution, Fee, Enroll --}}
                        <div class="card shadow-sm rounded p-3 mt-4">
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

                    <div class="card shadow-sm rounded p-3 mb-4 mt-4">
                        <h5 class="mt-4 mb-3 text-center">{{ trans('global.comment') }}</h5>

                        @foreach ($course->comments()->whereNull('parent_id')->get() as $comment)
                            <div class="card p-3 mb-3 shadow-sm rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mt-2">{{ $comment->content }}</p>

                                @auth
                                    <!-- Like Button with icon -->
                                    <form method="POST" action="{{ route('comments.like', $comment->id) }}"
                                        class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-thumbs-up"></i> Like ({{ $comment->likes->count() }})
                                        </button>
                                    </form>


                                    <!-- Reply Form -->
                                    <form method="POST" action="{{ route('comments.reply', $comment->id) }}" class="mt-2">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="content" class="form-control form-control-sm"
                                                placeholder="Reply..." required>
                                            <button type="submit"
                                                class="btn btn-primary btn-sm">{{ trans('global.reply') }}</button>
                                        </div>
                                    </form>
                                @endauth

                                <!-- Show Replies -->
                                @foreach ($comment->replies as $reply)
                                    <div class="ml-4 mt-2 p-2 bg-light rounded">
                                        <strong>{{ $reply->user->name }}</strong>:
                                        <p class="mb-0">{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        @auth
                            <div class="card p-3 mt-4 shadow-sm rounded">
                                <h6>{{ trans('global.post_comment') }}</h6>
                                <form action="{{ route('courses.comment', $course->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="content" class="form-control" rows="4" placeholder="Add a comment..." required></textarea>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary mt-2">{{ trans('global.post_comment') }}</button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>


                <div class="col-lg-8 right-contents">
                    <div class="card shadow-sm rounded p-3 mb-4">

                        <div class="content_wrapper mt-4">
                            <h5 class="mb-2 text-center">{{ __('main.description') }}</h4>
                                <div class="content text-center">
                                    {{ $course->description ?? '-----------------------------------------' }}
                                </div>
                        </div>

                        <!-- Learning Outcomes -->
                        <div class="content_wrapper mt-4">
                            <h5 class="mb-2 text-center">{{ __('cruds.course.fields.learning_outcomes') }}</h4>
                                <div class="content text-center">
                                    @if ($course->learning_outcomes)
                                        <p>{{ $course->learning_outcomes }}</p>
                                    @else
                                        <p>-----------------------------------------</p>
                                    @endif
                                </div>
                        </div>
                        <div class="content_wrapper mt-4">
                            <h5 class="mb-2 text-center">{{ __('cruds.course.fields.target_audience') }}</h4>
                                <div class="content text-center">
                                    @if ($course->target_audience)
                                        @foreach (preg_split("/\r\n|\n|\r/", $course->target_audience ?? '') as $audience)
                                            @if (trim($audience))
                                                <p>{{ trim($audience) }}</p>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>-----------------------------------------</p>
                                    @endif
                                </div>
                        </div>

                        <!-- Course Duration -->
                        <div class="content_wrapper mt-4">
                            <h5 class="mb-2 text-center">{{ __('cruds.course.fields.course_duration') }}</h4>
                                <div class="content text-center">
                                    {{ $course->course_duration ?? '------------------------------' }}
                                </div>
                        </div>

                        {{-- Course Instructor --}}
                        <div class="content_wrapper mt-4">
                            <h5 class="mb-2 text-center">{{ __('cruds.course.fields.instructor') }}</h4>
                                <div class="content text-center">
                                    {{ $course->instructor->name ?? '------------------------------' }}
                                </div>
                        </div>

                        {{-- course_topics --}}
                        <div class="content_wrapper mt-4">
                            <h5 class="mb-2 text-center">{{ __('cruds.course.fields.course_topics') }}</h4>
                                <div class="content text-center">
                                    @if ($course->course_topics)
                                        @foreach (preg_split("/\r\n|\n|\r/", $course->course_topics ?? '') as $topic)
                                            <p>{{ $topic }}</p>
                                        @endforeach
                                    @else
                                        <p>-----------------------------------------</p>
                                    @endif
                                </div>
                        </div>

                        {{-- prerequisites --}}
                        <div class="content_wrapper mt-4">
                            <h5 class="mb-2 text-center">{{ __('cruds.course.fields.prerequisites') }}</h4>
                                <div class="content text-center">
                                    @if ($course->prerequisites)
                                        @foreach (preg_split("/\r\n|\n|\r/", $course->prerequisites ?? '') as $prerequisite)
                                            <p>{{ $prerequisite }}</p>
                                        @endforeach
                                    @else
                                        <p>-----------------------------------------</p>
                                    @endif
                                </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded p-3 mb-4">
                        {{-- Quiz/Examination Section --}}
                        @if ($course->examinations->count())
                            <div class="content_wrapper mt-4">
                                <h5 class="mb-2 text-center">{{ __('cruds.examination.title') }}</h5>
                                <div class="content">
                                    @foreach ($course->examinations as $exam)
                                        <div class="card p-3 mb-3 shadow-sm rounded">
                                            <h6 class="text-center">{{ __('cruds.examination.fields.quiz_link') }}</h6>
                                            <a href="{{ $exam->quiz_link }}" target="_blank"
                                                class="btn btn-outline-primary mb-2">
                                                {{ __('cruds.examination.access_quiz') }}
                                            </a>

                                            <ul class="list-unstyled small">
                                                <li>
                                                    <strong>{{ __('cruds.examination.fields.quiz_status') }}:</strong>
                                                    <span
                                                        class="badge bg-{{ $exam->quiz_status === 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($exam->quiz_status) }}
                                                    </span>
                                                </li>
                                                <li>
                                                    <strong>{{ __('cruds.examination.fields.quiz_start_datetime') }}:</strong>
                                                    {{ \Carbon\Carbon::parse($exam->quiz_start_datetime)->format('d M Y, H:i') }}
                                                </li>
                                                <li>
                                                    <strong>{{ __('cruds.examination.fields.quiz_end_datetime') }}:</strong>
                                                    {{ \Carbon\Carbon::parse($exam->quiz_end_datetime)->format('d M Y, H:i') }}
                                                </li>
                                                <li>
                                                    <strong>{{ __('cruds.examination.fields.quiz_number_of_attempts') }}:</strong>
                                                    {{ $exam->quiz_number_of_attempts }}
                                                </li>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </section>

@endsection
