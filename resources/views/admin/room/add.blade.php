@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="dashboard-card-wrap mt-0" id="dropzone">
                    <form action="{{ route('admin.room.store',$hostel->id) }}" method="POST" enctype ='multipart/form-data'>
                        @csrf
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="room_number" class="form-label">
                                            @lang('Room Title')</label>
                                        <div class="input-group">
                                            <input type="text" id="room_number" name="title" class="form-control"
                                                placeholder="Room Title" value="{{old('title')}}" />
                                            <div class="input-group-text input-icon">
                                                <i class="fas fa-door-open"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="room_number" class="form-label">
                                            @lang('Room Code')</label>
                                        <div class="input-group">
                                            <input type="text" id="room_number" class="form-control"
                                                placeholder="Room Number" name="number" value="{{old('number')}}" />
                                            <div class="input-group-text input-icon">
                                                <i class="fas fa-procedures"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="room_type" class="form-label">@lang('Room Type')</label>
                                        <div class="col-sm-12">
                                            <select id="room_type" class="form--control form-select" name="type">
                                                <option>@lang('Choose One')</option>
                                                <option value="room">@lang('Room')</option>
                                                <option value="bed">@lang('Dorm')(@lang('For Individual Bed Booking'))</option>
                                            </select>
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="bed_capacity" class="form-label">@lang('Number Count')</label>
                                        <div class="col-sm-12">
                                            <input type="number" id="room_number" name="rooms_or_beds" class="form-control"
                                                placeholder="Number Count" value="{{old('rooms_or_beds')}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ac_non_ac" class="form-label">@lang('AC/NON AC')</label>
                                        <div class="col-sm-12">
                                            <select id="ac_non_ac" class="form--control form-select" name="ac_type">
                                                <option >@lang('Choose One')</option>
                                                <option value="ac">@lang('AC')</option>
                                                <option value="non_ac">@lang('Non AC')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="rent_per_night" class="form-label">@lang('Rent Per Night')</label>
                                        <div class="input-group">
                                            <input type="number" id="rent_per_night" class="form-control"
                                                placeholder="Rent Per Night" name="rent_per_day" value="{{old('rent_per_day')}}" />
                                            <div class="input-group-text input-icon">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="discount" class="form--label">@lang('Discount')</label>
                                        <div class="input-group">
                                            <input type="number" id="discount" class="form-control" placeholder="Discount"
                                                name="discount" value="{{old('discount')}}" />
                                            <div class="input-group-text input-icon">
                                                <i class="fas fa-file-invoice-dollar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="image">@lang('Image')</label>
                                        <input type="file" name="image" id="images" accept=".png, .jpg, .jpeg"
                                            class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <div id="image_preview" >
    
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-end">
                                    <div class="card-footer text-end">
                                        <a href="{{route('admin.room.list',$hostel->id)}}" class="btn btn--primary btn-global align-items-center">@lang('Back')</a>
                                        <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .ck.ck-editor__main>.ck-editor__editable {
            height: 250px;
        }

        .image_preview-wrapper {
            display: flex;
            flex-wrap: wrap;
        }

        .img-div {
            position: relative;
            width: 150px;
            margin-right: 5px;
            margin-left: 5px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .image {
            opacity: 1;
            display: block;
            width: 100%;
            max-width: auto;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .img-div:hover .image {
            opacity: 0.3;
        }

        .img-div:hover .middle {
            opacity: 1;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            var fileArr = [];
            $("#images").on('change',function() {
                // check if fileArr length is greater than 0
                if (fileArr.length > 0) fileArr = [];

                $('#image_preview').html("");
                var total_file = document.getElementById("images").files;
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
                            i + "' class='btn btn-danger' role='" + total_file[i].name +
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

@endpush
