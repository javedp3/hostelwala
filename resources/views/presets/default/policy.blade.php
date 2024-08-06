@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--=======-** Terms Of Service start **-=======-->
    <section class="blog-detials py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-12">
                    <div class="privacy-wrapper">
                        <div class="desc mb-5 wyg">
                            @php
                                echo __($policy->data_values?->details);
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======-** Terms Of Service End **-=======-->
    <!-- Footer -->
@endsection
