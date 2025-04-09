@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.course.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                    <label for="photo">{{ trans('cruds.course.fields.photo') }}</label>
                    <div class="needsclick dropzone" id="photo-dropzone">

                    </div>
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
                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                    <label for="price">{{ trans('cruds.course.fields.price') }}</label>
                    <input type="number" id="price" name="price" class="form-control"
                        value="{{ old('price', isset($course) ? $course->price : '') }}" step="0.01">
                    @if ($errors->has('price'))
                        <em class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </em>
                    @endif
                </div>
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
                <div class="form-group">
                    <label for="course_file">Upload Course File (ZIP)</label>
                    <input type="file" name="course_file" id="course_file" class="form-control">
                    <button type="button" id="clear-course-file"
                        class="btn btn-warning btn-sm mt-2">{{ trans('cruds.course.chosen_file_remove') }}</button>
                </div>


                @if (isset($course) && $course->course_file)
                    <a href="{{ asset('storage/' . $course->course_file) }}" target="_blank">Download Course File</a>
                @endif

                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
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
    </script>

    <script>
        document.getElementById('clear-course-file').addEventListener('click', function() {
            const input = document.getElementById('course_file');
            input.value = '';
        });
    </script>

@stop
