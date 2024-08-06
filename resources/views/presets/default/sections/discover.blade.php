@php
    $discoverSection = getContent('discover.content', true);
    $discoverSectionElement = getContent('discover.element', false, 2);
@endphp
<div class="right-hostel-section py-120">
    <div class="container">
        <div class="row flex-wrap-reverse gy-4">
            <div class="col-xl-6 col-lg-6">
                <div class="right-hostel-thumb">
                    <div class="right-hostel-thumb__inner">
                        <img class="img-2"
                            src="{{ getImage(getFilePath('discover') . '/' . $discoverSection->data_values?->discover_image) }}"
                            alt="image">
                        <div class="popup-vide-wrap">
                            <div class="video-main">
                                <div class="promo-video">
                                    <div class="waves-block">
                                        <div class="waves wave-1"></div>
                                        <div class="waves wave-2"></div>
                                        <div class="waves wave-3"></div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{(__(@$discoverSection->data_values?->url)) }}" class="video-button popup_video">
                                @php
                                    echo (__(@$discoverSection->data_values?->icon)) 
                                @endphp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="right-hostel-right-content">
                    <div class="section-heading">
                        <span class="subtitle">{{ __(@$discoverSection->data_values?->subheading) }}</span>
                        <h2 class="title-one">{{ __(@$discoverSection->data_values?->heading) }}</h2>
                        <p class="desc mb-4">{{ __(@$discoverSection->data_values?->description) }}</p>
                    </div>
                    <div class="right-hostel-bottom">
                        <div class="row gy-4 align-items-center">
                            @foreach ($discoverSectionElement as $item)
                                <div class="col-lg-6 col-md-6">
                                    <div class="right-hostel-bottom__item">
                                        <div class="content">
                                            <h4 class="title-three">{{__( $item->data_values?->title)}}</h4>
                                            <p>{{__( $item->data_values?->short_details)}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
