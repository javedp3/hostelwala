@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="dashboard-card-wrap">
                    <div class="d-flex justify-content-end mb-3">
                        <a class="btn btn--base btn--sm" href="{{ route('ticket.open') }}">
                            @lang('Create Ticket') <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($supports as $support)
                                <tr>
                                    <td data-label="Subject">
                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold">
                                            [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                        </a>
                                    </td>
                                    <td data-label="Status">
                                        <span> @php echo $support->statusBadge; @endphp </span>
                                    </td>
                                    <td data-label="Priority">
                                        @if ($support->priority == 1)
                                            <span class="badge badge--danger">@lang('Low')</span>
                                        @elseif($support->priority == 2)
                                            <span class="badge badge--success">@lang('Medium')</span>
                                        @elseif($support->priority == 3)
                                            <span class="badge badge--primary">@lang('High')</span>
                                        @endif
                                    </td>
                                    <td data-label="Last Reply">
                                        {{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
                                    <td data-label="Action" class="text-danger table-btn">
                                        <a href="{{ route('ticket.view', $support->ticket) }}"
                                            class="btn btn--base btn--sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td data-label="Subject" colspan="100%" class="text-center">@lang('No Ticket Found')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{$supports->links()}}
            </div>
        </div>
    </div>
@endsection
