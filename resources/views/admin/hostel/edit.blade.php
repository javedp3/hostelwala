@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="dashboard-card-wrap mt-0" id="dropzone">
                    <form action="{{ route('admin.hostel.update', $hostel->id) }}" method="POST"
                        enctype ='multipart/form-data'>
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="required">@lang('Hostel Name')</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Hostel Title" value="{{ $hostel->name }}" />
                                            <div class=" input-group-text input-icon">
                                                <i class="fas fa-hotel"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hostel_rules" class="form--label">
                                            @lang('Hostel rules')</label>
                                        <div class="input--group">
                                            <textarea type="text" id="hostel_rules" name="hostel_rules" class="form-control trumEdit1"
                                                placeholder="Hostel Rules">@php echo $hostel->hostel_rules @endphp</textarea>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="decsription" class="form--label">
                                            @lang('Decsription')</label>
                                        <div class="input--group">
                                            <textarea type="text" id="description" name="description" class="form-control trumEdit2" placeholder="Description">@php echo $hostel->description @endphp</textarea>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-success btn--sm addFile">
                                                <i class="fa fa-plus"></i> @lang('Add New')
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="file-upload">
                                                    <label class="form-label">@lang('Facilities')</label>
                                                    <input type="text" name="facilities[]" id="inputFacilities"
                                                        class="form-control form--control mb-2" required
                                                        placeholder="Hostel Facilaties"
                                                        value="{{ $hostel->facilities[0] }}" />
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="file-upload">
                                                    <label class="form-label">@lang('Icons')</label>
                                                    <div class="file-upload input-group">
                                                        <input type="text" name="icons[]" id="inputIcon"
                                                            class="form-control form--control iconPicker icon"
                                                            placeholder="Hostel Icons" required
                                                            value="{{ $hostel->icons[0] }}" />
                                                        <span class="input-group-text  input-group-addon"
                                                            data-icon="las la-home" role="iconpicker"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="fileUploadsContainer">
                                            @php
                                                $facilities = $hostel->facilities;
                                                unset($facilities[0]);
                                                $icons = $hostel->icons;
                                                unset($icons[0]);
                                            @endphp

                                            @foreach ($facilities as $index => $facilitie)
                                                <div class="row elements">
                                                    <div class="col-sm-6 my-3">
                                                        <div class="file-upload ">
                                                            <input type="text" name="facilities[]" id="inputFacilities"
                                                                class="form-control form--control mb-2"
                                                                placeholder="Hostel Facilaties" value="{{ $facilitie }}"
                                                                required />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 mt-3">
                                                        <div class="file-upload input-group">
                                                            <input type="text" name="icons[]" id="inputIcon"
                                                                class="form-control form--control
                                                            iconPicker icon"
                                                                required placeholder="Hostel Icons"
                                                                value="{{ $icons[$index] }}" />
                                                            <span class="input-group-text  input-group-addon"
                                                                data-icon="las la-home" role="iconpicker"></span>
                                                            <button class="input-group-text btn-danger remove-btn"><i
                                                                    class="las la-times"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group mb-15">
                                        <label for="location" class="required font-weight-bold">@lang('location')
                                            @lang('(city, state, county)')</label>
                                        <div class="position-relative location--search-wrap custom-location-admin">
                                            <input type="text" class="form-control" value="{{ $hostel->address }}"
                                                name="location" id="location" onkeyup="startSearchTimeout()"
                                                autocomplete="off" placeholder="@lang('Location')" required>
                                            <ul id="addresses"></ul>
                                        </div>
                                    </div>
                                </div>


                                <input type="hidden" name="city_input" id="city-input" value="{{ $hostel->city }}">
                                <input type="hidden" name="state_input" id="state-input" value="{{ $hostel->state }}">
                                <input type="hidden" name="country_input" id="country-input"
                                    value="{{ $hostel->country }}">
                                <input type="hidden" name="lat_input" id="lat-input" value="{{ $hostel->latitude }}">
                                <input type="hidden" name="lon_input" id="lon-input" value="{{ $hostel->longitude }}">


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="images">@lang('Images')</label>
                                        <input type="file" name="images[]" id="images" accept=".png, .jpg, .jpeg"
                                            multiple class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <div id="image_preview" class="image_preview-wrapper">
                                            @foreach ($hostel->hostel_images as $i => $img)
                                                <div class='img-div' id='img-div{{ $i }}'
                                                    @if ($i != 0) onclick=imageDelete(this,{{ $img->id }}); @endif>
                                                    <input type="hidden" name="old_hostel_images[]"
                                                        value="{{ $img->id }}">
                                                    <img src="{{ getImage(getFilePath('hostel') . '/' . $img->path . $img->image) }}"
                                                        class='img-responsive image img-thumbnail'
                                                        title='{{ $img->image }}' alt="hostel-image">
                                                    @if ($i != 0)
                                                        <div class='middle'><button id='action-icon'
                                                                value='img-div{{ $i }}'
                                                                class='delete-btn btn-danger' role='{{ $img->image }}'>
                                                                <i class='fa fa-trash'></i>

                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-end">
                                    <div class="card-footer text-end">
                                        <button type="submit"
                                            class="btn btn--primary btn-global">@lang('Save')</button>
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

