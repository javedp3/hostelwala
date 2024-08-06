@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap mt-0" id="dropzone">
                @if ($user->kyc_data)
                    <ul class="list-group">
                        @foreach ($user->kyc_data as $val)
                            @continue(!$val->value)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __($val->name) }}
                                <div>
                                    @if ($val->type == 'checkbox')
                                        {{ implode(',', $val->value) }}
                                    @elseif($val->type == 'file')
                                        <a href="{{ route('user.attachment.download', encrypt(getFilePath('verify') . '/' . $val->value)) }}"
                                            class="me-3"><i class="fa fa-file"></i> @lang('Attachment') </a>
                                    @else
                                        <p>{{ __($val->value) }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <h5 class="text-center">@lang('KYC data not found')</h5>
                @endif
            </div>
        </div>
    </div>
@endsection
