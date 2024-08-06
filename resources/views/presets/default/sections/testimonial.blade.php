@php
    $testimonialSection = getContent('testimonial.content', true);
    $testimonialSectionElement = getContent('testimonial.element', false, 4);
@endphp

<section class="testimonials py-120">
    <img src="{{ getImage(getFilePath('testimonial') . '/' . 'testimonials-bg.png') }}" alt=""
        class="testimonials-bg">
    <img src="{{ getImage(getFilePath('testimonial') . '/' . @$testimonialSection->data_values->testimonial_left_image) }}"
        alt="" class="testimonials-left">
    <img src="{{ getImage(getFilePath('testimonial') . '/' . @$testimonialSection->data_values->testimonial_right_image) }}"
        alt="" class="testimonials-right">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8">
                <div class="testimonial-slider">
                    @foreach ($testimonialSectionElement as $item)
                        <div class="testimonails-card">
                            <div class="testimonial-item">
                                <div class="testimonial-item__content text-center">
                                    <div class="testimonial-item__info">
                                        <img src="{{ getImage(getFilePath('testimonial') . '/' . $item->data_values?->testimonial_thumb_image) }}" alt="">

                                        <div class="testimonial-item__details">
                                            <h5 class="testimonial-item__name">{{__($item->data_values->testimonial_thumb_name)}}</h5>
                                            <span class="testimonial-item__designation">{{__($item->data_values->testimonial_thumb_position)}}</span>
                                        </div>
                                    </div>
                                    <p class="testimonial-item__desc">{{__($item->data_values->description)}} </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
