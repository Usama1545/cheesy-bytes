@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.change_password') }}
@endsection
@section('content')
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-dark fw-600" href="{{ route('home') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                            aria-current="page">{{ trans('labels.change_password') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-3 d-flex">
                    @include('web.layout.usersidebar')
                </div>
                <div class="col-lg-9">
                    <div class="user-content-wrapper">
                        <p class="title border-bottom pb-3">{{ trans('labels.change_password') }}</p>
                        <form action="{{ URL::to('/changepassword') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="old_password" class="form-label ">{{ trans('labels.old_password') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" name="old_password"
                                            placeholder="{{ trans('labels.old_password') }}" id="old_password"
                                            value="{{ old('old_password') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="new_password" class="form-label ">{{ trans('labels.new_password') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" name="new_password"
                                            placeholder="{{ trans('labels.new_password') }}" id="new_password"
                                            value="{{ old('new_password') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="confirm_password"
                                            class="form-label ">{{ trans('labels.confirm_password') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" class="form-control" name="confirm_password"
                                            placeholder="{{ trans('labels.confirm_password') }}" id="confirm_password"
                                            value="{{ old('confirm_password') }}" required>
                                    </div>
                                </div>
                                <div class="col-12 {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <button
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                        class="btn btn-primary px-4 py-2">{{ trans('labels.reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        function myFunction() {
            "use strict";
            toastr.error("This operation was not performed due to demo mode");
        }
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif
@endsection
