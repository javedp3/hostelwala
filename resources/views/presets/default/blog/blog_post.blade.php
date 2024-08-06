@php
    $blogPostContent = getContent('blog_post.content', true);

@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Blog Start Here ==================== -->
    <section class="blog py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="section-heading  text-center">
                            <span class="subtitle">{{__(@$blogPostContent->data_values?->heading)}}</span>
                            <h2 class="title-one">{{__($blogPostContent->data_values?->subheading)}}</h2>
                            <p class="des mb-3">{{__($blogPostContent->data_values?->short_details)}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                @foreach ($blogs as $blogItem)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item">
                            <div class="blog-item__thumb">
                                <a href="{{ route('blog_details', $blogItem->id) }}" class="blog-item__thumb-link">
                                    <img src="{{ getImage(getFilePath('blog_post') . '/' . @$blogItem->data_values?->blog_image) }}"
                                        alt="blog-image">
                                </a>
                                <div class="date-wrap">{{__(showDateTime($blogItem->created_at, 'd')) }}<span
                                        class="month">{{ __(showDateTime($blogItem->created_at, 'M')) }}</span></div>
                            </div>
                            <div class="blog-item__content">
                                <h4 class="blog-item__title"><a href="{{ route('blog_details', $blogItem->id) }}"
                                        class="blog-item__title-link">{{__($blogItem->data_values->title) }}</a></h4>
                                <p>@php echo (__(strLimit($blogItem->data_values->description,100)))@endphp</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $blogs->links() }}
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection

<!-- ==================== Blog End Here ==================== -->
