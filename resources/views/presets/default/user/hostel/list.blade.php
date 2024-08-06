@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap">
                <div class="row justify-content-end">
                    <div class="col-md-4 mb-3">
                        <form method="GET" autocomplete="off">
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
                            <th>@lang('Name')</th>
                            <th>@lang('Latitude')</th>
                            <th>@lang('Longitude')</th>
                            <th>@lang('Address')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hostel_list as $item)
                            <tr>
                                <td data-label="Name">{{ __(@$item->name) }}</td>
                                <td data-label="Latitude">{{ __(@$item->latitude) }}</td>
                                <td data-label="Longitude">{{ __(@$item->longitude) }}</td>
                                <td data-label="Address">{{ __(strLimit(@$item->address, 25)) }}</td>
                                <td data-label="Action">
                                    <div class="div">
                                        @if ($item->status === 1)
                                            <a href="{{ route('user.room.list', $item->id) }}"
                                                class="btn btn--sm btn--success mb-1"><i class="fas fa-door-open"></i></a>
                                        @endif
                                        <a href="{{ route('user.hostel.edit', $item->id) }}"
                                            class="btn btn--sm btn--warning mb-1"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="{{ route('user.hostel.delete', $item->id) }}"
                                            class="btn btn--sm btn--danger mb-1"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" data-label="Name" colspan="100%">@lang('No data Found')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $hostel_list->links() }}
            </div>
        </div>
    </div>
@endsection
