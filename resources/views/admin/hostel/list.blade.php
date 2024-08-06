@extends('admin.layouts.app')
@section('panel')
    @include('admin.components.tabs.hostel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Author')</th>
                                    <th>@lang('Hostel Name')</th>
                                    <th>@lang('Address')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($hostel_list as $hostel)
                                    <tr>
                                        <td>
                                            @if ($hostel->user_type == 'user')
                                                <a href="{{ route('admin.users.detail', @$hostel->user->id) }}">{{ __(@$hostel->user?->fullname) }}
                                                    ({{ __(@$hostel->user?->username) }})
                                                </a>
                                            @else
                                                <a href="">{{ __(auth('admin')->user()->name) }}</a>
                                            @endif

                                            @if ($hostel->pendingRoomCount() > 0)
                                                <span
                                                    class="badge rounded-pill bg--white text-muted">{{ $hostel->pendingRoomCount() }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ __(@$hostel->name) }}
                                        </td>

                                        <td>
                                            {{ @$hostel->address }}
                                        </td>

                                        <td>
                                            <label class="switch m-0">
                                                <input type="checkbox" class="toggle-switch hostelStatus"
                                                    data-id="{{ $hostel->id }}" name="status"
                                                    {{ $hostel->status ? 'checked' : null }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a title="@lang('View Room')" href="{{ route('admin.room.list', $hostel->id) }}"
                                                class="btn btn-sm btn--primary">
                                                <i class="las la-door-open"></i>
                                            </a>
                                            <a title="@lang('View hostel')"
                                                href="{{ route('hostel_list_details',[slug($hostel->name), $hostel->id]) }}"
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
                @if ($hostel_list->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($hostel_list) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <a class="btn btn-sm btn--primary me-2 d-flex align-items-center" href="{{ route('admin.hostel.add') }}"><i
                class="las la-plus"></i>@lang('Add New')</a>
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
                var url = "{{ route('admin.hostel.status') }}";
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
