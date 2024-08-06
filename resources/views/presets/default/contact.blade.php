@php
   $contactSection =  getContent('contact_us.content',true);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Contact Start Here ==================== -->
    <section class="contact-top-area py-120">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-10">
                    <div class="row gy-4 justify-content-center">
                  
                        <div class="col-lg-4 col-md-6">
                            <div class="contact-item">
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h5 class="title-three">@lang('Our Address')</h5>
                                <div class="desc">
                                    <p>{{__(@$contactSection->data_values->contact_details)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="contact-item">
                                <div class="icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h5 class="title-three">@lang('Contact Info')</h5>
                                <div class="desc">
                                    <p>@lang('Open a chat or give us call')</p>
                                    <h3 class="title-two">{{__(@$contactSection->data_values->contact_number)}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="contact-item">
                                <div class="icon">
                                    <i class="fas fa-headphones"></i>
                                </div>
                                <h5 class="title-three">@lang('Live Support')</h5>
                                <div class="desc">
                                    <p>@lang('live chat service')</p>
                                    <h3 class="title-two website"><a href="mailto:{{__(@$contactSection->data_values->email_address)}}">{{__(@$contactSection->data_values->email_address)}}</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-form-area pb-120">
        <div class="container">
            <div class="contact-form-bg-wrap">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h3 class="title-one">@lang('Have inquiries? Reach out via message')</h3>
                                <form method="post" >
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name" class="form--label">@lang('Name')</label>
                                                <input type="text" class="form--control" id="name" name="name" placeholder="Enter Name"
                                                    value="@if(auth()->user()){{ auth()->user()->fullname }}@else{{ old('name') }}@endif"
                                                    @if(auth()->user()) readonly @endif required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email" class="form--label">@lang('Email Address')</label>
                                                <input name="email" type="email" class="form--control"  id="email"
                                                    placeholder="Email Address"
                                                    value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                                    @if (auth()->user()) readonly @endif required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="subject" class="form--label">@lang('Subject')</label>
                                            <input name="subject" id="subject" type="text" class="form--control" placeholder="Enter Subject"
                                                value="{{ old('subject') }}" required>
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form--label" for="message">@lang('Message')</label>
                                            <div class="input-group">
                                                <textarea id="message" name="message" class="form--control" placeholder="Your Message" required>{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="btn btn--base w-100">@lang('Submit')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-5">
                                <div class="contact-thumb">
                                    <img src="{{ getImage(getFilePath('contact_us') . '/'. @$contactSection->data_values->contact_image)}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Contact End Here ==================== -->
@endsection
