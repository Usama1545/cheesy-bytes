@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.add_address') }}
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
                            aria-current="page">{{ trans('labels.my_addresses') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <div class="row justify-content-center">

                @if (Auth::user())
                    <div class="col-lg-3">
                        @include('web.layout.usersidebar')
                    </div>
                @endif
                <div class="{{ Auth::user() ? 'col-lg-9' : 'col-lg-12' }}">
                    <div class="user-content-wrapper rounded-4">
                        <div class="mb-3">
                            <p class="title mb-3 border-bottom pb-3">{{ trans('labels.add_address') }}</p>
                        </div>
                        <form action="{{ URL::to('/address/store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="title" class="form-label">{{ trans('labels.title') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="{{ trans('labels.title') }}" value="{{ old('title') }}" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">{{ trans('labels.address') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if (env('Environment') == 'sendbox')
                                        <textarea rows="6" class="form-control" name="address" placeholder="{{ trans('labels.address') }}" id="address"
                                            readonly>Norwoodport , West Virginia - 86490-8323</textarea>
                                    @else
                                        <textarea rows="6" class="form-control" name="address" placeholder="{{ trans('labels.address') }}" id="address"
                                            required>{{ old('address') }}</textarea>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">{{ trans('labels.country') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="country" id="country"
                                        placeholder="{{ trans('labels.country') }}" value="{{ old('country') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">{{ trans('labels.state') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="state" id="state"
                                        placeholder="{{ trans('labels.state') }}" value="{{ old('state') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">{{ trans('labels.city') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="city" id="city"
                                        placeholder="{{ trans('labels.city') }}" value="{{ old('city') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="landmark" class="form-label">{{ trans('labels.landmark') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="landmark" id="landmark"
                                        placeholder="{{ trans('labels.landmark') }}" value="{{ old('landmark') }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pincode" class="form-label">{{ trans('labels.pincode') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="pincode" id="pincode"
                                        placeholder="{{ trans('labels.pincode') }}" value="{{ old('pincode') }}" required>
                                </div>
                                <div class="col-md-6 my-4">
                                    <div class="form-group mt-3">
                                        <div class="{{ session()->get('direction') == '2' ? 'd-flex gap-2' : 'form-check' }}">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="flexCheckDefault" name="is_default">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ trans('labels.default') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <button type="submit"
                                        class="btn bg-primary text-white px-4 py-2">{{ trans('labels.save_address_details') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
