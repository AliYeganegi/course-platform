@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.course.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.courses.update', [$course->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.course.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($course) ? $course->name : '') }}" required>
                    @if ($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.course.fields.name_helper') }}
                    </p>
                </div>

                <!-- Description Field -->
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label for="description">{{ trans('cruds.course.fields.description') }}</label>
                    <textarea id="description" name="description" class="form-control ">{{ old('description', isset($course) ? $course->description : '') }}</textarea>
                    @if ($errors->has('description'))
                        <em class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.course.fields.description_helper') }}
                    </p>
                </div>

                <!-- Photo Field -->
                <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                    <label for="photo">{{ trans('cruds.course.fields.photo') }}</label>
                    <div class="needsclick dropzone" id="photo-dropzone"></div>
                    @if ($errors->has('photo'))
                        <em class="invalid-feedback">
                            {{ $errors->first('photo') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.course.fields.photo_helper') }}
                    </p>
                </div>

                <!-- New fields start -->
                <div class="form-group {{ $errors->has('learning_outcomes') ? 'has-error' : '' }}">
                    <label for="learning_outcomes">{{ trans('cruds.course.fields.learning_outcomes') }}</label>
                    <textarea id="learning_outcomes" name="learning_outcomes" class="form-control">{{ old('learning_outcomes', isset($course) ? $course->learning_outcomes : '') }}</textarea>
                    @if ($errors->has('learning_outcomes'))
                        <em class="invalid-feedback">
                            {{ $errors->first('learning_outcomes') }}
                        </em>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('target_audience') ? 'has-error' : '' }}">
                    <label for="target_audience">{{ trans('cruds.course.fields.target_audience') }}</label>
                    <textarea id="target_audience" name="target_audience" class="form-control">{{ old('target_audience', isset($course) ? $course->target_audience : '') }}</textarea>
                    @if ($errors->has('target_audience'))
                        <em class="invalid-feedback">
                            {{ $errors->first('target_audience') }}
                        </em>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('instructor_id') ? 'has-error' : '' }}">
                    <label for="instructor_id">{{ trans('cruds.course.fields.instructor') }}</label>
                    <select name="instructor_id" id="instructor_id" class="form-control select2">
                        <option value="">Select Instructor</option>
                        @foreach ($users as $id => $instructor)
                            <option value="{{ $id }}"
                                {{ (isset($course) && $course->instructor_id == $id) || old('instructor_id') == $id ? 'selected' : '' }}>
                                {{ $instructor }}
                            </option>
                        @endforeach
                    </select>

                    @if ($errors->has('instructor_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('instructor_id') }}
                        </em>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('course_duration') ? 'has-error' : '' }}">
                    <label for="course_duration">{{ trans('cruds.course.fields.course_duration') }}</label>
                    <input type="text" id="course_duration" name="course_duration" class="form-control"
                        value="{{ old('course_duration', isset($course) ? $course->course_duration : '') }}">
                    @if ($errors->has('course_duration'))
                        <em class="invalid-feedback">
                            {{ $errors->first('course_duration') }}
                        </em>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('course_topics') ? 'has-error' : '' }}">
                    <label for="course_topics">{{ trans('cruds.course.fields.course_topics') }}</label>
                    <textarea id="course_topics" name="course_topics" class="form-control">{{ old('course_topics', isset($course) ? $course->course_topics : '') }}</textarea>
                    @if ($errors->has('course_topics'))
                        <em class="invalid-feedback">
                            {{ $errors->first('course_topics') }}
                        </em>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('prerequisites') ? 'has-error' : '' }}">
                    <label for="prerequisites">{{ trans('cruds.course.fields.prerequisites') }}</label>
                    <textarea id="prerequisites" name="prerequisites" class="form-control">{{ old('prerequisites', isset($course) ? $course->prerequisites : '') }}</textarea>
                    @if ($errors->has('prerequisites'))
                        <em class="invalid-feedback">
                            {{ $errors->first('prerequisites') }}
                        </em>
                    @endif
                </div>
                <!-- New fields end -->

                <!-- Institution Field -->
                @if (auth()->user()->isInstitution())
                    <input type="hidden" name="institution_id" value="{{ auth()->user()->institution_id }}">
                @else
                    <div class="form-group {{ $errors->has('institution_id') ? 'has-error' : '' }}">
                        <label for="institution">{{ trans('cruds.course.fields.institution') }}*</label>
                        <select name="institution_id" id="institution" class="form-control select2" required>
                            @foreach ($institutions as $id => $institution)
                                <option value="{{ $id }}"
                                    {{ (isset($course) && $course->institution ? $course->institution->id : old('institution_id')) == $id ? 'selected' : '' }}>
                                    {{ $institution }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('institution_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('institution_id') }}
                            </em>
                        @endif
                    </div>
                @endif

                <!-- Price Field -->
                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                    <label for="price">{{ trans('cruds.course.fields.price') }}</label>
                    <input type="number" id="price" name="price" class="form-control"
                        value="{{ old('price', isset($course) ? $course->price : '') }}" step="0.01">
                    @if ($errors->has('price'))
                        <em class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.course.fields.price_helper') }}
                    </p>
                </div>

                <!-- Course Link Field -->
                <div class="form-group {{ $errors->has('course_link') ? 'has-error' : '' }}">
                    <label for="course_link">{{ trans('cruds.course.fields.course_link') }}</label>
                    <input type="url" id="course_link" name="course_link" class="form-control"
                        value="{{ old('course_link', isset($course) ? $course->course_link : '') }}">
                    @if ($errors->has('course_link'))
                        <em class="invalid-feedback">
                            {{ $errors->first('cruds.course.fields.course_link') }}
                        </em>
                    @endif
                </div>

                <!-- Disciplines Field -->
                <div class="form-group {{ $errors->has('disciplines') ? 'has-error' : '' }}">
                    <label for="disciplines">{{ trans('cruds.course.fields.disciplines') }}
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="disciplines[]" id="disciplines" class="form-control select2" multiple="multiple">
                        @foreach ($disciplines as $id => $disciplines)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('disciplines', [])) || (isset($course) && $course->disciplines->contains($id)) ? 'selected' : '' }}>
                                {{ $disciplines }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('disciplines'))
                        <em class="invalid-feedback">
                            {{ $errors->first('disciplines') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.course.fields.disciplines_helper') }}
                    </p>
                </div>

                <!-- Course File Field -->
                <div class="form-group {{ $errors->has('course_file') ? 'has-error' : '' }}">
                    <label for="course_file">{{ trans('cruds.course.fields.course_file') }}</label>

                    <!-- Display existing file if there is one -->
                    @if (isset($course) && $course->course_file)
                        <div class="mt-2">
                            <strong>{{ trans('cruds.course.current_file') }}</strong>
                            <a href="{{ asset('storage/' . $course->course_file) }}" target="_blank">
                                {{ basename($course->course_file) }}
                            </a>
                            <button type="button" id="remove-existing-course-file"
                                class="btn btn-sm btn-danger ml-2">{{ trans('cruds.course.file_remove') }}</button>
                            <input type="hidden" name="remove_course_file" id="remove_course_file" value="0">
                        </div>
                    @endif

                    <!-- File input for uploading new course file -->
                    <input type="file" name="course_file" class="form-control" id="course_file_input">

                    <button type="button" id="clear-course-file"
                        class="btn btn-sm btn-warning mt-2">{{ trans('cruds.course.chosen_file_remove') }}</button>

                    @if ($errors->has('course_file'))
                        <em class="invalid-feedback">
                            {{ $errors->first('course_file') }}
                        </em>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>

            </form>

            <!-- Examination Section -->
            <div class="card mt-5">
                <div class="card-header">
                    {{ trans('cruds.examination.title') }}
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="card-body">
                            <!-- List existing examinations -->
                            @if (isset($course) && $course->examinations && $course->examinations->count() > 0)
                                <div class="table-responsive mb-4">
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
                                                <th>{{ trans('global.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody>
                                            @foreach ($course->examinations as $exam)
                                                <tr>
                                                    <form action="{{ route('admin.examinations.update', $exam->id) }}"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}')"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="course_id"
                                                            value="{{ $course->id }}">

                                                        <td>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ old('name', $exam->name) }}"
                                                                placeholder="Exam Name" style="min-width: 200px;">
                                                        </td>
                                                        <td>
                                                            <textarea name="description" style="min-width: 200px;" class="form-control" rows="2"
                                                                placeholder="Description">{{ old('description', $exam->description) }}</textarea>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="number_of_questions"
                                                                class="form-control"
                                                                value="{{ old('number_of_questions', $exam->number_of_questions) }}"
                                                                min="1" style="min-width: 200px;">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="exam_duration"
                                                                class="form-control"
                                                                value="{{ old('exam_duration', $exam->exam_duration) }}"
                                                                min="1" placeholder="In minutes"
                                                                style="min-width: 200px;">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="total_point" class="form-control"
                                                                value="{{ old('total_point', $exam->total_point) }}"
                                                                min="1" style="min-width: 200px;">
                                                        </td>

                                                        <td>
                                                            <input type="url" name="quiz_link" class="form-control"
                                                                value="{{ old('quiz_link', $exam->quiz_link) }}"
                                                                style="min-width: 200px;">
                                                        </td>
                                                        <td>
                                                            <select name="quiz_status" class="form-control"
                                                                style="min-width: 200px;">
                                                                <option value="active"
                                                                    {{ $exam->quiz_status == 'active' ? 'selected' : '' }}>
                                                                    Active</option>
                                                                <option value="inactive"
                                                                    {{ $exam->quiz_status == 'inactive' ? 'selected' : '' }}>
                                                                    Inactive</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="datetime-local" name="quiz_start_datetime"
                                                                class="form-control"
                                                                value="{{ old('quiz_start_datetime', \Carbon\Carbon::parse($exam->quiz_start_datetime)->format('Y-m-d\TH:i')) }}">
                                                        </td>
                                                        <td>
                                                            <input type="datetime-local" name="quiz_end_datetime"
                                                                class="form-control"
                                                                value="{{ old('quiz_end_datetime', \Carbon\Carbon::parse($exam->quiz_end_datetime)->format('Y-m-d\TH:i')) }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="quiz_number_of_attempts"
                                                                class="form-control" style="min-width: 200px;"
                                                                value="{{ old('quiz_number_of_attempts', $exam->quiz_number_of_attempts) }}"
                                                                min="1">
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-primary">{{ trans('global.update') }}</button>
                                                            </div>
                                                    </form>

                                                    <form action="{{ route('admin.examinations.destroy', $exam->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}')"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">{{ trans('global.delete') }}</button>
                                                    </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">{{ trans('cruds.examination.no_examinations') }}</p>
                            @endif

                            <!-- Add new examination -->
                            <h5 class="mt-3">{{ trans('cruds.examination.add_new') }}</h5>

                            <!-- Toggle Button -->
                            <button class="btn btn-sm btn-success mb-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#newExamForm" aria-expanded="false" aria-controls="newExamForm">
                                {{ trans('cruds.examination.add_new') }}
                            </button>

                            <!-- Collapsible Form Section -->
                            <div class="collapse" id="newExamForm">
                                <form action="{{ route('admin.examinations.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                                    <div class="form-group">
                                        <label for="name">{{ trans('cruds.examination.fields.name') }}</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name', '') }}">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="description">{{ trans('cruds.examination.fields.description') }}</label>
                                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', '') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="number_of_questions">{{ trans('cruds.examination.fields.number_of_questions') }}</label>
                                        <input type="number" id="number_of_questions" name="number_of_questions"
                                            class="form-control" value="{{ old('number_of_questions', 10) }}"
                                            min="1">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="exam_duration">{{ trans('cruds.examination.fields.exam_duration') }}</label>
                                        <input type="number" id="exam_duration" name="exam_duration"
                                            class="form-control" value="{{ old('exam_duration', 30) }}" min="1">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="total_point">{{ trans('cruds.examination.fields.total_point') }}</label>
                                        <input type="number" id="total_point" name="total_point" class="form-control"
                                            value="{{ old('total_point', 100) }}" min="0" step="0.01">
                                    </div>

                                    <div class="form-group">
                                        <label for="quiz_link">{{ trans('cruds.examination.fields.quiz_link') }}</label>
                                        <input type="url" id="quiz_link" name="quiz_link" class="form-control"
                                            value="{{ old('quiz_link', '') }}">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="quiz_status">{{ trans('cruds.examination.fields.quiz_status') }}</label>
                                        <select name="quiz_status" id="quiz_status" class="form-control">
                                            <option value="active"
                                                {{ old('quiz_status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive"
                                                {{ old('quiz_status', 'inactive') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="quiz_start_datetime">{{ trans('cruds.examination.fields.quiz_start_datetime') }}</label>
                                        <input type="datetime-local" id="quiz_start_datetime" name="quiz_start_datetime"
                                            class="form-control" value="{{ old('quiz_start_datetime', '') }}">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="quiz_end_datetime">{{ trans('cruds.examination.fields.quiz_end_datetime') }}</label>
                                        <input type="datetime-local" id="quiz_end_datetime" name="quiz_end_datetime"
                                            class="form-control" value="{{ old('quiz_end_datetime', '') }}">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="quiz_number_of_attempts">{{ trans('cruds.examination.fields.quiz_number_of_attempts') }}</label>
                                        <input type="number" id="quiz_number_of_attempts" name="quiz_number_of_attempts"
                                            class="form-control" value="{{ old('quiz_number_of_attempts', 1) }}"
                                            min="1">
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-success mt-2">
                                            {{ trans('cruds.examination.add_quiz') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.courses.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function(file, response) {
                if (file.previewElement && file.previewElement.ownerDocument) {
                    console.log("File uploaded successfully!");
                    console.log(response);
                    $('form').find('input[name="photo"]').remove();
                    $('form').append('<input type="hidden" name="photo" value="' + response.name + '">');
                }
            },

            removedfile: function(file) {
                file.previewElement.remove();
                $('form').find('input[name="photo"]').remove();
                $('form').append('<input type="hidden" name="photo" value="">');
                this.options.maxFiles = this.options.maxFiles + 1;
            },
            init: function() {
                @if (isset($course) && $course->photo)
                    var file = {!! json_encode($course->photo) !!}
                    this.options.addedfile.call(this, file);
                    this.options.thumbnail.call(this, file, '{{ $course->photo->getUrl('thumb') }}');
                    file.previewElement.classList.add('dz-complete');
                    $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">');
                    this.options.maxFiles = this.options.maxFiles - 1;
                @endif
            },
            error: function(file, response) {
                var message = $.type(response) === 'string' ? response : response.errors.file;
                file.previewElement.classList.add('dz-error');
                var _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
                var _results = [];
                for (var _i = 0, _len = _ref.length; _i < _len; _i++) {
                    _results.push(_ref[_i].textContent = message);
                }
                return _results;
            }
        };

        document.getElementById('remove-existing-course-file')?.addEventListener('click', function() {
            const fileInfo = this.closest('div');
            fileInfo.style.display = 'none';
            document.getElementById('remove_course_file').value = '1';
        });
    </script>

    <script>
        // Clear the selected file in the file input when the "Clear Selected File" button is clicked
        document.getElementById('clear-course-file')?.addEventListener('click', function() {
            const fileInput = document.getElementById('course_file_input');
            fileInput.value = ''; // Reset the file input
        });
    </script>
@endsection
