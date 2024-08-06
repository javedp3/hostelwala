@php
    $faqSection = getContent('faq.content', true);
    $faqSectionElement = getContent('faq.element', false, 4);
@endphp

<section class="accordion-area py-120">
    <div class="container">
        <div class="row flex-wrap-reverse gy-4 align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-6 ">
                <div class="accordion-thumb text-center">
                    <div class="accordion-thumb__inner">
                        <img src="{{ getImage(getFilePath('faq') . '/' . $faqSection->data_values?->faq_image) }}"
                            alt="image">
                        <img class="faq-small animate-y-axis"
                            src="{{ getImage(getFilePath('faq') . '/' . 'faq-small.png') }}" alt="image">
                        <div class="content animate-y-axis">
                            <div class="icon">
                                @php echo $faqSection->data_values?->faq_counter_icon @endphp
                            </div>
                            <div class="count">
                                <h4 class="title-two"><span class="counter odometer me-1"
                                        data-odometer-final="{{ __(@$faqSection->data_values?->faq_counter_title) }}">00</span>
                                </h4>
                                <h4 class="happy-cus">{{ __(@$faqSection->data_values?->faq_counter_text) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 offset-xl-1 col-lg-6 ">
                <div class="accordion custom--accordion" id="accordionExample">
                    <div class="luxury-right-content mb-5">
                        <div class="section-heading mb-0">
                            <span class="subtitle">{{ __(@$faqSection->data_values?->subheading) }}</span>
                            <h2 class="title-one">{{ __(@$faqSection->data_values?->heading) }}</h2>
                            <p class="mb-4">{{ __(@$faqSection->data_values?->description) }}</p>
                        </div>
                    </div>
                    <div class="accordion-wrapper">
                        @foreach ($faqSectionElement as $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{$loop->iteration}}">
                                    <button class="accordion-button {{$loop->iteration != 2 ? 'collapsed' :''}}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{$loop->iteration}}" aria-expanded="{{$loop->iteration == 2 ? 'true' :'false'}}" aria-controls="collapse{{$loop->iteration}}">
                                        {{__(@$item->data_values?->question)}}
                                    </button>
                                </h2>
                                <div id="collapse{{$loop->iteration}}" class="accordion-collapse collapse {{$loop->iteration == 2 ? 'show' :''}}" aria-labelledby="heading{{$loop->iteration}}"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @php echo (@$item->data_values?->answer) @endphp
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
