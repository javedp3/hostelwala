@php
    $communitySection = getContent('community.content', true);
    $communitySectionElement = getContent('community.element', false, 3);
@endphp
<div class="community-section py-120">
    <div class="container">
        <div class="row flex-wrap-reverse gy-4">
            <div class="col-xl-7 col-lg-6">
                <div class="community-thumb text-center">
                    <div class="community-thumb__inner">
                        <img class="img-2" src="{{ getImage(getFilePath('community') . '/' . @$communitySection->data_values->background_image) }}" alt="image">
                        <div class="community-main-img">
                            <img class="community-top" src="{{ getImage(getFilePath('community') . '/' . 'community-top.jpg') }}" alt="image">
                            <img class="community-middle" src="{{ getImage(getFilePath('community') . '/' . @$communitySection->data_values->comment_image) }}"
                                alt="image">
                            <img class="community-bottom-img" src="{{ getImage(getFilePath('community') . '/' . 'community-bottom.jpg') }}"
                                alt="image">
                        </div>
                    </div>
                </div>
            </div>
  
            <div class="col-xl-5 col-lg-6">
                <div class="community-right-content">
                    <div class="section-heading mb-0">
                        <span class="subtitle">{{ __(@$communitySection->data_values?->subheading) }}</span>
                        <h2 class="title-one">{{ __(@$communitySection->data_values?->heading) }}</h2>
                        <p class="mb-3">{{ __(@$communitySection->data_values?->description) }}</p>

                        <div class="community-bottom">
                            @foreach ($communitySectionElement as $item)
                                <div class="community-bottom__item">
                                    <h4 class="title-three">{{ __(@$item->data_values?->title)}}</h4>
                                    <p>{{ __(@$item->data_values?->short_details)}}</p>
                                </div>
                            @endforeach

                            <div class="community-bottom__item">
                                <a href="{{ route('community') }}" class="btn btn--base">{{ __(@$communitySection->data_values?->button_one) }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
