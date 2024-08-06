@php
    $luxurySection = getContent('luxury.content', true);
    $luxurySectionElement = getContent('luxury.element', false, 6);
@endphp

<div class="luxury-section py-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-5 col-lg-6">
                <div class="luxury-right-content">
                    <div class="section-heading mb-0">
                        <span class="subtitle">{{ __($luxurySection->data_values->subheading) }}</span>
                        <h2 class="title-one">{{ __($luxurySection->data_values->heading) }}</h2>
                         @php echo $luxurySection->data_values->description @endphp
                        <div class="luxury-bottom">
                            <div class="row gy-2">
                                @foreach ($luxurySectionElement as $item)
                                    <div class="col-sm-6">
                                        <div class="luxury-bottom-item">
                                            @php echo $item->data_values->luxury_icon @endphp
                                            <p>{{__($item->data_values->title)}}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-lg-12 mt-5">
                                    <a class="btn btn--base" href="{{route('hostel_list')}}">{{ __($luxurySection->data_values->button_name) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 offset-xl-1 col-lg-6">
                <div class="quality-hostel-thumb luxury">
                    <div class="quality-hostel-thumb__inner">
                        <img class="img-2" src="{{ getImage(getFilePath('luxury') . '/' . $luxurySection->data_values?->luxury_image) }}" alt="image">
                        <div class="content animate-y-axis">
                            <div class="icon">
                                @php echo $luxurySection->data_values->luxury_counter_icon @endphp
                            </div>
                            <div class="count">
                                <h4 class="title-one"><span class="counter odometer me-1"
                                        data-odometer-final="{{__($luxurySection->data_values->luxury_counter)}}">00</span>+</h4>
                                <h4 class="happy-cus">{{__($luxurySection->data_values->luxury_counter_text)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
