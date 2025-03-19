@extends('layouts.main')

@section('content')
<div class="whole-wrap">
    <div class="container box_1170">
        <div class="section-top-border">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_tittle text-center">
                        @if(session('message'))
                            <div class="alert alert-warning" role="alert">
                                <h4>{{ session('message') }}</h4>
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <h4>{{ __('main.duplicate_enroll') }}</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
