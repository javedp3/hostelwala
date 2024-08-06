@php
    $existLike = @$community->community_likes?->where('user_id', auth()->id())->first();
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Blog Start Here ==================== -->
    <section class="community-detials-wrap py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details">
                        <div class="blog-item">
                            <div class="mb-3 d-flex justify-content-between">
                                <div>
                                    <div class="blog-details-top-wrap">
                                        <div class="blog-details-top">
                                            <div class="thumb">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$community->user?->image, getFileSize('userProfile')) }}"alt="">
                                            </div>
                                            <div class="content">
                                                <p>
                                                    <strong
                                                        class="user-profile-comminuty text-capitalize">{{ __(@$community->user?->fullname) }}</strong>
                                                </p>
                                                <p>{{ __(showDateTime(@$community->created_at, 'd M Y')) }}</p>
                                            </div>

                                        </div>
                                        </h3>
                                    </div>
                                </div>
                                <div>
                                    @if (auth()->id() == @$community->user?->id)
                                        <div class="top-wrapper">
                                            <div class="right">
                                                <div class="icon single-item-menu">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                    <ul class="post-top-menu">
                                                        <li class="post-top-menu__item" data-id={{ $community->id }}
                                                            data-title="{{ @$community->title }}"
                                                            data-description="{{ @$community->description }}"
                                                            data-image="{{ @$community->image }}">
                                                            <a href="{{ route('user.community.edit', $community->id) }}"
                                                                class="post-top-menu__link">
                                                                <span class="icon"><i class="fas fa-edit"></i></span>
                                                                <span class="text">@lang('Edit Post')</span>
                                                            </a>
                                                        </li>
                                                        <li class="post-top-menu__item">
                                                            <a class="post-top-menu__link"
                                                                href="{{ route('user.community.delete', $community->id) }}">
                                                                <span class="icon"><i class="fas fa-trash"></i></span>
                                                                <span class="text">@lang('Move to achive')</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="blog-item__thumb">
                                <img src="{{ getImage(getFilePath('community_post') . '/' . @$community->image, getFileSize('community_post')) }}"
                                    alt="community-image">
                            </div>
                            <div class="blog-bottom-wrap mt-1 ps-0 pe-0">
                            </div>
                        </div>
                        <div class="blog-details__content">
                            <h3 class="blog-details__title text-capitalize d-block">{{ __(@$community->title) }}
                            <p class="blog-details__desc">@php echo (__(@$community->description)) @endphp</p>
                            <div class="community-item bottom-wrapper">
                                <div class="community-bottom mt-1">
                                    <ul class="left">
                                        <li>
                                            <div class="comment-voting vote-qty">
                                                <button class="vote-qty__increment"
                                                    onclick="likeCommunity(this,{{ $community->id }})">
                                                    <i class="{{ $existLike != null ? 'fas' : 'far' }} fa-thumbs-up"></i>
                                                </button>
                                                <span
                                                    class="vote-qty__value">{{ number_format_short(@$community->community_likes->count()) ?? 0 }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <button><i class="fas fa-comment-alt"></i>
                                                <span>{{ number_format_short(@$community->commentCount()) }}
                                                    @lang('Comments')</span></button>
                                        </li>
                                        <li>
                                            <button><i class="fas fa-eye"></i>
                                                <span>{{ number_format_short(@$community->view) }} @lang('Views')</span></button>
                                        </li>
                                        <li>
                                            <div class="top-wrapper">
                                                <div class="right">
                                                    <div class="icon single-item-menu community-share">
                                                        <button>
                                                            <i class="fas fa-share"></i>
                                                            <span>@lang('Share')</span>
                                                        </button>
                                                        <ul class="post-top-menu community-item-share">
                                                            <li class="post-top-menu__item">
                                                                <a
                                                                    href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug(@$community->title) }}">
                                                                    <i class="fab fa-facebook-f"></i>
                                                                    <span>@lang('Facebook')</span>
                                                                </a>
                                                            </li>
                                                            <li class="post-top-menu__item">
                                                                <a
                                                                    href="https://twitter.com/intent/tweet?status={{ slug(@$community->title) }}+{{ Request::url() }}">
                                                                    <i class="fab fa-twitter"></i>
                                                                    <span>@lang('Twitter')</span>
                                                                </a>
                                                            </li>
                                                            <li class="post-top-menu__item">
                                                                <a
                                                                    href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug(@$community->title) }}&source=behands">
                                                                    <i class="fab fa-linkedin-in"></i>
                                                                    <span>@lang('Linkedin')</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="contact-form pt-2">
                                <div class="col-lg-12 pt-4">
                                    <ul class="comment-list">
                                        @foreach ($comments as $item)
                                            <li class="comment-list__item d-flex flex-wrap">
                                                <div class="comment-list__thumb">
                                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$item->user?->image, getFileSize('userProfile')) }}"
                                                        alt="">
                                                </div>
                                                <div class="comment-list__content">
                                                    <div class="comment-list__name">
                                                        {{ __(@$item->user->firstname . ' ' . @$item->user->lastname) }}
                                                        <span class="comment-list__time-icon mx-2">
                                                            <button>
                                                                <i class="far fa-clock"></i>
                                                            </button>
                                                            {{ diffForHumans($item->created_at) }}
                                                        </span>
                                                    </div>

                                                    <p class="comment-list__desc">@php echo (__($item->comment)) @endphp </p>
                                                    <div class="like-view-wrapper">
                                                        <div class="comment-card-footer">
                                                            <ul class="user-actn">
                                                                <li>
                                                                    <div class="comment-voting vote-qty">
                                                                        <button class="vote-qty__increment"
                                                                            onclick="likeComment(this,{{ $item->id }})">
                                                                            <i
                                                                                class="{{ @$item->existLike() != null ? 'fas' : 'far' }} fa-thumbs-up"></i>
                                                                        </button>
                                                                        <span
                                                                            class="vote-qty__value">{{ number_format_short(@$item->comment_likes?->count()) ?? 0 }}</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mb-4 text-end">
                                        {{ $comments->links() }}
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('user.community.comment.store') }}"
                                    autocomplete="off">
                                    @csrf
                                    <div class="row gy-md-4 gy-3">
                                        <input type="hidden" name="community_id" value="{{ $community->id }}">
                                        <div class="col-sm-12">
                                            <textarea class="form--control" name="comment" placeholder="@lang('Your Comments')"></textarea>
                                        </div>
                                        <div class="col-sm-12 text-end">
                                            <button class="btn btn--base"> @lang('Comment') <span class="button__icon"><i
                                                        class="fas fa-paper-plane"></i></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================= Blog Details Sidebar Start ======================== -->
                <div class="col-lg-4">
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Recent Communities Post')</h5>
                            @foreach ($communities as $item)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('community.details', $item->id) }}"> <img
                                                src="{{ getImage(getFilePath('community_post') . '/' . @$item->image) }}"
                                                alt="blog-image"></a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title"><a
                                                href="{{ route('community.details', $item->id) }}">{{ __($item->title) }}</a>
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


