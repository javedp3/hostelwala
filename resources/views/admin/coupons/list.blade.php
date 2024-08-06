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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Number')</th>
                                    <th>@lang('From Date')</th>
                                    <th>@lang('To Date')</th>
                                    <th>@lang('Percent')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($coupon_list as $coupon)
                                    <tr>
                                        <td>
                                            {{ __(@$coupon->name) }}

                                        </td>

                                        <td>
                                            {{ __(@$coupon->number) }}

                                        </td>

                                        <td>
                                            {{ __(@$coupon->from_date) }}
                                        </td>

                                        <td>
                                            {{ @$coupon->to_date }}
                                        </td>

                                        <td>
                                            {{ @$coupon->percent }}
                                        </td>

                                        <td>
                                            <label class="switch m-0">
                                                <input type="checkbox" class="toggle-switch hostelStatus"
                                                    data-id="{{ $coupon->id }}" name="status"
                                                    {{ $coupon->status ? 'checked' : null }}>
                                                <span class="slider round"></span>
                                            </label>
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
                @if ($coupon_list->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($coupon_list) }}
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- NEW MODAL --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"> @lang('Add New Coupon')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.coupon.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Number')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('number') }}" name="number"
                                    required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('From Date')</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" value="{{ old('from_date') }}" name="from_date"
                                    required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('To Date')</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" value="{{ old('to_date') }}" name="to_date"
                                    required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label>@lang('Percent')</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" value="{{ old('percent') }}" name="percent"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <select name="status" id="setDefault" class="form-control">
                                    <option value="1">@lang('Active')</option>
                                    <option value="0">@lang('Disable')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                            value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <a class="btn btn-sm btn--primary me-2 d-flex align-items-center addBtn" data-bs-toggle="modal"
            data-bs-target="#createModal" href="{{ route('admin.hostel.add') }}"><i
                class="las la-plus"></i>@lang('Add New')</a>
        <form method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search by number')"
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
            $('.addBtn').on('click', function() {
                var modal = $('#createModal');
                modal.modal('show');
            });

        })(jQuery);

        $(document).ready(function() {
            "use strict";
            $(".hostelStatus").on('click', function() {
                var url = "{{ route('admin.coupon.status') }}";
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
