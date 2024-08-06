@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-xl-12 col-lg-12">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="room-card">
                        <a href="javascript:void(0)"></a>
                        <div class="room-card__icon card-primary">
                            <i class="fas fa-suitcase"></i>
                        </div>
                        <div class="room-card__text">
                            <h4 class="title">{{ $newBooking }}</h4>
                            <span>@lang('new BOOKING')</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="room-card">
                        <a href="javascript:void(0)"></a>
                        <div class="room-card__icon card-success">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <div class="room-card__text">
                            <h4 class="title">{{ number_format((float) $totalAmount->balance, 2, '.', '') }}</h4>
                            <span>@lang('Total Amount')</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="room-card">
                        <a href="javascript:void(0)"></a>
                        <div class="room-card__icon card-danger">
                            <i class="fas fa-x-ray"></i>
                        </div>
                        <div class="room-card__text">
                            <h4 class="title">{{ $totalBooking }}</h4>
                            <span>@lang('total booking')</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="apexcharts-wrap mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="apexcharts-wrap">
                            <div id="chart-wrap">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">@lang('Total Number of Booking Vs Your Booking')</h5>
                                        <div id="account-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-card-wrap">
                        <table class="table table--responsive--lg">
                            <thead>
                                <tr>
                                    <th>@lang('No')</th>
                                    <th>@lang('Room Name')</th>
                                    <th>@lang('Check In')</th>
                                    <th>@lang('Check Out')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Room Type')</th>
                                    <th>@lang('Rooms or Beds')</th>
                                    <th>@lang('Coupon Discount')</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booking_list as $item)
                                    <tr>
                                        <td data-label="No">{{ __($loop->iteration) }}</td>
                                        <td data-label="Room Name">{{ __($item->room_title) }}</td>
                                        <td data-label="Check In">{{ showDateTime($item->from_date, 'd M, Y') }}</td>
                                        <td data-label="Check Out">{{ showDateTime($item->to_date, 'd M, Y') }}</td>
                                        <td data-label="Status">
                                            @if ($item->status == 1)
                                                <span class="badge badge--success"> @lang('Paid')</span>
                                            @else
                                                <span class="badge badge--danger"> @lang('Holding')</span>
                                            @endif
                                        </td>
                                        <td data-label="Room Type">{{ __(ucfirst($item->type)) }}</td>
                                        <td data-label="Rooms or Beds">{{ __($item->rooms_or_beds . ' ' . $item->type) }}
                                        </td>
                                        <td data-label="Coupon Discount">{{ __($item->coupon->percent ?? 0) }}% </td>
                                       
                                    </tr>
                                @empty
                                    <tr>
                                        <td data-label="No" colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $booking_list->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <!-- Footer -->
    <!--========== ApexCharts js ========== -->
    <script src="{{ asset('assets/admin/js/apexcharts.min.js') }}"></script>
    <script>
        "use strict";
        // [ account-chart ] start
        (function() {
            var options = {
                chart: {
                    type: 'area',
                    stacked: false,
                    height: '310px'
                },
                stroke: {
                    width: [0, 3],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                colors: ['#00adad', '#67BAA7'],
                series: [{
                    name: '@lang('Total Bookings')',
                    type: 'column',
                    data: @json($totalBookings['values'])
                }, {
                    name: '@lang('Your Bookings')',
                    type: 'area',
                    data: @json($bookings['values'])
                }],
                fill: {
                    opacity: [0.85, 1],
                },
                labels: @json($bookings['labels']),
                markers: {
                    size: 0
                },
                xaxis: {
                    type: 'text'
                },
                yaxis: {
                    min: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(y) {
                            if (typeof y !== "undefined") {
                                return "$ " + y.toFixed(0);
                            }
                            return y;

                        }
                    }
                },
                legend: {
                    labels: {
                        useSeriesColors: true
                    },
                    markers: {
                        customHTML: [
                            function() {
                                return ''
                            },
                            function() {
                                return ''
                            }
                        ]
                    }
                }
            }
            var chart = new ApexCharts(
                document.querySelector("#account-chart"),
                options
            );
            chart.render();
        })();
    </script>
@endpush