@push('script')
    <script>
        // Community likes
        function likeCommunity(object, id) {
            var auth = @json(auth()->check());
            if (auth) {
                var url = "{{ route('user.community.like') }}";
                var token = '{{ csrf_token() }}';
                var data = {
                    community_id: id,
                    _token: token
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(data) {
                        $(object).siblings(".vote-qty__value").text(number_format_short(data.likeCount));
                        if (data.likeStatus == 1) {
                            $(object).find('i').removeClass('far').addClass('fas');
                        } else {
                            $(object).find('i').removeClass('fas').addClass('far');
                        }

                    },
                    error: function(data, status, error) {
                        $.each(data.responseJSON.errors, function(key, item) {
                            Toast.fire({
                                icon: 'error',
                                title: item
                            })
                        });

                    }
                });
            } else {
                window.location.href = "{{ route('user.login') }}";
            }
        }

        // comment votes
        function likeComment(object, id) {
            var auth = @json(auth()->check());
            if (auth) {
                var url = "{{ route('user.community.comment.like') }}";
                var token = '{{ csrf_token() }}';
                var data = {
                    comment_id: id,
                    _token: token
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(data) {
                        $(object).siblings(".vote-qty__value").text(number_format_short(data.likeCount));
                        if (data.likeStatus == 1) {
                            $(object).find('i').removeClass('far').addClass('fas');
                        } else {
                            $(object).find('i').removeClass('fas').addClass('far');
                        }
                    },
                    error: function(data, status, error) {
                        $.each(data.responseJSON.errors, function(key, item) {
                            Toast.fire({
                                icon: 'error',
                                title: item
                            })
                        });

                    }
                });
            } else {
                window.location.href = "{{ route('user.login') }}";
            }
        }


        // Number formate
        function number_format_short(like, type = '') {
            var n_format;
            var suffix = '';
            if (like >= 0 && like < 1000) {
                // 1 - 999
                n_format = Math.floor(like);
                suffix = '';
            } else if (like >= 1000 && like < 1000000) {
                // 1k-999k
                n_format = Math.floor(like / 1000);
                $suffix = 'K+';
            } else if (like >= 1000000 && like < 1000000000) {
                // 1m-999m
                n_format = Math.floor(like / 1000000);
                $suffix = 'M+';
            } else if (like >= 1000000000 && like < 1000000000000) {
                // 1b-999b
                n_format = Math.floor(like / 1000000000);
                $suffix = 'B+';
            } else if (like >= 1000000000000) {
                // 1t+
                n_format = Math.floor(like / 1000000000000);
                $suffix = 'T+';
            }
            return n_format + suffix + " " + type;
        }
    </script>
@endpush
