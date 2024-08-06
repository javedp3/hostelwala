@extends($activeTemplate.'layouts.frontend')

@section('content')

  <!--=======-** Login start **-=======-->
  <section class="account bg-img login py-120 position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11">
                    <div class="account-form">
                        <div class="account-form__content">
                            <h3 class="account-form__title"> @lang('Sign Up Your Account') </h3>
                            <p class="account-form__desc">@lang('Please input your username and password and login to your account to get access to your dashboard.')</p>
                        </div>
                        <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="form--label">@lang('Username or Email')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" name="username" id="name" placeholder="Username or Email" required>
                                            <div class="input--icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                <div class="col-sm-12">
                                    <label for="your-password" class="form--label">@lang('Password')</label>
                                    <div class="input-group">
                                        <input id="your-password" type="password" class="form--control" name="password" required>
                                        <div class="password-show-hide toggle-password-change fas fa-eye-slash" data-target="your-password"> </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">@lang('Remember Me') </label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="forgot-password text--base">@lang('Forgot your password?')</a>
                                    </div>
                                </div>
                                <x-captcha></x-captcha>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">
                                        @lang('Sign In') <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="have-account text-center">
                                        <p class="have-account__text">@lang("Don't Have An Account?") <a href="{{ route('user.register') }}" class="have-account__link text--base">@lang('Create Account')</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=======-** Login End **-=======-->
@endsection