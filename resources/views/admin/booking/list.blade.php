@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Booking-User')</th>
                                    <th>@lang('Author')</th>
                                    <th>@lang('Hostel Name')</th>
                                    <th>@lang('Room Name')</th>
                                    <th>@lang('Check In')</th>
                                    <th>@lang('Check Out')</th>
                                    <th>@lang('Rooms or Beds')</th>
                                    <th>@lang('Rent Per Day')</th>
                                    <th>@lang('Coupon Discount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($booking_list as $item)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('admin.users.detail', @$item->tenant_id) }}">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$item->tenant?->image) }}"
                                                    class='img-thumbnail tenant' title='@lang('Image')' width="75px"
                                                    height="75px">
                                            </a>
                                        </td>

                                        <td>
                                            @if (@$item->owner_type == 'user')
                                                <a href="{{ route('admin.users.detail', @$item->owner_id) }}">
                                                    {{ __(@$item->owner?->username) }}
                                                </a>
                                            @else
                                                <a href="">{{ __(auth('admin')->user()->name) }}</a>
                                            @endif

                                        </td>

                                        <td>
                                            {{ __(@$item->hostel?->name) }}
                                        </td>

                                        <td>
                                            {{ __(@$item->room?->title) }}
                                        </td>
                                        <td>
                                            {{ __(showDateTime(@$item->from_date, 'd M,Y')) }}
                                        </td>
                                        <td>
                                            {{ __(showDateTime(@$item->to_date, 'd M,Y')) }}
                                        </td>

                                        <td>
                                            {{ @$item->rooms_or_beds }} {{ @$item->type }}
                                        </td>

                                        <td>
                                            {{ gs()->cur_sym }} {{ @$item->rent_per_day }}
                                        </td>

                                        <td>
                                            {{ @$item->discount }}
                                        </td>

                                        <td>
                                            @if (@$item->status == 1)
                                                <span class="badge badge--success">@lang('Approved')</span>
                                            @elseif(@$item->status == 2)
                                                <span class="badge badge--warning">@lang('Pending')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('canceled')</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a title="@lang('View hostel')"
                                                href="{{ route('hostel_list_details', [slug($item->hostel?->name), $item->hostel?->id]) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-eye text--shadow"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($booking_list->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($booking_list) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection


@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <form method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search by Username')"
                    value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

@push('style')
    <style>
        .tenant {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
    </style>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";
            $(".reason").on('click', function() {
                $('.reason-text').text($(this).data('reason'))
                $("#reasonModal").modal('show');
            });

        })(jQuery);

        $(document).ready(function() {
            "use strict";
            $(".hostelStatus").on('click', function() {
                var url = "{{ route('admin.room.status') }}";
                var token = '{{ csrf_token() }}';
                var data = {
                    id: $(this).data("id"),
                    _token: token
                }
                $.post(url, data, function(data, status) {
                    if (data.status == "success") {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                    }
                });
            });

        });
    </script>
@endpush
