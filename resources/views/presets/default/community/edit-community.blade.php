@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Community Start Here ==================== -->

    <section class="community-area py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-12 text-center">
                    <h4 class="modal-title">@lang('Edit Community Post')</h4>
                </div>
                <div class="community-edit-wrapper">
                    <form method="POST" action="{{ route('user.community.update', $community->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label class="form--label" for="create-recipient-title">@lang('Title')</label>
                                <input type="text" class="form-control form--control" id="create-recipient-title"
                                    name="title" value="{{ $community->title }}" placeholder="">
                            </div>
                        </div>

                        <p class="mb-2">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png')
                            @lang('(max:') <strong> @lang('2MB)')</strong>
                        </p>

                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label class="form--label">@lang('Image')</label>
                                <input class="form--control" type="file" name="image" accept=".png, .jpg, .jpeg">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div id="image_preview">
                                    <div class='img-div' id='img-div{{ $community->id }}'>
                                        <img src="{{ getImage(getFilePath('community_post') . '/' . $community->image) }}"
                                            class='img-responsive image img-thumbnail' title='{{ $community->image }}'>
                                        <div class='middle'><button id='action-icon' value='img-div{{ $community->id }}'
                                                class='delete-btn btn-danger' role='{{ $community->image }}'><i
                                                    class='fa fa-trash'></i></button></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label class="form--label">@lang('Description')</label>
                                <textarea class="form--control trumEdit1" placeholder="" name="description">@php echo (__($community->title)) @endphp</textarea>
                            </div>
                        </div>

                        <div class="form-group text-end">
                            <button type="submit" class="btn btn--sm text-end">@lang('Save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ==================== Community End Here ==================== -->
@endsection

@push('script-lib')
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
@endpush



@push('script')
    <script>
        $(document).ready(function() {
            var fileArr = [];
            $("#image").on('change', function() {
                // check if fileArr length is greater than 0
                if (fileArr.length > 0) fileArr = [];

                $('#image_preview').html("");
                var total_file = document.getElementById("image").files;
                if (!total_file.length) return;
                for (var i = 0; i < total_file.length; i++) {
                    if (total_file[i].size > 1048576) {
                        return false;
                    } else {
                        fileArr.push(total_file[i]);
                        $('#image_preview').append("<div class='img-div' id='img-div" + i + "'><img src='" +
                            URL.createObjectURL(event.target.files[i]) +
                            "' class='img-responsive image img-thumbnail' title='" + total_file[i]
                            .name + "'><div class='middle'><button id='action-icon' value='img-div" +
                            i + "' class='delete-btn btn-danger' role='" + total_file[i].name +
                            "'><i class='fa fa-trash'></i></button></div></div>");
                    }
                }
            });

            $('body').on('click', '#action-icon', function(evt) {
                var divName = this.value;
                var fileName = $(this).attr('role');
                $(`#${divName}`).remove();

                for (var i = 0; i < fileArr.length; i++) {
                    if (fileArr[i].name === fileName) {
                        fileArr.splice(i, 1);
                    }
                }
                document.getElementById('images').files = FileListItem(fileArr);
                evt.preventDefault();
            });

            function FileListItem(file) {
                file = [].slice.call(Array.isArray(file) ? file : arguments)
                for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
                if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
                for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
                return b.files
            }
        });
    </script>

    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                "use strict";
                if ($(".trumEdit1")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit1'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }

            });

        })(jQuery);
    </script>
@endpush
