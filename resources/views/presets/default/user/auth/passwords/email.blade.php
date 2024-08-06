@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="account position-relative py-120">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2"> {{ __($pageTitle) }}</h3>
                        </div>
                        <form method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="row gy-3">
                                <div class="mb-4">
                                    <p>@lang('To recover your account please provide your email or username to find your account.')
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email" class="form--label">@lang('Email or Username')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" name="value" id="email" placeholder="Email Address"  value="{{ old('value') }}" required autofocus="off">
                                            <div class="input--icon">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">Forgot Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection