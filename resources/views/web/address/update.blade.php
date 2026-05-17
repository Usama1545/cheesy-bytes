@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.update_address') }}
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
            <div class="row">
                @if (Auth::user())
                    <div class="col-lg-3">
                        @include('web.layout.usersidebar')
                    </div>
                @endif
                <div class="{{ Auth::user() ? 'col-lg-9' : 'col-lg-12' }}">
                    <div class="user-content-wrapper">
                        <div class="mb-3">
                            <p class="title border-bottom pb-3 mb-3">{{ trans('labels.update_address') }}</p>
                        </div>
                        <form action="{{ URL::to('/address/update-' . $addressdata->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="title" class="form-label">{{ trans('labels.title') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="{{ trans('labels.title') }}" value="{{ $addressdata->title }}"
                                        required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">{{ trans('labels.address') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if (env('Environment') == 'sendbox')
                                        <textarea rows="6" class="form-control" name="address" placeholder="{{ trans('labels.address') }}" readonly>Norwoodport , West Virginia - 86490-8323</textarea>
                                    @else
                                        <textarea rows="6" class="form-control" name="address" placeholder="{{ trans('labels.address') }}" required>{{ $addressdata->address }} </textarea>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">{{ trans('labels.country') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="country" id="country"
                                        placeholder="{{ trans('labels.country') }}" value="{{ $addressdata->country }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">{{ trans('labels.state') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="state" id="state"
                                        placeholder="{{ trans('labels.state') }}" value="{{ $addressdata->state }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">{{ trans('labels.city') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="city" id="city"
                                        placeholder="{{ trans('labels.city') }}" value="{{ $addressdata->city }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="landmark" class="form-label">{{ trans('labels.landmark') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="landmark" id="landmark"
                                        placeholder="{{ trans('labels.landmark') }}" value="{{ $addressdata->landmark }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pincode" class="form-label">{{ trans('labels.pincode') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="pincode" id="pincode"
                                        placeholder="{{ trans('labels.pincode') }}"
                                        value="{{ $addressdata->postal_code }}" required>
                                </div>
                                <div class="col-md-6 my-4">
                                    <div class="form-group mt-3">
                                        <div class="{{ session()->get('direction') == '2' ? 'd-flex gap-2' : 'form-check' }}">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                {{ $addressdata->is_default == 1 ? 'checked' : '' }} id="flexCheckDefault"
                                                name="is_default">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ trans('labels.default') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <button class="btn text-white bg-primary px-4 py-2"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save_address_details') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
