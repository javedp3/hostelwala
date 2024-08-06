@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <section class="account position-relative py-120">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-6">
                        <div class="account-form">
                            <div class="verification-code-wrapper">
                                <div class="verification-area">
                                    <div class="account-form__content mb-4">
                                        <h3 class="account-form__title mb-2">@lang('You are banned')</h3>
                                        <p class="fw-bold mb-1">@lang('Reason'):</p>
                                        <p>{{ $user->ban_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
