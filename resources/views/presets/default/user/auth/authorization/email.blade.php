@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account position-relative py-120">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-6">
                        <div class="account-form">
                            <div class="verification-area text-center">
                                <div class="account-form__content mb-4">
                                    <h3 class="account-form__title mb-2">@lang('Verify Email Address')</h3>
                                </div>
                                <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form">
                                    @csrf
                                    <p class="verification-text">@lang('A 6 digit verification code sent to your email address'):
                                        {{ showEmailAddress(auth()->user()->email) }}</p>
                                    <div class="row gy-3">
                                        @include($activeTemplate . 'components.verification_code')
                                        <div class="col-sm-12">
                                            <button type="submit"
                                                class="btn btn--base w-100">@lang('save')</button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p>
                                            @lang('If you don\'t get any code'), <a class="text--base"
                                                href="{{ route('user.send.verify.code', 'email') }}">
                                                @lang('Try again')</a>
                                        </p>

                                        @if ($errors->has('resend'))
                                            <small
                                                class="text-danger d-block text--base">{{ $errors->first('resend') }}</small>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
