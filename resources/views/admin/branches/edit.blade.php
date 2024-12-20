@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/branches/update-' . $branch->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $branch->id }}">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                        </span></label>
                                <input type="text" class="form-control" name="name" value="{{ $branch->name }}"
                                       placeholder="{{ trans('labels.name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">State<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="state"
                                       value="{{ $branch->state->name }}"
                                       placeholder="state" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">city<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="city"
                                       value="{{ $branch->city }}"
                                       placeholder="city" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Zip<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control numbers_only" name="zip"
                                       value="{{ $branch->zip }}"
                                       placeholder="zip" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="address"
                                       value="{{ $branch->address }}"
                                       placeholder="address" required>
                            </div>
                            <div
                                class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to('admin/branches') }}"
                                   class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                <button class="btn btn-primary "
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
