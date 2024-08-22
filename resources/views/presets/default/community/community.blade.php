@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Community Start Here ==================== -->
    <section class="community-area py-120">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="add-community text-end mb-5">
                        <div class="add-community-top-post-wrapper">
                            <div class="user-thumb">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                                    alt="avatar">
                            </div>
                            <div class="input-form-wrapper">
                                <input type="text" class="form--control "
                                    placeholder="Community Discussion" onclick="addNewCommunity()" readonly>
                            </div>

                        </div>
                    </div>

                    @forelse ($communities as $community)
                        <div class="community-item">
                            <div class="community-item__top">
                                <div class="top-wrapper">
                                    <div class="left">
                                        <div class="thumb">
                                            <a href="javascript: void(0)"><img
                                                    src="{{ getImage(getFilePath('userProfile') . '.' . @$community->user?->image, getFileSize('userProfile')) }}"
                                                    alt="community-image"></a>
                                        </div>
                                        <div class="content">
                                            <a href="javascript: void(0)">
                                                <h4 class="title-three">{{ __(@$community->user?->fullname) }}</h4>
                                            </a>
                                            <p>{{ __(showDateTime(@$community->created_at, 'd M Y')) }}</p>

                                        </div>
                                    </div>
                                    @if (auth()->id() == @$community->user?->id)
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
                                    @endif
                                </div>
                                <div class="content">
                                    <div class="title-wrapper">
                                        <h6>{{ __(ucfirst($community->title)) }}</h6>
                                    </div>
                                    <p> @php echo (__(substr(strip_tags(@$community->description), 0, 200))) @endphp
                                        @if (strlen(strip_tags(@$community->description)) > 190)
                                            ... <a href="{{ route('community.details', $community->id) }}"
                                                class="btn-sm p-1 seemore">
                                                @lang('See More')
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="community-bottom mt-1">
                                @php
                                    $existLike = @$community->community_likes?->where('user_id', auth()->id())->first();
                                @endphp
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
                                        <a href="{{ route('community.details', $community->id) }}"><i
                                                class="fas fa-comment-alt"></i>
                                            <span>{{ number_format_short(@$community->commentCount()) }}
                                                @lang('Comments')</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('community.details', $community->id) }}"><i
                                                class="fas fa-eye"></i>
                                            <span>{{ number_format_short(@$community->view) }}
                                                @lang('Views')</span></a>
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
                    @empty

                        <div class="community-item text-center">
                            <div class="top-wrapper ">
                                <h5 class="mb-0">@lang('No Community Found')</h5>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="col-lg-4">
                    <!-- ============================= Blog Details Sidebar Start ======================== -->
                    <div class="blog-sidebar-wrapperrr">
                        <div class="blog-sidebar">
                            <div class="search-box w-100">
                                <input type="text" name="search" value="{{ request()->search }}" class="form--control"
                                    placeholder="Search..." onkeyup="communitySearch(this)">
                                <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                            </div>
                            <ul class="search-result-box d-none">

                            </ul>
                        </div>
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Recent Communities')</h5>
                            @forelse ($communities as $item)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('community.details', $item->id) }}"> <img
                                                src="{{ getImage(getFilePath('community_post') . '/' . @$item->image) }}"
                                                alt="blog-image"></a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title"><a
                                                href="{{ route('community.details', $item->id) }}">{{ __(ucfirst($item->title)) }}</a>
                                        </h6>
                                        <span
                                            class="latest-blog__date">{{ __(showDateTime($item->created_at, 'M,d,Y')) }}</span>
                                    </div>
                                </div>
                            @empty
                                <h5>@lang('No Community Found')</h5>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Community End Here ==================== -->

    {{-- Community post create --}}
    <div class="modal fade" id="communityExampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Community')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.community.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label class="form--label" for="create-recipient-title">@lang('Title')</label>
                            <input type="text" class="form-control form--control" id="create-recipient-title"
                                name="title" placeholder="">
                        </div>

                        <p class="mb-2">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png')
                            @lang('(max:') <strong> @lang('2MB)')</strong>
                        </p>

                        <div class="form-group mb-4 col-12">
                            <label class="form--label">@lang('Image')</label>
                            <input class="form--control" type="file" name="image" id="image"
                                accept=".png, .jpg, .jpeg">
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-12">
                                <div id="image_preview">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <div class="form-group mb-4">
                                <textarea class="form--control trumEdit1" placeholder="" name="description"></textarea>
                            </div>
                        </div>

                        <div class="form-group text-end">
                            <button type="submit" class="btn btn--sm text-end">@lang('Create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
@endpush

@push('script')
    <script>
        function communitySearch(object) {
            var appendClass = $('.search-result-box');
            var url = "{{ route('community.search') }}";
            var token = '{{ csrf_token() }}';
            var data = {
                search: $(object).val(),
                _token: token
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                    if (data.communities != '' && $(object).val() != '') {
                        var html = '';
                        $.each(data.communities, function(key, item) {
                            html +=
                                `<li class="d-flex p-2 w-100 justify-content-between">
                                    <a href="{{ url('community-details/${item.id}') }}">
                                    ${item.title}
                                    </a>
                                </li>
                                `;

                        })
                        appendClass.removeClass('d-none').html(html);
                    } else {
                        var html =
                            `<li class="no-data text-center">
                                No data found
                            </li>
                            `;
                        appendClass.removeClass('d-none').html(html);
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
        }


        // add new community
        function addNewCommunity() {
            var auth = @json(auth()->check());
            if (auth) {
                $('#communityExampleModal').modal('show');
            } else {
                window.location.href = "{{ route('user.login') }}";
            }
        }


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

        // comment Likes
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

    <script>
        $(document).ready(function() {
            var fileArr = [];
            $("#image").on('change', function() {

                // check if fileArr length is greater than 0
                if (fileArr.length > 0) fileArr = [];


                $('#image_preview').html("");
                var total_file = document.getElementById("image").files;
                if (!total_file.length) return;
                for (var i = 0; i < total_file.length; i++) {
                    if (total_file[i].size > 1048576) {
                        return false;
                    } else {
                        fileArr.push(total_file[i]);
                        $('#image_preview').append("<div class='img-div' id='img-div" + i + "'><img src='" +
                            URL.createObjectURL(event.target.files[i]) +
                            "' class='img-responsive image img-thumbnail' title='" + total_file[i]
                            .name + "'><div class='middle'><button id='action-icon' value='img-div" +
                            i + "' class='delete-btn btn-danger' role='" + total_file[i].name +
                            "'><i class='fa fa-trash'></i></button></div></div>");
                    }
                }
            });

            $('body').on('click', '#action-icon', function(evt) {
                var divName = this.value;
                var fileName = $(this).attr('role');
                $(`#${divName}`).remove();

                for (var i = 0; i < fileArr.length; i++) {
                    if (fileArr[i].name === fileName) {
                        fileArr.splice(i, 1);
                    }
                }
                document.getElementById('images').files = FileListItem(fileArr);
                evt.preventDefault();
            });

            function FileListItem(file) {
                file = [].slice.call(Array.isArray(file) ? file : arguments)
                for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
                if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
                for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
                return b.files
            }
        });
    </script>

    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                "use strict";
                if ($(".trumEdit1")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit1'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }
                if ($(".trumEdit2")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit2'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }


            });

        })(jQuery);
    </script>
@endpush
