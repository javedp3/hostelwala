@php
    $blogSection = getContent('blog.content', true);
    $blogPostSection = getContent('blog_post.element', false, 2);
@endphp

<section class="blog pb-120">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="section-heading mb-0">
                    <span class="subtitle">{{ __(@$blogSection->data_values?->subheading) }}</span>
                    <h2 class="title-one">{{ __(@$blogSection->data_values?->heading) }}</h2>
                    <p class="mb-4">{{ __(@$blogSection->data_values?->short_details) }}</p>
                    <div class="col-lg-12">
                        <a class="btn btn--base" href="#">{{ __(@$blogSection->data_values?->button_name) }}</a>
                    </div>
                </div>
            </div>
            @foreach (@$blogPostSection as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-item__thumb">
                        <a href="{{route('blog_details',$item->id)}}" class="blog-item__thumb-link">
                                <img src="{{ getImage(getFilePath('blog_post') . '/' . @$item->data_values->blog_image) }}" alt="">
                            </a>
                            <div class="date-wrap">{{showDateTime($item->created_at,"d")}}<span class="month">{{showDateTime($item->created_at,"M")}}</span></div>
                        </div>
                        <div class="blog-item__content">
                            <h4 class="blog-item__title"><a href="{{ route('blog_post') }}" class="blog-item__title-link">{{$item->data_values->title}}</a></h4>
                            <p>@php echo strLimit($item->data_values->description,80)@endphp</p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
