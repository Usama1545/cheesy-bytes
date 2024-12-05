<div class="row g-3 justify-content-between">
    @php
        $i = 0;
    @endphp
    @foreach ($getpaymentmethods as $key => $pmdata)
        @php
            // Check if the current $pmdata is a system addon and activated
            if ($pmdata->payment_type == '1' || $pmdata->payment_type == '2') {
                $systemAddonActivated = true;
            } else {
                $systemAddonActivated = false;
            }
            $addon = App\Models\SystemAddons::where('unique_identifier', $pmdata->unique_identifier)->first();
            if ($addon != null && $addon->activated == 1) {
                $systemAddonActivated = true;
            }
            $transaction_type = $pmdata->payment_type;
        @endphp
        @if ($systemAddonActivated)
            <label class="form-check-label col-md-6" for="payment{{ $transaction_type }}">
                <input class="form-check-input" type="radio" name="transaction_type" id="payment{{ $transaction_type }}"
                    data-payment-type="{{ $transaction_type }}" value="{{ $transaction_type }}"
                    data-currency="{{ $pmdata->currency }}" {{ $i++ == 0 ? 'checked' : '' }}>
                <div class="payment-gateway mb-0 justify-content-between">
                    <span> <img src="{{ helper::image_path($pmdata->image) }}" class="{{ session()->get('direction') == '2' ? 'ms-2' : 'me-2' }}" alt="">
                        {{ ucfirst($pmdata->payment_name) }}
                    </span>
                    <div class="d-flex gap-2">
                        @if ($transaction_type == 2)
                            <span class="text-end text-muted">{{ helper::currency_format(Auth::user()->wallet) }}</span>
                        @endif

                        <span class="check-icon"></span>
                    </div>
                </div>
            </label>
        @endif
        @if (in_array($transaction_type, [3, 4, 5, 6]))
            @if ($transaction_type == 3)
                <input type="hidden" name="razorpaykey" id="razorpaykey" value="{{ $pmdata->public_key }}">
            @endif
            @if ($transaction_type == 4)
                <input type="hidden" name="stripekey" id="stripekey" value="{{ $pmdata->public_key }}">
            @endif
            @if ($transaction_type == 5)
                <input type="hidden" name="flutterwavekey" id="flutterwavekey" value="{{ $pmdata->public_key }}">
            @endif
            @if ($transaction_type == 6)
                <input type="hidden" name="paystackkey" id="paystackkey" value="{{ $pmdata->public_key }}">
            @endif
        @endif
        @if ($transaction_type == 4)
            <form action="" method="" id="payment-form" class="d-none">
                <div class="my-3" id="card-element"></div>
            </form>
        @endif
    @endforeach
    @if (!in_array(4, array_column($getpaymentmethods->toArray(), 'id')))
        <input type="hidden" name="stripekey" id="stripekey" value="">
    @endif
</div>