@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/mapbox-gl.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/mapbox-gl.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.form.min.js') }}"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            var fileArr = [];
            $("#images").on('change',function() {
                // check if fileArr length is greater than 0
                if (fileArr.length > 0) fileArr = [];

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
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 20) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                <div class="row elements">
                    <div class="col-sm-6 my-3">
                        <div class="file-upload">
                            <input type="text" name="facilities[]" id="inputFacilities" class="form-control form--control mb-2"
                                 placeholder="Hostel Facilaties" required />                                            
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3">
                        <div class="file-upload input-group">
                            <input type="text" name="icons[]" id="inputIcon" class="form-control form--control 
                                iconPicker icon" required placeholder="Hostel Icons"/> 
                                <span class="input-group-text  input-group-addon" data-icon="las la-home"
                                role="iconpicker"></span>
                                <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>                                         
                        </div>
                    </div>
                </div>
            `)

                $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                    $(this).closest('.file-upload').find('.iconpicker-input').val(
                        `<i class="${e.iconpickerValue}"></i>`);
                });

            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>

    <script>
        $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
            $(this).closest('.file-upload').find('.iconpicker-input').val(
                `<i class="${e.iconpickerValue}"></i>`);
        });
    </script>

    <script>
        function imageDelete(object, $id) {
            var url = "{{ route('admin.hostel.image.delete') }}";
            var token = '{{ csrf_token() }}';
            var id = $id;
            var data = {
                id: id,
                _token: token
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {

                },
                error: function(data, status, error) {
                    $.each(data.responseJSON.errors, function(key, item) {
                        Toast.fire({
                            icon: 'error',
                            title: item
                        })
                    });
                }
            });
        }
    </script>


    <script>
        mapboxgl.accessToken = '{{ gs()->map_api_key }}';
        let searchTimeout;

        function startSearchTimeout() {
            if ($('#location').val().length > 2) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(searchLocation, 1500);
            } else {
                $('#addresses').empty();
            }
        }

        // Search for location using Mapbox API
        function searchLocation() {
            var url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + encodeURIComponent($('#location').val()) +
                '.json?access_token=' + mapboxgl.accessToken;
            $('#addresses').empty();
            // Send an AJAX request to get the location data
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    if (data.features.length > 0) {
                        // Get the city, state, and country from the location data
                        var city, state, country, lat, lon;
                        // Display a list of addresses for the search location
                        var addresses = data.features.map(function(feature) {
                            var address = {};
                            text = feature.text;
                            lat = feature.geometry.coordinates[0];
                            lon = feature.geometry.coordinates[1];
                            feature.context.map(function(con) {
                                if (con.id.startsWith("place") || con.id.startsWith("district")) {
                                    city = con.text;
                                } else if (con.id.startsWith("region")) {
                                    state = con.text;
                                } else if (con.id.startsWith("country")) {
                                    country = con.text;
                                } else if (con.id.startsWith("country")) {
                                    country = con.text;
                                }
                            });
                            if (typeof(text) != undefined) {
                                address.text = text;
                            }
                            if (typeof(city) != undefined) {
                                address.city = city;
                            }
                            if (typeof(state) != undefined) {
                                address.state = state;
                            }
                            if (typeof(country) != undefined) {
                                address.country = country;
                            }
                            if (typeof(lat) != undefined) {
                                address.lat = lat;
                            }
                            if (typeof(lon) != undefined) {
                                address.lon = lon;
                            }
                            return address;
                        });
                        addresses.map(function(address) {
                            var fullStr = '';
                            $.each(address, function(key, value) {
                                if (value !== undefined && key !== 'lat' && key !== 'lon') {
                                    fullStr += value;
                                    if (Object.keys(address).indexOf(key) != Object.keys(address)
                                        .length - 3) {
                                        fullStr += ', ';
                                    }
                                }
                            });
                            var listItem = $('<li>').addClass('renderedAddress location-search').on('click',
                                function() {
                                    selectAddress(address, fullStr);
                                }).html('<i class="las la-map-marker"></i> ' + fullStr);
                            $('#addresses').append(listItem);
                        });
                    } else {
                        $('#addresses').empty();
                        var listItem = '<li class="renderedAddress location-search">Not Found</li>'
                        $('#addresses').append(listItem);
                    }
                }
            };
            xhr.send();
            $('.loaderSpin').hide();
        }

        function selectAddress(address, fullStr) {
            $('#city-input').val(address.city);
            $('#state-input').val(address.state);
            $('#country-input').val(address.country);
            $('#lat-input').val(address.lat);
            $('#lon-input').val(address.lon);
            $('#location').val(fullStr);
            $('#addresses').empty();
        }
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
                if ($(".trumEdit2")[0]) {
                    ClassicEditor
                        .create(document.querySelector('.trumEdit2'))
                        .then(editor => {
                            window.editor = editor;
                        });
                }

            });
        })(jQuery);
    </script>
@endpush
