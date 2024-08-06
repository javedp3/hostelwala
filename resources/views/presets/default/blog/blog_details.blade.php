@php
    $blogPostSection = getContent('blog_post.element', false, 4);
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Blog Start Here ==================== -->
    <section class="blog-detials py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details">

                        <div class="blog-item">
                            <div class="blog-item__thumb">
                                <img src="{{ getImage(getFilePath('blog_post') . '/' . @$blogItem->data_values?->blog_image) }}"
                                    alt="blog-image">
                            </div>
                            <div class="blog-bottom-wrap mt-1 ps-0 pe-0">
                            </div>
                            <div class="blog-item__content pt-2">
                                <ul class="text-list inline">
                                    <li class="text-list__item"> <span class="text-list__item-icon"><i
                                                class="fas fa-calendar-alt"></i></span>{{ __(showDateTime(@$blogItem->created_at, 'd M Y')) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog-details__content">
                            <h3 class="blog-details__title">{{__(@$blogItem->data_values?->title) }}</h3>
                            <p class="blog-details__desc">@php echo (__(@$blogItem->data_values?->description)) @endphp</p>

                            <div class="blog-details__share mt-4 d-flex align-items-center flex-wrap mb-4">
                                <h5 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This')</h5>
                                <ul class="social-list blog-details">
                                    <li class="social-list__item"><a
                                            href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug(@$blogItem->data_values?->title) }}"
                                            class="social-list__link"><i class="fab fa-facebook-f"></i></a> </li>
                                    <li class="social-list__item"><a
                                            href="https://twitter.com/intent/tweet?status={{ slug(@$blogItem->data_values?->title) }}+{{ Request::url() }}"
                                            class="social-list__link"> <i class="fab fa-twitter"></i></a></li>
                                    <li class="social-list__item"><a
                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug(@$blogItem->data_values?->title) }}&source=behands"
                                            class="social-list__link"> <i class="fab fa-linkedin-in"></i></a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- ============================= Blog Details Sidebar Start ======================== -->
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Hot Topics')</h5>
                            @foreach ($blogPostSection as $item)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('blog_details', $item->id) }}"> <img
                                                src="{{ getImage(getFilePath('blog_post') . '/' . @$item->data_values->blog_image) }}"
                                                alt="blog-image"></a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title"><a
                                                href="{{ route('blog_details', $item->id) }}">{{ __($item->data_values?->title) }}</a>
                                        </h6>
                                        <span
                                            class="latest-blog__date">{{ __(showDateTime($item->created_at, 'M d Y')) }}</span>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <!-- ============================= Blog Details Sidebar End ======================== -->
            </div>
        </div>
    </section>


    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
    <!-- ==================== Blog End Here ==================== -->
@endsection
