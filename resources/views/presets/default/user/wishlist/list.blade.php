@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap">
                <div class="row justify-content-end">
                    <div class="col-md-4 mb-3">
                        <form  method="GET" autocomplete="off">
                            <div class="search-box w-100">
                                <input type="text" class="form--control" name="search" placeholder="Search..." value="{{ request()->search }}">
                                <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th>@lang('Hostel')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wishlists as $item)
                            <tr>
                                <td data-label="Hostel"> <img src="{{ getImage(getFilePath('hostel') . '/' . @$item->hostel?->hostel_images[0]->path . @$item->hostel?->hostel_images[0]->image, getFileSize('hostel')) }}"
                                    alt=""></td>
                                <td data-label="Name">{{__(@$item->hostel?->name)}}</td>
                                <td data-label="Action">
                                    <a href="{{route('user.wishlist.delete', $item->id)}}" class="btn btn--sm btn--danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" data-label="Hostel" colspan="100%">@lang('No data Found')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$wishlists->links() }}
            </div>
        </div>
    </div>
@endsection
