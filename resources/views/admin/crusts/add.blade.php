@extends('admin.theme.default')
@section('content')
    <div class="row mt-3">
        @include('admin.breadcrumb')
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/crusts/store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                        </span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                       placeholder="{{ trans('labels.name') }}" required>
                            </div>

                            <div
                                class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to('admin/branches') }}"
                                   class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                <button class="btn btn-primary "
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()"
                                        @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
