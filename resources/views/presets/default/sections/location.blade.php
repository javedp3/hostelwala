@php
    $locationSection = getContent('location.content', true);
    $hostels = App\Models\Hostel::with('hostel_images', 'rooms')
        ->where('status', 1)
        ->orderBy('id', 'desc')
        ->get();
    $loopCount = 0;
@endphp

<section class="service-area pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-heading  text-center">
                    <span class="subtitle">{{ __(@$locationSection->data_values?->subheading) }}</span>
                    <h2 class="title-one">{{ __(@$locationSection->data_values?->heading) }}</h2>
                    <p class="des mb-3">{{ __(@$locationSection->data_values?->short_details) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            @forelse ($hostels as $index=> $item)
                @if ($item->rooms->count() > 0 && $loopCount < 6)
                    @php
                        $loopCount++;
                    @endphp
                    <div class="{{ $loopCount == 1 || $loopCount == 6 ? 'col-xl-6 col-lg-6 col-md-12' : 'col-xl-3 col-lg-3 col-md-6' }}">
                        <div class="location-item">
                            <div class="location-item__thumb">
                                <a href="{{ route('hostel_list_details', [slug($item->name), $item->id]) }}"></a>
                                <img src="{{ getImage(getFilePath('hostel') . '/' . @$item->hostel_images[0]->path . @$item->hostel_images[0]->image, getFileSize('hostel')) }}"
                                    alt="">
                                <div class="content">
                                    <span class="tag">{{ @$item->rooms?->count() }} @lang('Rooms')</span>
                                    <h3 class="title-two text-capitalize">{{ @$item->city }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
            @endforelse
        </div>
    </div>
</section>
