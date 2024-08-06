@php
    $qualitySection = getContent('quality.content', true);
    $qualitySectionElement = getContent('quality.element', false, 2);
@endphp

<div class="quality-hostel-section pt-120">
    <div class="container">
        <div class="row flex-wrap-reverse gy-4">

            <div class="col-xl-7 col-lg-6">
                <div class="quality-hostel-thumb text-center">
                    <div class="quality-hostel-thumb__inner">
                        <img class="img-2" src="{{ getImage(getFilePath('quality') . '/' . @$qualitySection->data_values->quality_image)}}" alt="image">
                        <div class="content animate-y-axis">
                            <div class="icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="count">
                                <h4 class="title-one"><span class="counter odometer me-1"
                                        data-odometer-final="{{ @$qualitySection->data_values?->customer_counter }}">00</span>+
                                </h4>
                                <h4 class="happy-cus">{{ __(@$qualitySection->data_values?->counter_text) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-lg-6">
                <div class="quality-hostel-right-content">
                    <div class="section-heading mb-0">
                        <span class="subtitle">{{ __(@$qualitySection->data_values?->subheading) }}</span>
                        <h2 class="title-one">{{ __(@$qualitySection->data_values?->heading) }}</h2>
                        <p class="mb-4">{{ __(@$qualitySection->data_values?->description) }}</p>

                        <div class="quality-hostel-middle">
                            <div class="row gy-4">
                                @foreach ($qualitySectionElement as $item)
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ssm-6">
                                        <div class="quality-hostel-middle__item">
                                            <div class="icon">
                                                @php echo  @$item->data_values?->quality_icon  @endphp
                                            </div>
                                            <h4 class="title-three">{{ @$item->data_values?->title }}</h4>
                                            <p>{{ @$item->data_values?->short_details }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="quality-hostel-bottom">
                            <div class="row gy-4 align-items-center">
                                <div class="col-lg-6">
                                    <div class="quality-hostel-bottom__item">
                                        <div class="thumb">
                                            <img src="{{ getImage(getFilePath('quality') . '/' . @$qualitySection->data_values->quality_footer_thumb)}}" alt="">
                                        </div>
                                        <div class="content">
                                            <h4 class="title-three">{{ __(@$qualitySection->data_values?->footer_thumb_name) }}</h4>
                                            <p>{{ __(@$qualitySection->data_values?->footer_thumb_position) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="quality-hostel-bottom-item text-end">
                                        <img src="{{ getImage(getFilePath('quality') . '/' . @$qualitySection->data_values?->quality_footer)}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
