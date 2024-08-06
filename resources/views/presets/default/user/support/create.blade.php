@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap mt-0">
                <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="full_name" class="form--label">@lang('Full Name')</label>
                                <div class="input--group">
                                    <input type="text" name="name" value="{{ @$user->firstname . ' ' . @$user->lastname }}"
                                     class="form--control" id="full_name" placeholder="Full Name" required readonly>
                                    <div class="input--icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email_adress" class="form--label">@lang('Email Address')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="email_adress"
                                        placeholder="Email Address" name="email" value="{{ @$user->email }}" required readonly>
                                    <div class="input--icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="subject" class="form--label">@lang('Subject')</label>
                                <div class="input--group">
                                    <input type="text" class="form--control" id="subject" placeholder="Subject"  name="subject" value="{{ old('subject') }}" required>
                                    <div class="input--icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="poriority" class="form--label">@lang('Priority')</label>
                                <div class="col-sm-12">
                                    <select id="poriority" name="priority" class="form--control form-select"  required>
                                        <option value="">@lang('Select')</option>
                                        <option value="1">@lang('Low')</option>
                                        <option value="2">@lang('Medium')</option>
                                        <option value="3">@lang('High')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputMessage" class="form--label">@lang('Message')</label>
                                <div class="input--group textarea">
                                    <textarea name="message" id="inputMessage" class="form--control" placeholder="message" required>{{ old('message') }} </textarea>
                                    <div class="input--icon">
                                        <i class="fas fa-envelope-open"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 text-end">
                            <button type="button" class="btn btn--base btn--sm ms-2 addFile">
                                <i class="fas fa-plus"></i>@lang('Add New')
                            </button>
                        </div>
                        <div class="col-lg-12">
                            <div class="attachment_wrapper mb-4">
                                <div class="form-group profile mb-15">
                                    <label for="inputAttachments">@lang('Attachments:-') </label>
                                    <p class="ticket-attachments-message text-muted my-3"> @lang('Allowed File Extensions'): <span class="text-danger">.@lang('jpg'), .@lang('jpeg'),
                                        .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</span> </p>
                                    <div class="single-input form-group mt-3 mb-1">
                                        <input class="form--control" type="file" name="attachments[]" id="inputAttachments">
                                    </div>
                                    <div id="fileUploadsContainer"></div>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <button class="btn btn--base w-100" type="submit" id="recaptcha">&nbsp;@lang('Send')</button>
                            </div>
                        </div>

                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn--base btn--sm ms-2">
                                @lang('Submit')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
