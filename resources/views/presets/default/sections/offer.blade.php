@php
   $offerSection =  getContent('offer.content',true);
   $offerSectionElement =  getContent('offer.element',false, 4);
@endphp

<section class="what-we-offer-area section-bg py-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-6 col-lg-12 ">
                <div class="what-we-offer-left">
                    <div class="section-heading">
                        <span class="subtitle">{{__(@$offerSection->data_values?->subheading)}}</span>
                        <h2 class="title-one">{{__(@$offerSection->data_values?->heading)}}</h2>
                        <p class="mb-3">{{__(@$offerSection->data_values?->short_details)}}</p>
                    </div>
                    <div class="row gy-4">
                        @foreach ($offerSectionElement as $item)
                              <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="what-offer-item">
                                <div class="what-offer-item__icon">
                                    @php echo @$item->data_values?->offer_icon @endphp
                                </div>
                                <div class="what-offer-item__content">
                                    <h4 class="title-three">{{__(@$item->data_values?->title)}}</h4>
                                    <p>{{__(@$item->data_values?->description)}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-12 ">
                <div class="what-we-offer-right">
                    <div class="thumb">
                        <img src="{{ getImage(getFilePath('offer') . '/' . @$offerSection->data_values->offer_image)}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>