@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <form action="{{ URL::to('admin/users') }}" method="GET" class="my-3" id="report-form">
        <div class="row align-items-end g-2 justify-content-end">

            {{-- From Date --}}
            <div class="col-md-2 col-lg-2">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            {{-- To Date --}}
            <div class="col-md-2 col-lg-2">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2 col-lg-2">
                <label class="form-label">Platform</label>
                <select name="is_app_user" 
                        class="form-control selectpicker" 
                        required 
                        data-live-search="true">
                        <option value=""
                            selected>
                            select platform 
                        </option>
                        <option value="0"
                            {{ request('is_app_user') == 0 ? 'selected' : '' }}>
                            web 
                        </option>
                        <option value="1"
                            {{ request('is_app_user') == 1 ? 'selected' : '' }}>
                            app 
                        </option>

                </select>
            </div>
            {{-- Branch --}}
            <div class="col-md-4 col-lg-3">
                <label class="form-label">Branch</label>
                <select name="branch_id" 
                        class="form-control selectpicker" 
                        required 
                        data-live-search="true">
                    @foreach (helper::get_branchs() as $branch)
                        <option value="{{ $branch->id }}"
                            {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name . ' - ' . $branch->city }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Button --}}
            <div class="col-md-2 col-lg-2">
                <button class="btn btn-primary w-100">
                    {{ trans('labels.fetch') }}
                </button>
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
