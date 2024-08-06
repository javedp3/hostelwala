@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="dashboard-card-wrap">
                    <div class="row justify-content-end">
                        <div class="col-md-4 mb-3">
                            <form  method="GET" autocomplete="off">
                                <div class="search-box w-100">
                                    <input type="text" class="form--control" name="search" placeholder="Search..."
                                        value="{{ request()->search }}">
                                    <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                    <td data-label="Rooms or Beds">{{ __($item->rooms_or_beds . ' ' . $item->type) }} </td>
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
@endsection
