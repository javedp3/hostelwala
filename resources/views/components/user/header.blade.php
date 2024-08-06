<div class="row">
    <div class="col-lg-12">
        <div class="dashboard-header-wrap d-flex justify-content-between">
            <div class="header-left d-flex align-items-center">
                <h4 class="title-three mb-0">{{ @$pageTitle }}</h4>
                <button>
                    <i class="fas fa-bars dashboard-show-hide"></i>
                </button>
            </div>
            <div class="header-right">
                <div class="item">
                    <div class="profile">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}" alt="">
                        <div class="icon"><i class="fas fa-angle-down"></i></div>
                        <ul class="profile-menu">
                            <li class="profile-menu__item">
                                <a class="profile-menu__link" href="{{route('user.logout')}}">@lang('Log Out') <i
                                        class="fas fa-sign-out-alt"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="item">
                    <a class="btn btn--base btn--sm" href="{{ route('home') }}">@lang('Home')</a>
                </div>
            </div>
        </div>
    </div>
</div>