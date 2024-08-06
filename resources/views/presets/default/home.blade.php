@extends($activeTemplate . 'layouts.frontend')

@section('content')
@php 
   $referByHomePage = session()->get('reference');
@endphp
    @include($activeTemplate . 'sections.banner')
    @if (@$referByHomePage ? @$referByHomePage == 1 : $general->site_banner === 1)
        @include($activeTemplate . 'sections.search')
    @endif
    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection


