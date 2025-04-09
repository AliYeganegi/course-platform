@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.name') }}*</label>
                <div class="col-md-6">
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Email Field -->
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.email') }}*</label>
                <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Phone Number Field -->
            <div class="form-group row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.phone_number') }}*</label>
                <div class="col-md-6">
                    <input type="text" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                           value="{{ old('phone_number', isset($user) ? $user->phone_number : '') }}" required>
                    @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Date of Birth Field -->
            <div class="form-group row">
                <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.date_of_birth') }}*</label>
                <div class="col-md-6">
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                           value="{{ old('date_of_birth', isset($user) ? $user->date_of_birth : '') }}" required>
                    @error('date_of_birth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.password') }}</label>
                <div class="col-md-6">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Roles Field -->
            <div class="form-group row">
                <label for="roles" class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.roles') }}*</label>
                <div class="col-md-6">
                    <select name="roles[]" id="roles" class="form-control select2 @error('roles') is-invalid @enderror" multiple="multiple" required>
                        @foreach($roles as $id => $roles)
                            <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                        @endforeach
                    </select>
                    @error('roles')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Institution Field -->
            <div class="form-group row" id="institutionGroup" style="{{ (in_array(2, old('roles', [])) || isset($user) && $user->roles->contains(2)) ? '' : 'display:none'}}">
                <label for="institution" class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.institution') }}</label>
                <div class="col-md-6">
                    <select name="institution_id" id="institution" class="form-control select2 @error('institution_id') is-invalid @enderror">
                        @foreach($institutions as $id => $institution)
                            <option value="{{ $id }}" {{ (isset($user) && $user->institution ? $user->institution->id : old('institution_id')) == $id ? 'selected' : '' }}>{{ $institution }}</option>
                        @endforeach
                    </select>
                    @error('institution_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-danger">
                        {{ trans('global.save') }}
                    </button>
                </div>
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
@endsection
