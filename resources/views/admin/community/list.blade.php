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
                                    <th>@lang('User')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Description')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($communities as $community)
                                    <tr>
                                        <td>
                                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$community->user->image, getFileSize('userProfile')) }}"
                                                class='img-thumbnail rounded-circle' title='@lang('Image')' width="75px"
                                                height="75px">
                                        </td>
                                        <td class="text-capitalize">
                                            {{ __(@$community->title) }}

                                        </td>

                                        <td>
                                            @php echo (__(strWords(@$community->description))) @endphp
                                        </td>

                                        <td>
                                            <label class="switch m-0">
                                                <input type="checkbox" class="toggle-switch communityStatus"
                                                    data-id="{{ $community->id }}" name="status"
                                                    {{ $community->status ? 'checked' : null }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <a title="@lang('View community')"
                                                href="{{ route('community.details', $community->id) }}"
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
                @if ($communities->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($communities) }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection


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
            $(".communityStatus").on('click', function() {
                var url = "{{ route('admin.community.status') }}";
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
