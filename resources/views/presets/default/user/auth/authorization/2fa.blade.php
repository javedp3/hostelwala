@extends($activeTemplate .'layouts.frontend')
@section('content')

<section class="account position-relative py-120">
    <div class="account-inner">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="account-form">
                        <div class="account-form__content mb-4">
                            <h3 class="account-form__title mb-2">@lang('2FA Verification')</h3>
                        </div>
                        <form action="{{route('user.go2fa.verify')}}" method="POST" class="submit-form">
                            @csrf
                            <div class="row gy-3">
                                @include($activeTemplate.'components.verification_code')
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('save')</button>
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

@push('script')
<script>
    (function ($) {
        "use strict";
        $('#code').on('input change', function () {
            var xx = document.getElementById('code').value;

            $(this).val(function (index, value) {
                value = value.substr(0, 7);
                return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
            });

        });
    })(jQuery)
</script>
@endpush