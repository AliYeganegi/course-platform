@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                <label for="phone_number">{{ trans('cruds.user.fields.phone_number') }}*</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number', isset($user) ? $user->phone_number : '') }}" required>
                @if($errors->has('phone_number'))
                    <em class="invalid-feedback">
                        {{ $errors->first('phone_number') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.phone_number_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : '' }}">
                <label for="date_of_birth">{{ trans('cruds.user.fields.date_of_birth') }}*</label>
                <input type="text" id="date_of_birth" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', isset($user) ? $user->date_of_birth : '') }}" required>
                @if($errors->has('date_of_birth'))
                    <em class="invalid-feedback">
                        {{ $errors->first('date_of_birth') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.date_of_birth_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @if($errors->has('password'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.password_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('cruds.user.fields.roles') }}*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <em class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('institution_id') ? 'has-error' : '' }}" id="institutionGroup" style="{{ in_array(2, old('roles', [])) ? '' : 'display:none'}}">
                <label for="institution">{{ trans('cruds.user.fields.institution') }}</label>
                <select name="institution_id" id="institution" class="form-control select2">
                    @foreach($institutions as $id => $institution)
                        <option value="{{ $id }}" {{ (isset($user) && $user->institution ? $user->institution->id : old('institution_id')) == $id ? 'selected' : '' }}>{{ $institution }}</option>
                    @endforeach
                </select>
                @if($errors->has('institution_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('institution_id') }}
                    </em>
                @endif
            </div>

            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#roles').change(function() {
        if($("#roles option:selected:contains('Institution')").val())
            $("#institutionGroup:hidden").show(150);
        else
            $("#institutionGroup:visible").hide(150);
    });
});
</script>

<script>
    // Initialize Persian Datepicker for date_of_birth
    $(document).ready(function() {
        $('#date_of_birth').persianDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            altFormat: 'YYYY-MM-DD',
            altField: '#date_of_birth'
        });
    });
</script>

@endsection
