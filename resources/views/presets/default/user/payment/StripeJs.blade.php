@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap">
                <div class="row justify-content-end">
                    <h5 class="card-title">@lang('Stripe Storefront')</h5>
                    <div class="card-body p-5">
                        <form action="{{ $data->url }}" method="{{ $data->method }}">
                            <ul class="list-group text-center">
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('You have to pay '):
                                    <strong>{{ showAmount($deposit->final_amo) }}
                                        {{ __($deposit->method_currency) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('You will get '):
                                    <strong>{{ showAmount($deposit->amount) }} {{ __($general->cur_text) }}</strong>
                                </li>
                            </ul>
                            <script src="{{ $data->src }}" class="stripe-button"
                                @foreach ($data->val as $key => $value)
                            data-{{ $key }}="{{ $value }}" @endforeach>
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--base w-100 mt-3");
            $('button[type="submit"]').text("Pay Now");
        })(jQuery);
    </script>
@endpush
