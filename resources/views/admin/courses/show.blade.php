@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.course.title') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.id') }}
                            </th>
                            <td>
                                {{ $course->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.name') }}
                            </th>
                            <td>
                                {{ $course->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.description') }}
                            </th>
                            <td>
                                {!! $course->description !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.photo') }}
                            </th>
                            <td>
                                @if ($course->photo)
                                    <a href="{{ $course->photo->getUrl() }}" target="_blank">
                                        <img src="{{ $course->photo->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.institution') }}
                            </th>
                            <td>
                                {{ $course->institution->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.price') }}
                            </th>
                            <td>
                                ${{ $course->price }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.instructor') }}
                            </th>
                            <td>
                                {{ $course->instructor->name ?? 'Not assigned' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.course_topics') }}
                            </th>
                            <td>
                                @foreach (preg_split("/\r\n|\n|\r/", $course->course_topics ?? '') as $topic)
                                    <span class="label label-info label-many">{{ $topic }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.learning_outcomes') }}
                            </th>
                            <td>
                                {!! $course->learning_outcomes !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.target_audience') }}
                            </th>
                            <td>
                                {!! $course->target_audience !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.course_duration') }}
                            </th>
                            <td>
                                {{ $course->course_duration }} hours
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.prerequisites') }}
                            </th>
                            <td>
                                {!! $course->prerequisites !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Disciplines
                            </th>
                            <td>
                                @foreach ($course->disciplines as $id => $disciplines)
                                    <span class="label label-info label-many">{{ $disciplines->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            <!-- Quizzes Section -->
            @if ($course->examinations && $course->examinations->count() > 0)
                <div class="mt-5">
                    <h5>{{ trans('cruds.examination.title') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('cruds.examination.fields.name') }}</th>
                                    <th>{{ trans('cruds.examination.fields.description') }}</th>
                                    <th>{{ trans('cruds.examination.fields.number_of_questions') }}</th>
                                    <th>{{ trans('cruds.examination.fields.exam_duration') }}</th>
                                    <th>{{ trans('cruds.examination.fields.total_point') }}</th>
                                    <th>{{ trans('cruds.examination.fields.quiz_link') }}</th>
                                    <th>{{ trans('cruds.examination.fields.quiz_status') }}</th>
                                    <th>{{ trans('cruds.examination.fields.quiz_start_datetime') }}</th>
                                    <th>{{ trans('cruds.examination.fields.quiz_end_datetime') }}</th>
                                    <th>{{ trans('cruds.examination.fields.quiz_number_of_attempts') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($course->examinations as $exam)
                                    <tr>
                                        <td>{{ $exam->name }}</td>
                                        <td>{{ $exam->description }}</td>
                                        <td>{{ $exam->number_of_questions }}</td>
                                        <td>{{ $exam->exam_duration }} mins</td>
                                        <td>{{ $exam->total_point }}</td>
                                        <td><a href="{{ $exam->quiz_link }}" target="_blank">{{ $exam->quiz_link }}</a>
                                        </td>
                                        <td>{{ ucfirst($exam->quiz_status) }}</td>
                                        <td>{{ $exam->quiz_start_datetime ? date('Y-m-d H:i', strtotime($exam->quiz_start_datetime)) : '' }}
                                        </td>
                                        <td>{{ $exam->quiz_end_datetime ? date('Y-m-d H:i', strtotime($exam->quiz_end_datetime)) : '' }}
                                        </td>
                                        <td>{{ $exam->quiz_number_of_attempts }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Comments Section -->
            <div class="mt-4">
                <h5>Comments</h5>

                @foreach ($course->comments()->whereNull('parent_id')->get() as $comment)
                    <div class="card p-3 mb-3 shadow-sm rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mt-2">{{ $comment->content }}</p>

                        <!-- Like Button -->
                        <form method="POST" action="{{ route('comments.like', $comment->id) }}" class="d-inline-block">
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
                                <button type="submit" class="btn btn-primary btn-sm">Reply</button>
                            </div>
                        </form>

                        <!-- Show Replies -->
                        @foreach ($comment->replies as $reply)
                            <div class="ml-4 mt-2 p-2 bg-light rounded">
                                <strong>{{ $reply->user->name }}</strong>:
                                <p class="mb-0">{{ $reply->content }}</p>
                                <form method="POST" action="{{ route('comments.delete', $reply->id) }}"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Reply</button>
                                </form>
                            </div>
                        @endforeach

                        <!-- Delete Comment -->
                        <form method="POST" action="{{ route('comments.delete', $comment->id) }}"
                            class="d-inline-block mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete Comment</button>
                        </form>
                    </div>
                @endforeach
            </div>
            @auth
                <div class="card p-3 mt-4 shadow-sm rounded">
                    <h6>Post a Comment</h6>
                    <form action="{{ route('courses.comment', $course->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="4" placeholder="Add a comment..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
@endsection
