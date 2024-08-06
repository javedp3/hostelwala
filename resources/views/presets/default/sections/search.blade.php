<div class="search-wrapper">
    <form method="GET" autocomplete="off">
        @if (Route::is('home'))
            <div class="container">
        @endif
        <div class="search-bg-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="search-title">@lang('Search for booking')</h6>
                </div>
                <div class="col-xl-12">
                    <div class="search-item-wrap">
                        <div class="search-item destination">
                            <input type="hidden" name="search" value="{{ request()->search ?? old('search') }}">
                            <label for="search_show">@lang('Destination')</label>
                            <input type="text" id="search_show" name="search_show" placeholder="Where you wanna go?"
                                onkeyup="locations(this)" value="{{ request()->search_show ?? old('search_show') }}">
                            <span class="icon"><i class="fas fa-map-marker"></i></span>

                            <ul class="search-result-box d-none">

                            </ul>
                        </div>
                        <div class="search-item check-in">

                            <label for="check_in">@lang('Check in')</label>
                            <input name="check_in" id="check_in" class="datepicker-active" data-language="en"
                                placeholder="Check In" value="{{ request()->check_in ?? old('check_in') }}">
                            <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <div class="search-item check-out">
                            <label for="check_out">@lang('Check out')</label>
                            <input name="check_out" id="check_out" class="datepicker-active" data-language="en"
                                placeholder="Check Out" value="{{ request()->check_out ?? old('check_out') }}">
                            <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <div class="search-item who" id="search-input-show">
                            <label for="guest">@lang('who')</label>
                            <input type="text" id="guest" name="guest" placeholder="1 Guest"
                                value="{{ request()->guest ?? old('guest') }}">
                            <span class="icon"><i class="fas fa-user"></i></span>

                        </div>
                        <div class="search-item button">
                            <button type="submit" class="btn btn--base">@lang('Search Hostel')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Route::is('home'))
        </div>
        @endif
    </form>
</div>



@push('script')
    <script>
        function locations(object) {
            var search = $(object).val();
            var appendClass = $('.search-result-box');
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
                        console.log(data.hostel);
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
