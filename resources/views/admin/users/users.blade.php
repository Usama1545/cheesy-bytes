@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <form action="{{ URL::to('admin/users') }}" method="GET" class="my-3" id="report-form">
        <div class="input-group col-md-12 ps-0 justify-content-end">
            <div class="input-group-append col-auto px-1">
                <select name="branch_id" class="form-control selectpicker" required data-live-search="true" id="getaddons_id">
                    @foreach (helper::get_branchs() as $branch)
                        <option value="{{ $branch->id }}"
                            @isset($_GET['branch_id']) {{ $_GET['branch_id'] == $branch->id ? 'selected' : '' }}@endisset>

                            {{ $branch->name . '-' . $branch->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group-append">
                <button class="btn btn-primary rounded" type="submit">{{ trans('labels.fetch') }}</button>
            </div>
        </div>
    </form>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            @include('admin.users.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/users.js') }}"></script>
@endsection
