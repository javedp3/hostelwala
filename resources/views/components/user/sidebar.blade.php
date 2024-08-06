<div class="dashboard_profile">
    <div class="dashboard_profile__details">
        <div class="dashboard_profile_wrap mb-5">
            <div class="logo-wrapper">
                <a href="{{ route('home') }}"> <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}"
                        alt="Logo"></a>
            </div>
            <i class="fas fa-times close-hide-show"></i>
        </div>
        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item {{ Route::is('user.home') ? 'active' : '' }}">
                <a href="{{ route('user.home') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-tachometer-alt"></i></span>
                    @lang('Dashboard')
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ Route::is('user.home') ? 'active' : '' }}">
                <a href="{{ route('user.booking.my.booked') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-list"></i></span>
                    @lang('Bookings')
                </a>
            </li>  
            <li
                class="sidebar-menu-list__item has-dropdown {{ 
                (Route::is('user.deposit.history') || 
                Route::is('user.hostel.list') || 
                Route::is('user.hostel.add') || 
                Route::is('user.kyc.form') || 
                Route::is('user.kyc.data')|| 
                Route::is('user.booking.list') || 
                Route::is('user.booking.my.booked')) ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fab fa-mendeley"></i></span>
                    @lang('Vendor Options')
                </a>
                <div class="sidebar-submenu {{ 
                (Route::is('user.deposit.history') || 
                Route::is('user.hostel.list') || 
                Route::is('user.hostel.add') || 
                Route::is('user.kyc.form') || 
                Route::is('user.kyc.data')|| 
                Route::is('user.booking.list') || 
                Route::is('user.booking.my.booked')) ? 'd-block' : '' }}">
                    <ul class="sidebar-submenu-list">

                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.hostel.add') }}"
                                class="sidebar-submenu-list__link">@lang('Create New')</a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.hostel.list') }}"
                                class="sidebar-submenu-list__link">@lang('My Hostels')</a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.deposit.history') }}"
                                class="sidebar-submenu-list__link">@lang('Payment History') </a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.booking.list') }}"
                                class="sidebar-submenu-list__link">@lang('Bookings')</a>
                        </li>
                        
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.kyc.form') }}"
                                class="sidebar-submenu-list__link">@lang('KYC Form')</a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.kyc.data') }}"
                                class="sidebar-submenu-list__link">@lang('KYC Data')</a>
                        </li>

                      
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-list__item has-dropdown {{ Route::is('user.withdraw.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-hand-holding-usd"></i></span>
                    @lang('Withdrawals')
                </a>
                <div class="sidebar-submenu {{ Route::is('user.withdraw.*') ? 'd-block' : '' }}"
                    style="display: none;">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.withdraw') }}"
                                class="sidebar-submenu-list__link">@lang('Withdraw') </a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.withdraw.history') }}"
                                class="sidebar-submenu-list__link">@lang('History') </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li
                class="sidebar-menu-list__item has-dropdown {{ Route::is('user.profile.setting') || Route::is('user.twofactor') || Route::is('user.change.password') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-user"></i></span>
                    @lang('Account')
                </a>
                <div
                    class="sidebar-submenu {{ Route::is('user.profile.setting') || Route::is('user.twofactor') || Route::is('user.change.password') ? 'd-block' : '' }}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.profile.setting') }}"
                                class="sidebar-submenu-list__link">@lang('Profile Setting')</a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.change.password') }}"
                                class="sidebar-submenu-list__link">@lang('Change Password ')</a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.twofactor') }}"
                                class="sidebar-submenu-list__link">@lang('2Fa Security')</a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.logout') }}"
                                class="sidebar-submenu-list__link">@lang('Log Out')</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li
                class="sidebar-menu-list__item has-dropdown {{ Route::is('user.wishlist.list') || Route::is('user.wishlist.delete') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-money-check-alt"></i></span>
                    @lang('Wishlist')
                </a>
                <div class="sidebar-submenu {{ Route::is('user.wishlist.list') || Route::is('user.wishlist.delete') ? 'd-block' : '' }}"
                    style="display: none;">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('user.wishlist.list') }}"
                                class="sidebar-submenu-list__link">@lang('History') </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li
                class="sidebar-menu-list__item has-dropdown {{ Request::routeIs('ticket') || Request::routeIs('ticket.open') || Request::routeIs('ticket.view') || Request::routeIs('ticket.download') ? 'active' : '' }} ">
                <a href="javascript:void(0)" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-headphones"></i></span>
                    @lang('Support Ticket')
                </a>
                <div
                    class="sidebar-submenu {{ Request::routeIs('ticket') || Request::routeIs('ticket.open') || Request::routeIs('ticket.view') || Request::routeIs('ticket.download') ? 'd-block' : '' }}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('ticket') }}" class="sidebar-submenu-list__link">@lang('Support Ticket')</a>
                        </li>
                        <li class="sidebar-submenu-list__item">
                            <a href="{{ route('ticket.open') }}"
                                class="sidebar-submenu-list__link">@lang('New Ticket') </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item {{ Route::is('user.transactions') ? 'active' : '' }}">
                <a href="{{ route('user.transactions') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-book"></i></span>
                    @lang('Transactions')
                </a>
            </li>
        </ul>

        <ul class="sidebar-menu-list border-top pt-4">
            <li class="sidebar-menu-list__item">
                <a href="{{ route('user.logout') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                    @lang('Sign Out')
                </a>
            </li>
        </ul>
    </div>
</div>
