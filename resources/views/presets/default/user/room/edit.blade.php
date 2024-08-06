@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card-wrap mt-0">
                <form action="{{ route('user.room.update', [slug($hostel_id), $room->id]) }}" method="POST"
                    enctype ='multipart/form-data'>
                    @csrf
                    @method('put')
                    <div class="row gy-4">
                        <input type="text" id="room_number" name="hostel_id" value="{{ $hostel_id }}"
                            class="form--control d-none" placeholder="Room Title" />
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title" class="form--label">
                                    @lang('Room Title')</label>
                                <div class="input--group">
                                    <input type="text" id="title" name="title" class="form--control"
                                        placeholder="Room Title" value="{{ $room->title }}" />
                                    <div class="input--icon">
                                        <i class="fas fa-door-open"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="room_number" class="form--label">
                                    @lang('Room Code')</label>
                                <div class="input--group">
                                    <input type="text" id="room_number" class="form--control" placeholder="Room Number"
                                        name="number" value="{{ $room->number }}" />
                                    <div class="input--icon">
                                        <i class="fas fa-procedures"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="room_type" class="form--label">@lang('Select Type')</label>
                                <div class="col-sm-12">
                                    <select id="room_type" class="form--control form-select" name="type">
                                        <option>@lang('Choose One')</option>
                                        <option value="room"{{ $room->type === 'room' ? 'selected' : '' }}>
                                            @lang('Room')
                                        </option>
                                        <option value="bed"{{ $room->type === 'bed' ? 'selected' : '' }}>
                                            @lang('Dorm')
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="bed_capacity" class="form--label">@lang('Number Count')</label>
                                <div class="col-sm-12">
                                    <input type="number" id="room_number" name="rooms_or_beds" class="form--control"
                                        placeholder="Number Count" value="{{ $room->rooms_or_beds }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ac_non_ac" class="form--label">@lang('AC/NON AC')</label>
                                <div class="col-sm-12">
                                    <select id="ac_non_ac" class="form--control form-select" name="ac_type">
                                        <option>@lang('Choose One')</option>
                                        <option value="ac" {{ $room->ac_type === 'ac' ? 'selected' : '' }}>
                                            @lang('AC')
                                        </option>
                                        <option value="non_ac" {{ $room->ac_type === 'non_ac' ? 'selected' : '' }}>
                                            @lang('Non AC')</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="rent_per_night" class="form--label">@lang('Rent Per Night')</label>
                                <div class="input--group">
                                    <input type="number" id="rent_per_night" class="form--control"
                                        placeholder="Rent Per Night" name="rent_per_day"
                                        value="{{ $room->rent_per_day }}" />
                                    <div class="input--icon">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="discount" class="form--label">@lang('Discount')</label>
                                <div class="input--group">
                                    <input type="number" id="discount" class="form--control" placeholder="Discount"
                                        name="discount" value="{{ $room->discount }}" />
                                    <div class="input--icon">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="image">@lang('Images')</label>
                                <input type="file" name="image" id="images" accept=".png, .jpg, .jpeg"
                                    class="form--control">
                            </div>
                            <div class="form-group">
                                <div id="image_preview">
                                    <div class='img-div' id='img-div{{ $room->id }}'>
                                        <input type="hidden" name="old_room_image" value="{{ $room->image }}">
                                        <img src="{{ getImage(getFilePath('room') . '/' . $room->image) }}"
                                            class='img-responsive image img-thumbnail' title='{{ $room->image }}'>
                                        <div class='middle'><button id='action-icon' value='img-div{{ $room->id }}'
                                                class='btn btn-danger' role='{{ $room->image }}'><i
                                                    class='fa fa-trash'></i></button></div>
                                    </div>
                                </div>
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
