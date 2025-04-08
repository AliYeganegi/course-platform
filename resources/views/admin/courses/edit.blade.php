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
                            <strong>Current File:</strong>
                            <a href="{{ asset('storage/' . $course->course_file) }}" target="_blank">
                                {{ basename($course->course_file) }}
                            </a>
                            <button type="button" id="remove-existing-course-file"
                                class="btn btn-sm btn-danger ml-2">Remove</button>
                            <input type="hidden" name="remove_course_file" id="remove_course_file" value="0">
                        </div>
                    @endif

                    <!-- File input for uploading new course file -->
                    <input type="file" name="course_file" class="form-control" id="course_file_input">

                    <button type="button" id="clear-course-file" class="btn btn-sm btn-warning mt-2">Clear Selected
                        File</button>

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

@stop
