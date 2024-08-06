@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap mt-0">
                <form class="register"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="drop-file-wrap--">
                                <div class="dashboard_profile_wrap text-center">
                                    <div class="profile_photo mb-2">
                                        <img id="imgPre"
                                            src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                                            alt="User">
                                        <div class="photo_upload">
                                            <label for="file_upload"><i class="fas fa-image"></i></label>
                                            <input type="file" name="image" class="upload_file" id="file_upload"
                                                onchange="profileImg(this);">
                                        </div>
                                    </div>
                                    <div class="user-info">
                                        <p><span>@lang('User Name:')</span>
                                            {{ auth()->user()->fullname }}</p>
                                        <p><span>@lang('Email:')</span>
                                            {{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="first_name" class="form--label">@lang('First Name')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="first_name" name="firstname"
                                        placeholder="Fist Name" value="{{ $user->firstname }}" required>
                                    <div class="input--icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name" class="form--label">@lang('Last Name')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="last_name" name="lastname"
                                        placeholder="Last Name" value="{{ $user->lastname }}" required>
                                    <div class="input--icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email_adress" class="form--label">@lang('Email Address')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="email_adress"
                                        value="{{ $user->email }}" placeholder="Email Address" readonly>
                                    <div class="input--icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label" for="state">@lang('State')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="state" name="state"
                                        value="{{ @$user->address->state }}">
                                    <div class="input--icon">
                                        <i class="fas fa-flag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label" for="zip">@lang('Zip Code')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="zip" name="zip"
                                        value="{{ @$user->address->zip }}">
                                    <div class="input--icon">
                                        <i class="fas fa-sort-numeric-up-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label" for="city">@lang('City')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="city" name="city"
                                        value="{{ @$user->address->city }}">
                                    <div class="input--icon">
                                        <i class="fas fa-city"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form--label">@lang('Country')</label>
                                <div class="col-sm-12">
                                    <select class="form--control form-select" name="country">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $country->country }}" data-code="{{ $key }}"
                                                {{ $user->country_code == $key ? 'selected' : '' }}>
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="mobile" class="form--label">@lang('Mobile Number')</label>
                                <div class="input--group">
                                    <span class="input-group-text mobile-code">
                                    </span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="number" class="form--control checkUser left-padding" name="mobile" id="mobile"
                                        value="{{ $user->mobile }}" placeholder="Mobile number" required>
                                    <div class="input--icon">
                                        <i class="fas fa-mobile"></i>
                                    </div>
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form--label" for="address">@lang('Address')</label>
                                <div class="input--group textarea">
                                    <textarea id="address" class="form--control" name="address" placeholder="Address">@php echo  @$user->address->address @endphp </textarea>
                                    <div class="input--icon">
                                        <i class="fas fa-address-card"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function profileImg(object) {
            const file = object.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#imgPre').attr('src', event.target.result);
                    var form = $(object).closest('form');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on('change',function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

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

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {

                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
