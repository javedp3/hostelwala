<div class="sidebar-menu-wrapper">
    <div class="top-close d-flex align-items-center justify-content-between mb-4">
        <div class="header-wrapper-siedebar">
            <div class="logo-wrapper ms-3">
                </a>
                <a href="{{ route('home') }}" class="normal-logo" id="footer-logo-normal"> <img
                        src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo"></a>
            </div>
        </div>
        <i class="fas fa-times close-hide-show"></i>
    </div>
    <ul class="sidebar-menu-list">

        @foreach ($pages as $page)
            <li class="sidebar-menu-list__item"><a
                    class="sidebar-menu-list__link {{ Request::url() == url('/') . '/' . $page->slug ? 'active' : '' }}"
                    aria-current="page" href="{{ route('pages', [$page->slug]) }}">{{ __(ucfirst($page->name)) }}</a>
            </li>
        @endforeach
        <li class="sidebar-menu-list__item">
            <a href="{{ route('hostel_list') }}" class="sidebar-menu-list__link">@lang('Hostels')</a>
        </li>


        <li class="sidebar-menu-list__item mb-3 ms-3">
            <div class="language-box ms-1">
                <select class="select langSel">
                    @foreach ($languages as $language)
                        <option value="{{ $language->code }}" @if (Session::get('lang') === $language->code) selected @endif>
                            {{ __(ucfirst($language->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </li>

        <li class="sidebar-menu-list__item d-flex justify-content-between mb-3">

            @guest
                <a class="btn btn--base border-none mt-2 mb-2 ms-2" href="{{ route('user.login') }}"><i
                        class="fas fa-user"></i>
                    @lang('Login') </a>
            @endguest
            @auth
                <a class="btn btn--base border-none mt-2 mb-2 ms-2" href="{{ route('user.home') }}"><i
                        class="fas fa-user"></i>
                    @lang('Dashboard')</a>


                <a href="{{ route('user.wishlist') }}"
                    class='btn border-none  btn--base fav-btn mt-2 mb-2 me-2 love-btn'><i class="fas fa-heart"></i><span
                        class="wishlist-count"> {{ $wishlist ?? 00 }}</span>
                </a>
            @endauth


        </li>
        <li class="sidebar-menu-list__item ms-3">
            <a class='btn btn--base' href="{{ route('hostel_list') }}"> @lang('Book Now') </a>
        </li>
    </ul>
</div>
