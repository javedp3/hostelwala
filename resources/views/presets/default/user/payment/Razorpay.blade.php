@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap">
                <div class="row justify-content-end">
                    <h5 class="card-title">@lang('Razorpay')</h5>
                    <div class="card-body p-5">
                        <ul class="list-group text-center">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You have to pay '):
                                <strong>{{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will get '):
                                <strong>{{ showAmount($deposit->amount) }} {{ __($general->cur_text) }}</strong>
                            </li>
                        </ul>
                        <form action="{{ $data->url }}" method="{{ $data->method }}">
                            <input type="hidden" custom="{{ $data->custom }}" name="hidden">
                            <script src="{{ $data->checkout_js }}"
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
    <script>
        (function($) {
            "use strict";
            $('input[type="submit"]').addClass("mt-4 btn btn--base w-100");
        })(jQuery);
    </script>
@endpush
