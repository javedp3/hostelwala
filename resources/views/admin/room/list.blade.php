@extends('admin.layouts.app')
@section('panel')
    @include('admin.components.tabs.room')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Author')</th>
                                    <th>@lang('Hostel Name')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Beds Capacity')</th>
                                    <th>@lang('Rent')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($room_list as $room)
                                    <tr>
                                        <td>
                                            <img src="{{ getImage(getFilePath('room') . '/' . $room->image) }}"
                                                class='img-thumbnail' title='@lang('Image')' width="75px"
                                                height="75px">
                                        </td>

                                        <td>
                                            @if ($room->user)
                                                <a href="{{ route('admin.users.detail', @$room->user->id) }}">{{ __(@$room->user?->fullname) }}
                                                    ({{ __(@$room->user?->username) }})
                                                </a>
                                            @else
                                                <a href="">{{ __(auth('admin')->user()->name) }}</a>
                                            @endif

                                        </td>

                                        <td>
                                            {{ __(@$room->hostel->name) }}
                                        </td>

                                        <td>
                                            {{ @$room->title }}
                                        </td>

                                        <td>
                                            {{ @$room->rooms_or_beds }}
                                        </td>
                                        <td>
                                            {{ gs()->cur_sym }} {{ @$room->rent_per_day }}
                                        </td>

                                        <td>
                                            <label class="switch m-0">
                                                <input type="checkbox" class="toggle-switch hostelStatus"
                                                    data-id="{{ $room->id }}" name="status"
                                                    {{ $room->status ? 'checked' : null }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <a title="@lang('View hostel')"
                                                href="{{ route('hostel_list_details', [slug($hostel->id),$room->id]) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-eye text--shadow"></i>
                                            </a>
                                            @if ($hostel->user_id == auth('admin')->id() && $hostel->user_type == 'admin')
                                                <a title="@lang('Edit room')"
                                                    href="{{ route('admin.room.edit', [slug($hostel->id),$room->id]) }}"
                                                    class="btn btn-sm btn--primary">
                                                    <i class="la la-pencil text--shadow"></i>
                                                </a>
                                                <a title="@lang('Delete')"
                                                    href="{{ route('admin.room.delete',[slug($hostel->id),$room->id]) }}"
                                                    class="btn btn-sm btn--danger">
                                                    <i class="las la-trash text--shadow"></i>
                                                </a>
                                            @endif
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
                @if ($room_list->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($room_list) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection


@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        @if ($hostel->user_id == auth('admin')->id() && $hostel->user_type == 'admin')
            <a class="btn btn-sm btn--primary me-2 d-flex align-items-center"
                href="{{ route('admin.room.add', $hostel->id) }}"><i class="las la-plus"></i>@lang('Add New')</a>
        @endif
        <form  method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search by Username')"
                    value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
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
