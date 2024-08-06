 {{-- footer start --}}
 @php
     $footer_quick_linksContent = getContent('footer_quick_links.content', true);
     $footer_quick_linksElement = getContent('footer_quick_links.element', false, 4);
     $footer_company_linksElement = getContent('footer_company_links.element', false, 4);
     $socialSectionElements = getContent('social_icon.element', false, 4);
     $subscribeSection = getContent('subscribe.content', true);
     $footer_galleryElement = getContent('footer_gallery.element', false, 6);
     $policy_elements = getContent('policy_pages.element');
 @endphp

 <footer class="footer-area pt-120">
     <div class="container">
         <div class="row justify-content-center gy-5">
             <div class="col-lg-12">
                 <div class="footer-wrapper">
                     <div class="footer-item">
                         <div class="footer-item__logo">
                             <a href="{{ route('home') }}" class="footer-logo-dark hidden"> <img
                                     src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png') }}" alt="logo"></a>
                         </div>
                         <p class="footer-item__desc mb-3">
                             {{ __(@$footer_quick_linksContent->data_values?->description) }}</p>
                         <div class="login-social-wrap">
                             <ul class="social-list mb-3">
                                 @foreach ($socialSectionElements as $item)
                                     <li class="social-list__item">
                                         <a href="{{ $item->data_values?->url }}"
                                             class="social-list__link">@php echo $item->data_values?->social_icon @endphp </a>
                                     </li>
                                 @endforeach
                             </ul>
                         </div>
                     </div>
                     <div class="footer-item">
                         <h5 class="footer-item__title">@lang('Quick Link')</h5>
                         <ul class="footer-menu">
                             @foreach ($footer_quick_linksElement as $item)
                                 <li class="footer-menu__item"><a href="{{url('/') . $item->data_values?->url }}"
                                         class="footer-menu__link">{{ $item->data_values?->title }}</a>
                                 </li>
                             @endforeach
                         </ul>
                     </div>
                     <div class="footer-item">
                         <h5 class="footer-item__title">@lang('Company Links')</h5>
                         <ul class="footer-menu">
                             @if (@$general->agree == 1)
                                 @foreach ($policy_elements as $element)
                                     <li class="footer-menu__item">
                                        <a href="{{ route('policy.pages', [slug($element->data_values->title), $element->id]) }}"
                                             class="footer-menu__link"
                                             target="_blank">{{ $element->data_values->title }}</a>
                                     </li>
                                 @endforeach
                             @endif
                             <li class="footer-menu__item"><a href="{{ url('/cookie-policy') }}"
                                     class="footer-menu__link" target="_blank">@lang('Cookie Policy')</a></li>
                         </ul>
                     </div>
                     <div class="footer-item">
                         <h5 class="footer-item__title">@lang('Gallery')</h5>
                         <ul class="instagram-wrapper">
                             @foreach ($footer_galleryElement as $item)
                                 <li class="footer-menu__item">
                                     <a href="{{ getImage(getFilePath('footer_gallery') . '/' . $item->data_values?->footer_gallery) }}"
                                         class="image-popup">
                                         <img src="{{ getImage(getFilePath('footer_gallery') . '/' . $item->data_values?->footer_gallery) }}"
                                             alt="">
                                     </a>
                                 </li>
                             @endforeach
                         </ul>
                     </div>


                     <div class="footer-item">
                         <h5 class="footer-item__title">@lang('Subscribe')</h5>
                         <p class="footer-item__desc mb-3">{{ __(@$subscribeSection->data_values?->subheading) }}
                         </p>
                         <form action="#" autocomplete="off">
                             <div class="search-box footer-area w-100">
                                 <input type="email" class="form--control" placeholder="Email address">
                                 <button type="submit" class="footer-email-btn"><i
                                         class="fas fa-long-arrow-alt-right"></i></button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Footer Top End-->

     <div class="bottom-footer py-3">
         <div class="container">
             <div class="row justify-content-center gy-2">
                 <div class="col-lg-6 col-md-12">
                     <div class="bottom-footer-tex text-center">
                         <p>&copy; @lang('Copyright') {{ now()->year }} @lang('. All rights reserved.')</p>
                     </div>
                 </div>
             </div>
         </div>
     </div>

 </footer>
 {{-- footer end --}}
