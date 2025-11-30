@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">




                <form action="{{ URL::to('/admin/report') }}" method="GET" class="my-3" id="report-form">
                    <div class="input-group col-md-12 ps-0 justify-content-end">
                        <div class="input-group-append col-auto px-1">
                            <select name="branch_id" class="form-control selectpicker" required
                                    data-live-search="true" id="getaddons_id">
                                @foreach (helper::get_branchs() as $branch)
                                    <option value="{{ $branch->id }}"
                                    @isset($_GET['branch_id']) {{ $_GET['branch_id'] == $branch->id ? 'selected' : ''  }}@endisset>

                                        {{ $branch->name.'-'.$branch->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group-append col-auto px-1">
                            <button class="btn btn-primary rounded" type="button" data-type="month"> Month</button>
                        </div>
                        <div class="input-group-append col-auto px-1">
                            <button class="btn btn-primary rounded" type="button" data-type="week">Week</button>
                        </div>
                           <div class="input-group-append col-auto px-1">
                            <button class="btn btn-primary rounded" type="button" data-type="yesterday">Yesterday</button>
                        </div>
                        <div class="input-group-append col-auto px-1">
                            <button class="btn btn-primary rounded" type="button" data-type="today">Today</button>
                        </div>
                     
                        <div class="input-group-append col-auto px-1">
                            <input type="date" class="form-control rounded" name="startdate"
                                   @isset($_GET['startdate']) value="{{ $_GET['startdate'] }}" @endisset
                                   required>
                        </div>
                        <div class="input-group-append col-auto px-1">
                            <input type="date" class="form-control rounded" name="enddate"
                                   @isset($_GET['enddate']) value="{{ $_GET['enddate'] }}" @endisset
                                   required>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary rounded" type="submit">{{ trans('labels.fetch') }}</button>
                        </div>
                    </div>
                </form>

                @include('admin.orders.statistics')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive reportstable" id="table-display">
                            @include('admin.orders.orderstable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/orders.js') }}"></script>
    <script>
        document.querySelectorAll('button[data-type]').forEach(button => {
            button.addEventListener('click', function () {
                const type = this.getAttribute('data-type');
                const today = new Date();
                let start, end;

                switch (type) {
                    case 'today':
                        start = end = today;
                        break;
                    case 'week':
                        const first = today.getDate() - today.getDay(); // Sunday
                        start = new Date(today.setDate(first));
                        end = new Date();
                        break;
                  case 'yesterday':
    start = new Date(today);
    start.setDate(start.getDate() - 1); // yesterday
    end = new Date(today);              // today
    break;
                    case 'month':
                        start = new Date(today.getFullYear(), today.getMonth(), 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        break;
                }

                const formatDate = date => date.toISOString().split('T')[0];

                document.querySelector('input[name="startdate"]').value = formatDate(start);
                document.querySelector('input[name="enddate"]').value = formatDate(end);

                document.getElementById('report-form').submit();
            });
        });
    </script>

@endsection
