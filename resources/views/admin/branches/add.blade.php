@extends('admin.theme.default')
@section('content')
    <div class="row mt-3">
        @include('admin.breadcrumb')
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/branches/store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                        </span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                       placeholder="{{ trans('labels.name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">State<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="state"
                                       value="{{ old('state') }}"
                                       placeholder="state" >
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">city<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="city"
                                       value="{{ old('city') }}"
                                       placeholder="city" >
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Zip<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control numbers_only" name="zip"
                                       value="{{ old('zip') }}"
                                       placeholder="zip" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="address"
                                       value="{{ old('address') }}"
                                       placeholder="address" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Printer Name<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="printer_id"
                                       placeholder="Printer Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Print node api<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="mac_id"
                                       placeholder="Print node api" required>
                            </div>
                            <hr />

                            <div class="form-group col-md-6">
                                <label class="form-label">Public Key<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="public_key"
                                       placeholder="Printer Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Secret Key<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="secret_key"
                                       placeholder="Print node api" required>
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
