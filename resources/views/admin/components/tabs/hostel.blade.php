<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.hostel.list') ? 'active' : '' }}"
                    href="{{ route('admin.hostel.list') }}">@lang('All Hostel')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.hostel.my.list') ? 'active' : '' }}"
                    href="{{ route('admin.hostel.my.list') }}">@lang('My Hostel')</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.hostel.pending') ? 'active' : '' }}"
                    href="{{ route('admin.hostel.pending') }}">@lang('Pending')
                    @if ($pendingHostelCount)
                        <span class="badge rounded-pill bg--white text-muted">{{ $pendingHostelCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.hostel.active') ? 'active' : '' }}"
                    href="{{ route('admin.hostel.active') }}">@lang('Active')</a>
            </li>
        </ul>
    </div>
</div>
