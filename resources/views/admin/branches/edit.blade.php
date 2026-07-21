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
                                <label class="form-label">SEO Name</label>
                                <input type="text" class="form-control" name="seo_name" value="{{ $branch->seo_name }}"
                                       placeholder="SEO Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">State<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="state"
                                       value="{{ $branch->state?->name ?? '' }}"
                                       placeholder="state" >
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">city<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="city"
                                       value="{{ $branch->city }}"
                                       placeholder="city" >
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Zip<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control numbers_only" name="zip"
                                       value="{{ $branch->zip }}"
                                       placeholder="zip" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Address<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="address"
                                       value="{{ $branch->address }}"
                                       placeholder="address" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Printer Name<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="printer_id"
                                       value="{{ $branch->printer_id }}"
                                       placeholder="Printer Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Print node api<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="mac_id"
                                 value="{{ $branch->mac_id }}"
                                       placeholder="Print node api" required>
                            </div>
                            <hr />

                            <div class="form-group col-md-6">
                                <label class="form-label">Public Key<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="public_key" value="{{ $branch->paymentMethod->public_key ?? '' }}"
                                       placeholder="Printer Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Secret Key<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="secret_key" value="{{ $branch->paymentMethod->secret_key ?? '' }}"
                                       placeholder="Print node api" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Webhook Secret<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control " name="webhook_secret"
                                       value="{{ $branch->webhook_secret }}"
                                       placeholder="whsec_..." required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Webhook Endpoint URL</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="webhook_endpoint_url"
                                           value="{{ url('/api/stripe/webhook') }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="copyWebhookEndpoint()">Copy</button>
                                </div>
                                <small class="text-muted">Use this same URL for every branch's Stripe webhook configuration.</small>
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
    <script>
        function copyWebhookEndpoint() {
            const input = document.getElementById('webhook_endpoint_url');
            input.select();
            input.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(input.value);
        }
    </script>
@endsection
