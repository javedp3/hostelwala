@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--=======-** Terms Of Service start **-=======-->
    <section class="term-page-detials py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-12">
                    <div class="privacy-wrapper">
                        <div class="data-cookies-item">
                            <div class="desc mb-4 wyg">
                                @php
                                    echo __($cookie->data_values->description);
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======-** Terms Of Service End **-=======-->
    <!-- Footer -->
@endsection
