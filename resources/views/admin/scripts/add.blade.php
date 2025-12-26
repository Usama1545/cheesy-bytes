@extends('admin.theme.default')
@section('styles')
    <link rel="stylesheet"
        href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection
@section('content')
    <div class="row mt-3">
        @include('admin.breadcrumb')
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/scripts/store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="col-form-label">{{ trans('labels.name') }}<span class="text-danger">
                                        *</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="{{ trans('labels.name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="getaddons_id" class="col-form-label">Branch <span
                                            class="text-danger">*</span> </label>
                                    <select name="branch_id" class="form-control selectpicker" required
                                        data-live-search="true" id="getaddons_id">
                                        @foreach (helper::get_branchs() as $branch)
                                            <option value="{{ $branch->id }}">
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">{{ trans('labels.script') }}<span class="text-danger">
                                        *</span></label>
                                <textarea class="form-control" rows="5" name="script" placeholder="{{ trans('labels.script') }}"></textarea>
                            </div>
                            <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to('admin/branches') }}"
                                    class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                <button class="btn btn-primary"
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
@section('script')
    <script
        src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
    </script>
@endsection
