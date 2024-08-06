@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap mt-0">
                <div class="row gy-4">
                    <form method="POST">
                        @csrf
                        <div class="row gy-3 justify-content-center">
                            <div class="col-sm-12">
                                <label for="old-password" class="form--label">@lang('Current Password') </label>
                                <div class="input-group">
                                    <input id="old-password" name="current_password" type="password"
                                        class="form-control form--control" required placeholder="Current Password">
                                    <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                        data-target="old-password"> </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="new-password" class="form--label">@lang('New Password') </label>
                                <div class="input-group">
                                    <input id="new-password" type="password" class="form-control form--control"
                                        name="password" required placeholder="New Password">
                                    <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                        data-target="new-password"> </div>

                                    @if ($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="again-your-password" class="form--label">@lang('Confirm Password') </label>
                                <div class="input-group">
                                    <input id="again-your-password" type="password" class="form-control form--control"
                                        name="password_confirmation" required placeholder="Confirm Password">
                                    <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                        data-target="again-your-password"> </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn--base">
                                    @lang('Save Now')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif
        })(jQuery);
    </script>
@endpush
