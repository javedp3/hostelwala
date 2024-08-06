@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="account bg-img login py-120 position-relative">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11">
                    <div class="account-form">
                        <div class="account-form__content">
                            <h3 class="account-form__title"> {{ __($pageTitle) }}</h3>
                        </div>
                        <form method="POST" action="{{ route('user.data.submit') }}">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="form--label">@lang('First Name')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" id="name" placeholder="First Name" name="firstname" value="{{ old('firstname') }}" required>
                                            <div class="input--icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="form--label">@lang('Last Name')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" id="name" placeholder="First Name" name="lastname" value="{{ old('lastname') }}" required>
                                            <div class="input--icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="address" class="form--label">@lang('Address')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" id="address" placeholder="Address" name="address"
                                            value="{{ old('address') }}">
                                            <div class="input--icon">
                                                <i class="fas fa-address-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="state" class="form--label">@lang('State')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" id="state" placeholder="State" name="state"
                                            value="{{ old('state') }}">
                                            <div class="input--icon">
                                                <i class="fas fa-flag-usa"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="zip" class="form--label">@lang('Zip Code')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" id="zip" placeholder="Zip" name="zip"
                                            value="{{ old('zip') }}">
                                            <div class="input--icon">
                                                <i class="fas fa-code-branch"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="city" class="form--label">@lang('City')</label>
                                        <div class="input--group">
                                            <input type="text" class="form--control" id="city" placeholder="City" name="city"
                                            value="{{ old('city') }}">
                                            <div class="input--icon">
                                                <i class="fas fa-city"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">
                                       @lang('Save')
                                    </button>
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