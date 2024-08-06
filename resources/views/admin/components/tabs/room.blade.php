<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.room.list', $hostel->id) ? 'active' : '' }}"
                    href="{{ route('admin.room.list', $hostel->id) }}">
                    @if ($hostel->user_id == auth('admin')->id() && $hostel->user_type == 'admin')
                        @lang('My list')
                    @else
                        @lang('Room list')
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.room.active', $hostel->id) ? 'active' : '' }}"
                    href="{{ route('admin.room.active', $hostel->id) }}">@lang('Active')</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.room.pending', $hostel->id) ? 'active' : '' }}"
                    href="{{ route('admin.room.pending', $hostel->id) }}">@lang('Pending')
                    @if ($pendingRoomCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $pendingRoomCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>
