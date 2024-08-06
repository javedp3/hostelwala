@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap">
                <div class="row justify-content-between">
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('user.room.add', $hostel_id) }}"
                            class="btn btn--sm btn--success">@lang('Add New')</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <form  method="GET" autocomplete="off">
                            <div class="search-box w-100">
                                <input type="text" name="search" class="form--control" placeholder="Search..." value="{{ request()->search }}">
                                <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                     
                    </div>
                </div>
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th>@lang('Image')</th>
                            <th>@lang('Title')</th>
                            <th>@lang('Room Code')</th>
                            <th>@lang('Room Type')</th>
                            <th>@lang('AC')</th>
                            <th>@lang('Number of beds')</th>
                            <th>@lang('Rent Per Day')</th>
                            <th>@lang('discount')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($room_lists as $item)
                            <tr>
                                <td data-label="Image"><img
                                        src="{{ getImage(getFilePath('room') . '/' . @$item->image, getFileSize('room')) }}" alt="room-image">
                                </td>
                                <td data-label="Title">{{__(@$item->title)}}</td>
                                <td data-label="Room Number">{{__(@$item->number)}}</td>
                                <td data-label="Room Type">{{__(@$item->type)}}</td>
                                <td data-label="AC">{{__(@$item->ac_type)}}</td>
                                <td data-label="Number of Beds">{{__(@$item->rooms_or_beds)}}</td>
                                <td data-label="Rent Per Day">{{__(@$item->rent_per_day)}}</td>
                                <td data-label="discount">{{__(@$item->discount)}}</td>
                                 <td data-label="Action">
                                    <div class="div">
                                        <a href="{{route('user.room.edit',[slug($hostel_id),($item->id)])}}" class="btn btn--sm btn--warning mb-1"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{route('user.room.delete', [slug($hostel_id),($item->id)])}}" class="btn btn--sm btn--danger mb-1"><i class="fas fa-trash"></i></a>
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
            </div>
        </div>
    </div>
@endsection
