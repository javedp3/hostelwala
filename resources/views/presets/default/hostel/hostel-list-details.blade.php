@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Breadcumb Start Here ==================== -->
    <section class="breadcumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcumb__wrapper">
                        <h2 class="breadcumb__title">{{ $pageTitle }}</h2>
                        <ul class="breadcumb__list">
                            <li class="breadcumb__item"><a href="https://preview.wstacks.com/smmcrowd" class="breadcumb__link">
                                    <i class="fas fa-home"></i> @lang('Home')</a> </li>
                            <li class="breadcumb__item">/</li>
                            <li class="breadcumb__item"> <span class="breadcumb__item-text"> @lang('Book Hostel') </span> </li>
                        </ul>
                    </div>
                </div>
            </div>
            @include($activeTemplate . 'sections.search')
        </div>
    </section>
    <!-- ==================== Breadcumb End Here ==================== -->

    <!-- ==================== Hostel single Start Here ==================== -->
    <section class="hostel-list-single-area hostel-list-area py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <div class="hostel-top">
                                <h3 class="title-two mb-1">{{ $hostel->name }}</h3>
                                <div class="hostel-list-item__title-wrap">
                                    <div class="rating-wrap">
                                        @if ($hostel->average_rating || $totalRating)
                                            <div class="left">
                                                <div class="icon">
                                                    <span class="rating ">{{ $hostel->average_rating }}</span>
                                                    <p>{{ $totalRating }} @lang('Rating')</p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="right">
                                            <div class="icon">
                                                <i class="fas fa-map-marker"></i>
                                                <p>{{ __($hostel->address) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="search-wrapper-wrap text-end">
                                <div class="icon-wish wishlist-btn" data-hostel_id="{{ $hostel->id }}">
                                    <i class="{{ $wishlist ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gy-4">
                        <div class="col-xl-12">
                            <div class="hostel-list-item">
                                <div class="row product-list-slider">
                                    @foreach (@$hostel->hostel_images as $index => $item)
                                        <div class="product-list-item">
                                            <div class="hostel-list-item__thumb mb-4">
                                                <img src="{{ getImage(getFilePath('hostel') . '/' . @$item->path . @$item->image, getFileSize('hostel')) }}"
                                                    alt="hostel">
                                                @if ($hostel->discount)
                                                    <span class="offer-title">{{ __($hostel->discount) }}
                                                        @lang('% OFF')</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="hostel-list-details-tap-wrap">
                                    <ul class="nav nav-tabs custom--tab" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#home-tab-pane" type="button" role="tab"
                                                aria-controls="home-tab-pane" aria-selected="true">
                                                @lang('Description')
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile-tab-pane" type="button" role="tab"
                                                aria-controls="profile-tab-pane" aria-selected="false">
                                                @lang('Facilities')
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                data-bs-target="#contact-tab-pane" type="button" role="tab"
                                                aria-controls="contact-tab-pane" aria-selected="false">
                                                @lang('House rules')
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab"
                                                data-bs-target="#disabled-tab-pane" type="button" role="tab"
                                                aria-controls="disabled-tab-pane" aria-selected="false">
                                                @lang('Reviews')
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab"
                                                data-bs-target="#map-tab-pane" type="button" role="tab"
                                                aria-controls="map-tab-pane" aria-selected="false">
                                                @lang('Map')
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                            aria-labelledby="home-tab" tabindex="0">
                                            <div class="tab-description">
                                                <h3 class="title-two">@lang('Description')</h3>
                                                <div class="mb-4">
                                                    <p>@php echo $hostel->description @endphp</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                            aria-labelledby="profile-tab" tabindex="0">
                                            <div class="row gy-4">
                                                <div class="col-md-12">
                                                    <h3 class="title-two">@lang('Facilities')</h3>
                                                </div>
                                                <div class="col-lg-12 col-md-6 col-sm-6 col-6">
                                                    <div class="single-facilities">
                                                        <div class="border-wrap">
                                                            <span class="border-style"></span>
                                                        </div>
                                                        <ul>
                                                            @foreach ($hostel->facilities as $index => $facilitie)
                                                                <li>@php echo $hostel->icons[$index] @endphp
                                                                    <p>{{ $facilitie }}</p>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                            aria-labelledby="contact-tab" tabindex="0">
                                            <div class="tab-description">
                                                <h3 class="title-two">@lang('Hostel Rules')</h3>
                                                <div class="mb-4">
                                                    @php
                                                        echo __($hostel->hostel_rules);
                                                    @endphp
                                                </div>
                                            </div>
                                        </div>
                                        {{-- -----------------------------reviews----------------------------- --}}
                                        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel"
                                            aria-labelledby="disabled-tab" tabindex="0">
                                            <div class="tab-rating">
                                                <h3 class="title-two">@lang('Reviews & Ratings')</h3>
                                                <div class="rating-top">
                                                    <h6>
                                                        @if ($hostel->average_rating && $hostel->average_rating)
                                                            <span>{{ $hostel->average_rating }}</span>
                                                            {{ $hostel->average_rating }}
                                                        @else
                                                            <span>0</span>
                                                        @endif

                                                        @lang('Rating')
                                                    </h6>
                                                </div>
                                                @forelse ($reviews as $item)
                                                    <div class="rating-comment-item">
                                                        <div class="quality-hostel-bottom__item">
                                                            <div class="thumb">
                                                                <img class="rounded-circle"
                                                                    src="{{ getImage(getFilePath('userProfile') . '/' . @$item->user?->image, getFileSize('userProfile')) }}"
                                                                    alt="review-image">
                                                            </div>
                                                            <div class="content">
                                                                <h4 class="title-three">{{ __(@$item->user?->username) }}
                                                                </h4>
                                                                <p>{{ __(diffForHumans(@$item->created_at)) }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="desc mb-4">
                                                            <p>{{ __($item->message) }}</p>
                                                        </div>
                                                        <div class="bottom">
                                                            <ul class="rating-list">
                                                                @php
                                                                    $averageRatingHtml = calculateIndividualRating($item->rating);
                                                                    if (!empty($averageRatingHtml['ratingHtml'])) {
                                                                        echo $averageRatingHtml['ratingHtml'];
                                                                    }
                                                                @endphp
                                                            </ul>
                                                            <div class="count">
                                                                <span>{{ $item->rating > 0 ? '(' . $item->rating . ')' : '' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <h5 class="text-center">@lang('No Reviews')</h5>
                                                @endforelse
                                                <div class="row gy-4">
                                                    @if ($reviews->hasPages())
                                                        <div class="py-4">
                                                            {{ paginateLinks($reviews) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="row gy-4 mt-2">
                                                    <div class="contact-form pt-2">
                                                        <form action="{{ route('user.reviews.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="rating" id="rating"
                                                                value="0">
                                                            <input type="hidden" name="hostel_id"
                                                                value="{{ $hostel->id }}">
                                                            <div class="rating-top">
                                                                <h3 class="title-three"> @lang('Giving Rating'):</h3>
                                                                <div class="rating-wrap rating-stars">
                                                                    <ul>
                                                                        <i class="far fa-star" data-rating="1"></i>
                                                                        <i class="far fa-star" data-rating="2"></i>
                                                                        <i class="far fa-star" data-rating="3"></i>
                                                                        <i class="far fa-star" data-rating="4"></i>
                                                                        <i class="far fa-star" data-rating="5"></i>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="row gy-md-4 gy-3">
                                                                <div class="col-sm-12">
                                                                    <textarea class="form--control" name="message" placeholder="@lang('Message')" id="message"></textarea>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <button type="submit"
                                                                        class="btn btn--base w-100">@lang('Submit')</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="map-tab-pane" role="tabpanel"
                                            aria-labelledby="map-tab" tabindex="0">
                                            <div class="google-map-wrap">
                                                <h3 class="title-two">@lang('Location Map')</h3>
                                                <iframe
                                                    src="https://maps.google.com/maps?q={{ $hostel->latitude }},{{ $hostel->longitude }}&hl=es;z=14&amp;output=embed"
                                                    width="100%" height="425" style="border:0;" allowfullscreen=""
                                                    loading="lazy"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($hostel->rooms->count() > 0)
                                <div class="dorm-beds-wrap">
                                    @foreach ($hostel->rooms as $room)
                                        <div class="row border--bottom">
                                            <div class="col-lg-7">
                                                <div class="dorms-left">
                                                    <div class="thumb">
                                                        <img src="{{ getImage(getFilePath('room') . '/' . @$room->image, getFileSize('room')) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="content">
                                                        <span>
                                                            @if ($room->type == 'room')
                                                                @lang('Number of Rooms')
                                                            @else
                                                                @lang('Number of Beds')
                                                            @endif
                                                            {{ $room->rooms_or_beds }}
                                                        </span>
                                                        <h4 class="title-three">{{ $room->title }}</h4>
                                                        <div class="hostel-list-item__bottom">
                                                            @php
                                                                $iconCount = collect($hostel->icons)->count();
                                                            @endphp
                                                            <div class="left">
                                                                <ul>
                                                                    @forelse (@$hostel->icons as $index=> $icon)
                                                                        @if ($index % $iconCount == 0)
                                                                            <li>@php echo $icon @endphp</li>
                                                                        @elseif($index % $iconCount == 1)
                                                                            <li>@php echo $icon @endphp</li>
                                                                        @elseif($index % $iconCount == 2)
                                                                            <li>@php echo $icon @endphp</li>
                                                                        @elseif($index % $iconCount == 3)
                                                                            <li><i class="fas fa-ellipsis-v"></i>
                                                                                <ul class="hover-item-icon">
                                                                                    @foreach (collect($hostel->icons)->skip(3) as $icon)
                                                                                        <li>@php echo $icon @endphp</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </li>
                                                                        @endif
                                                                    @empty
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="dorms-tight">
                                                    <div class="price">
                                                        @if ($room->discount)
                                                            <span class="discount-tag">{{ $room->discount }}%</span>
                                                        @endif
                                                        <h3 class="title-two">
                                                            @if ($room->discount)
                                                                {{ gs()->cur_sym }}{{ $room->rent_per_day - ($room->rent_per_day / 100) * $room->discount }}
                                                            @else
                                                                {{ gs()->cur_sym }}{{ $room->rent_per_day }}
                                                            @endif

                                                            @if ($room->discount)
                                                                <span>{{ gs()->cur_sym }}{{ $room->rent_per_day }}</span>
                                                            @endif
                                                        </h3>
                                                        <p>{{ ucfirst($room->type) }} @lang('available now')</p>
                                                    </div>
                                                    <div class="bed">
                                                        <div class="bed-select">
                                                            <select class="form-select room_bed_selected">
                                                                <option selected>@lang('Choose')</option>
                                                                @for ($x = 1; $x <= $room->rooms_or_beds - $hostel->checkBookingData($room->id,request()->check_in,request()->check_out); $x++)
                                                                    <option value ="{{ $x }}"
                                                                        data-hostel-id="{{ $hostel->id }}"
                                                                        data-room-id="{{ $room->id }}"
                                                                        data-room-type="{{ $room->type }}"
                                                                        data-rooms-or-beds ="{{ $x }}"
                                                                        value="{{ $x }}">
                                                                        {{ $x }}
                                                                        @if ($room->type == 'room')
                                                                            @lang('Room')
                                                                        @else
                                                                            @lang('Bed')
                                                                        @endif
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- ================== Blog Details Sidebar Start ============= -->
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Booking Summary')</h5>
                            <div class="booking-summary-wrap">
                                <div class="booking-list">
                                </div>
                                <span class="border-left-right"></span>

                                <div class="bottom">
                                    <div class="total">
                                        <h5>@lang('Total')</h5>
                                    </div>
                                    <div class="total">
                                        <h5>@lang('Payable Now')</h5>
                                        <h5 class="text--base" id="totalAmount">{{ gs()->cur_sym }} 0.00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="couponText text-center mb-3">

                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="coupon" id="flexCheckDefault"
                                    disabled>
                                <label class="form-check-label" for="flexCheckDefault">
                                    @lang('Have a Discount Coupon?')
                                </label>
                            </div>

                            <div class="booking-summary-wrap coupon-wrap d-none">
                                <div class="bottom">
                                    <input type="text" id="room_number" name="coupon_code" class="form--control"
                                        placeholder="Coupon Code" value="{{ old('code') }}" />
                                    <button type="button" class="btn btn--base ms-2 w-50 couponButton">
                                        @lang('apply')
                                    </button>
                                </div>

                            </div>
                            <a href="{{ route('user.booking.now') }}" class="btn btn--base w-100">@lang('Book Now')</a>
                        </div>
                    </div>
                    <!-- ================== Blog Details Sidebar End ============= -->
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Hostel single End Here ==================== -->
@endsection

@push('style')
    <style>
        .rating-comment-item .bottom ul {
            color: #ffc107;
        }

        .rating-wrap ul {
            color: #ffc107;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            "use strict";
            $(".room_bed_selected").on('change', function() {
                var auth = @json(auth()->check());
                if (!auth) {
                    window.location.href = "{{ route('user.login') }}";
                }
                const checkIn = $('input[name=check_in]').val();
                const checkOut = $('input[name=check_out]').val();
                const searchShow = $('input[name=search_show]').val();
                const search = $('input[name=search]').val();

                if (checkIn == '' || checkOut == '') {
                    Toast.fire({
                        icon: 'error',
                        title: 'Please select date first'
                    })
                    return false;
                } else if (searchShow == '' || search == '') {
                    Toast.fire({
                        icon: 'error',
                        title: 'Please select location first'
                    })
                    return false;
                }

                const guest = $('input[name=guest]').val();
                const selectedOption = $(this).find(':selected');
                const hostelId = selectedOption.data('hostel-id');
                const roomId = selectedOption.data('room-id');
                const roomType = selectedOption.data('room-type');
                const roomsOrBeds = selectedOption.data('rooms-or-beds');
                var url = "{{ route('user.booking.preview') }}";
                var token = '{{ csrf_token() }}';
                var currency = "{{ gs()->cur_sym }}";
                var data = {
                    hostelId: hostelId,
                    roomId: roomId,
                    roomType: roomType,
                    roomsOrBeds: roomsOrBeds,
                    guest: guest,
                    checkIn: checkIn,
                    checkOut: checkOut,
                    _token: token
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(data) {
                        var bookings = Object.values(data.booking_data);
                        var html = '';
                        bookings.forEach(element => {
                            html += `
                                <div class="booking-item">
                                    <div class="icon" onclick="bookingDelete(this,'${element.room_id}')">
                                        <i class="far fa-trash-alt"></i>
                                    </div>
                                    <h5 class="text-capitalize">${element.roomsOrBeds} ${element.type} </h5>
                                    <h5>${element.title}</h5>
                                    <div class="bottom">
                                        <span>${element.currency} ${element.rentWithDiscount} X ${element.daysDiff} nights </span>
                                        <span class="bookingRent">${element.currency} ${element.rent}</span>
                                    </div>
                                </div>`;
                        });

                        $('.booking-list').html('');
                        $('.booking-list').append(html);
                        $('#totalAmount').text("{{ gs()->cur_sym }}" + ' ' + bookingRent());
                        $('input[type=checkbox]').removeAttr("disabled");

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
            });

            $('input[type=checkbox]').on('click', function() {
                if ($('.coupon-wrap').hasClass('d-none')) {
                    $('.coupon-wrap').removeClass('d-none')
                } else {
                    $('.coupon-wrap').addClass('d-none');
                }
            })

            $('.couponButton').on('click', function() {
                var auth = @json(auth()->check());
                const checkIn = $('input[name=check_in]').val();
                const checkOut = $('input[name=check_out]').val();
                const coupon_code = $('input[name=coupon_code]').val();

                if (!auth) {
                    window.location.href = "{{ route('user.login') }}";
                } else if (checkIn == '' && checkOut == '') {
                    Toast.fire({
                        icon: 'error',
                        title: 'Please limit your date'
                    })
                    return false;
                } else if (coupon == '') {
                    Toast.fire({
                        icon: 'error',
                        title: 'Invalid Coupon'
                    })
                    return false;
                }
                var url = "{{ route('user.booking.coupon.apply') }}";
                var token = '{{ csrf_token() }}';
                var data = {
                    coupon_code: coupon_code,
                    _token: token
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(data) {
                        if (data.status == "success") {
                            var percent = data.data;
                            var text = $('#totalAmount').text();
                            text = text.replace('$', '');
                            text = parseFloat(text) - (parseFloat(text) / 100) * percent;
                            $('#totalAmount').text("{{ gs()->cur_sym }}" + ' ' + text.toFixed(
                                2));
                            $('.couponText').html('<span class="text--success mb-2">' + data
                                .message + '</span>');
                            $('.coupon-wrap').addClass('d-none');
                            $('.form-check').addClass('d-none');

                        } else {
                            $('.couponText').html('<span class="text--danger mb-2">' + data
                                .message + '</span>');
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

            })

        });

        function bookingRent() {
            var bookingRents = $('.bookingRent');
            var total = 0;
            for (let i = 0; i < bookingRents.length; i++) {
                var text = $(bookingRents[i]).text();
                text = text.replace('$', '');
                text = parseFloat(text);
                total += text;
            }
            return total.toFixed(2);

        }

        function bookingDelete(object, roomId) {
            var auth = @json(auth()->check());
            if (!auth) {
                window.location.href = "{{ route('user.login') }}";
            }

            var url = "{{ route('user.booking.delete') }}";
            var token = '{{ csrf_token() }}';
            var data = {
                roomId: roomId,
                _token: token
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                    $(object).parent('.booking-item').remove();
                    $('#totalAmount').text(bookingRent());
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


        // rating set
        $(document).ready(function() {
            'use strict'
            $('.rating-stars i').on('click', function() {
                var rating = parseInt($(this).data('rating'));
                $('#rating').val(rating);
                updateStars(rating);
            });
            $('#rating').on('input', function() {
                var rating = $(this).val();
                updateStars(rating);
            });

            function updateStars(rating) {
                var stars = $('.rating-stars i');
                stars.removeClass('fas').addClass('far');
                stars.each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('far').addClass('fas');
                    }
                });
            }
        });
        // end rating set
    </script>

    <script>
        $('.wishlist-btn').on('click', function(event) {
            var hostel_id = $(this).data('hostel_id');
            var icon = $(this).find("i");
            var auth = @json(auth()->check());
            if (!auth) {
                window.location.href = "{{ route('user.login') }}";
            }
            var url = "{{ route('user.wishlist') }}";
            var token = '{{ csrf_token() }}';
            var data = {
                hostel_id: hostel_id,
                _token: token
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(response) {
                    if (response.wishlist == 0) //removed
                    {
                        var wishlistSub = $('.wishlist-count').text();
                        wishlistSub = parseInt(wishlistSub) - 1;
                        $('.wishlist-count').text(wishlistSub);
                        icon.removeClass("fas fa-heart").addClass("far fa-heart");
                        Toast.fire({
                            icon: 'success',
                            title: 'Hostel remove to wishlist'
                        });
                    } else if (response.wishlist == 1) //added
                    {
                        $('.wishlist-count').text();
                        var wishlistAdd = $('.wishlist-count').text();
                        wishlistAdd = parseInt(wishlistAdd) + 1;
                        $('.wishlist-count').text(wishlistAdd);

                        icon.removeClass("far fa-heart").addClass("fas fa-heart");
                        Toast.fire({
                            icon: 'success',
                            title: 'Hostel add to wishlist'
                        });
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
        });
    </script>
@endpush
