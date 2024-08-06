@php
    $blogDetailsSidebarSection = getContent('blog_sidebar.content', true);
    $blogDetailsSidebarSectionElement = getContent('blog_sidebar.element', false, 3);

@endphp

<!-- ================== Blog Details Sidebar Start ============= -->
<div class="blog-sidebar-wrapper">
    <div class="blog-sidebar">
        <h5 class="blog-sidebar__title">{{ __($blogDetailsSidebarSection->data_values?->heading) }}</h5>
        <div class="why-book-box">
            <ul>
                @foreach ($blogDetailsSidebarSectionElement as $item)
                    <li>
                        <div class="icon">
                            @php echo @$item->data_values?->icon @endphp
                        </div>
                        <h5 class="title">{{__(@$item->data_values?->short_details)}}</h5>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    
</div>
<!-- ================== Blog Details Sidebar End ============= -->
