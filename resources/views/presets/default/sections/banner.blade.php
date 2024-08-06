@php
    $bannerOneSection = getContent('banner_one.content', true);
    $bannerTwoSection = getContent('banner_two.content', true);
    $searchSection = getContent('search.content', true);
    $referByHomePage = session()->get('reference');
@endphp
<!--========================== Banner One Section Start ==========================-->
@if (@$referByHomePage ? @$referByHomePage == 1 : $general->site_banner === 1)
    <section class="banner-section section-bg" id="js-scene">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-5 col-md-12">
                    <div class="banner-left__content">
                        <span class="subtitle">{{ __(@$bannerOneSection->data_values?->subheading) }}</span>
                        <h2>{{ __(@$bannerOneSection->data_values?->heading) }}</h2>
                        <div class="video-button-wrap">
                            <a href="{{ route('hostel_list') }}"
                                class="btn btn--base me-4">{{ __(@$bannerOneSection->data_values?->button_one) }}</a>
                            <div class="popup-vide-wrap-">
                                <div class="video-main">
                                    <div class="promo-video">
                                        <div class="waves-block">
                                            <div class="waves wave-1"></div>
                                            <div class="waves wave-2"></div>
                                            <div class="waves wave-3"></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="https://www.youtube.com/watch?v=5LtpZbi8VLo" class="video-button popup_video">
                                    @php echo @$bannerOneSection->data_values?->banner_icon @endphp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="banner-right-wrap">
                        <div class="main-banner-img">
                            <img src="{{ getImage(getFilePath('banner_one') . '/' . @$bannerOneSection->data_values->background_image) }}"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!--========================== Banner One Section End ==========================-->


<!--========================== Banner Two Section Start ==========================-->
<!-- bg-img -->
@if (@$referByHomePage ? @$referByHomePage == 2 : $general->site_banner === 2)
    <section class="banner-section two section-bg" id="js-scene">
        <img src="{{ getImage(getFilePath('banner_two') . '/' . 'banner-two-left.png') }}" alt=""
            class="banner-two-left animate-y-axis">
        <img src="{{ getImage(getFilePath('banner_two') . '/' . 'banner-two-right.png') }}" alt=""
            class="banner-two-right animate-rotate">
        <img src="{{ getImage(getFilePath('banner_two') . '/' . @$bannerTwoSection->data_values->background_image) }}"
            alt="" class="banner-two-man">
        <img src="{{ getImage(getFilePath('banner_two') . '/' . 'banner-two-shape-bg.png') }}" alt=""
            class="banner-two-shape-bg">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-5 col-lg-6 col-md-12">
                    <div class="banner-left__content">
                        <span class="subtitle">{{ @$bannerTwoSection->data_values->subheading }}</span>
                        <h2>{{ @$bannerTwoSection->data_values->heading }}</h2>
                        <p class="desc">{{ @$bannerTwoSection->data_values->short_details }}</p>
                        <div class="video-button-wrap">
                            <a href="{{ route('hostel_list') }}"
                                class="btn btn--base me-4">{{ @$bannerTwoSection->data_values->button_one }}</a>
                            <a href="{{ route('user.hostel.add') }}"
                                class="btn btn--base outline">{{ @$bannerTwoSection->data_values->button_two }}</a>
                        </div>

                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="banner-right-wrap">
                        <img src="{{ getImage(getFilePath('banner_two') . '/' . 'banner-two-middle.png') }}"
                            alt="" class="banner-two-middle">

                        <form  method="GET" autocomplete="off">
                            <div class="search-bg-wrapper">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6 class="search-title">@lang('Search for booking')</h6>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="search-item-wrap">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="search-item destination">
                                                        <input type="hidden" name="search"
                                                            value="{{ request()->search ?? old('search') }}">
                                                        <label for="search_show">@lang('Destination')</label>
                                                        <input type="text" name="search_show"
                                                            placeholder="Where you wanna go?" onkeyup="locations(this)"
                                                            value="{{ request()->search_show ?? old('search_show') }}">
                                                        <span class="icon"><i class="fas fa-map-marker"></i></span>
                                                        <ul class="search-result-box d-none">

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="search-item check-in">
                                                        <label for="check_in">@lang('Check In')</label>
                                                        <input name="check_in" class="datepicker-active"
                                                            data-language="en" placeholder="Check In"
                                                            value="{{ request()->check_in ?? old('check_in') }}">
                                                        <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="search-item check-out">
                                                        <label for="check_out">@lang('Check out')</label>
                                                        <input name="check_out" class="datepicker-active"
                                                            data-language="en" placeholder="Check Out"
                                                            value="{{ request()->check_out ?? old('check_out') }}">
                                                        <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="search-item who" id="search-input-show">
                                                        <label for="guest">@lang('who')</label>
                                                        <input type="text" name="guest" placeholder="1 Guest">
                                                        <span class="icon"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="search-item button">
                                                        <button  type="submit"
                                                            class="btn btn--base banner-two w-100">@lang('Search Hostel')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<!--========================== Banner Two Section End ==========================-->
@push('script')
    <script>
        function locations(object) {
            var search = $(object).val();
            var appendClass = $('.search-result-box');
            console.log(appendClass);
            var url = "{{ route('location.search') }}";
            var token = '{{ csrf_token() }}';
            var data = {
                search: search,
                _token: token
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                    if (data.hostel != '') {
                        
                        var html = '';
                        $.each(data.hostel, function(key, item) {
                            html +=
                                `<li onclick="inputAppend(this,${item.id})" class="d-flex p-2 w-100 justify-content-between">
                                        ${item.address}
                                    </li>
                                    `;
                        })
                        appendClass.removeClass('d-none').html(html);
                    } else {
                        var html =
                            `<li class="no-data">
                                    No data found
                                </li>
                                `;
                        appendClass.removeClass('d-none').html(html);
                    }
                },
                error: function(data, status, error) {
                    $.each(data.responseJSON.errors, function(key,
                        item) {
                        Toast.fire({
                            icon: 'error',
                            title: item
                        })
                    });
                }
            });
        }

        function inputAppend(object, data) {
            var stringReplace = $(object).text().trim();
            $('input[name=search_show]').val(stringReplace);
            $('input[name=search]').val(data);
            $('.search-result-box').addClass('d-none');
        }

        $(document).ready(function() {
            'use strict'
            $(".datepicker-active").datepicker({
                minDate: new Date()
            });

            var check_in = "{{ request()->check_in }}";
            var check_out = "{{ request()->check_out }}";

            $('input[name=check_in]').val(check_in);
            $('input[name=check_out]').val(check_out);
        });
    </script>
@endpush
