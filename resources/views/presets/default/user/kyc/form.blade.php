@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap mt-0" id="dropzone">
                <form action="{{route('user.kyc.submit')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <x-custom-form identifier="act" identifierValue="kyc"></x-custom-form>
                    <div class="form-group">
                        <button type="submit" class="btn btn--base w-100">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
