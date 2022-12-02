<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Property</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script type='text/javascript' src='{{ asset('js/jquery.min.js') }}'></script>
        <script type='text/javascript' src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script type='text/javascript' src="{{ asset('js/jquery-ui.min.js') }}"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <style>
            .select2-selection--single {height: 38px !important;padding-top: 4px;}
            .select2-container--default .select2-selection--single .select2-selection__arrow{top:6px;}
        </style>
    </head>
    <body class="antialiased">
        <section>
            <div class="container-header">
                <div class="header">
                    <div class="logo-class">
                        <img class="logo" src="{{ asset('img/tripwix_logo_caribbeangreen6.png') }}">
                        <p>Sales Platform</p>
                    </div>
                    <input type="search" id="search" name="search" placeholder="Search for a home">
                </div>
            </div>
                <div class="sales-platform">
                    <div class="search-sales">
                        <div class="form-class">
                            <h1>Find homes quickly for your clients</h1>
                            <div class="form-wrapper">
                                <form class="row g-3 form-input search-form">

                                    <div class="col-auto description">
                                        <div class="select">
                                            <div class="select__trigger destination-label"><span>{{ (@request()->city) ? @request()->city : 'Destination' }}</span>
                                                <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                            </div>
                                            <div class="form-control custom-options">
                                                <span selected class="custom-option select-destination-name" data-value="">Destination</span>
                                                @foreach($cities as $city)
                                                <span class="custom-option select-destination-name" data-value="{{ $city }}">{{ $city }}</span>
                                                @endforeach
                                                <input type="text" class="d-none" name="city" value="{{@request()->city}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto search-input">
                                        <div class="col-auto">
                                            <label for="start_date" class="visually-hidden">Start Date</label>
                                            <input type="text" autocomplete="off" name="start_date" class="form-control datepicker" placeholder="Start Date" value="{{ @request()->start_date }}">
                                            <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                        </div>
                                        <div class="col-auto">
                                            <label for="end_date" class="visually-hidden">End Date</label>
                                            <input type="text" autocomplete="off" name="end_date" class="form-control datepicker" placeholder="End Date" value="{{ @request()->end_date }}">
                                            <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                        </div>
                                    </div>
                                    <div class="col-auto baderooms">
                                        <div class="select">
                                            <div class="select__trigger bedrooms-label"><span>{{ (@request()->bedrooms) ? @request()->bedrooms : 'Bedrooms' }}</span>
                                                <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                            </div>
                                            <div class="form-control custom-options">
                                                <span selected class="custom-option select-bedrooms" data-value="">Bedrooms</span>
                                                @for($i=1; $i<=$maxBedrooms; $i++)
                                                <span class="custom-option select-bedrooms" data-value="{{ $i }}">{{ $i }}</span>
                                                @endfor
                                                <input type="text" class="d-none" name="bedrooms" value="{{@request()->bedrooms}}" />
                                                <input type="text" class="d-none" name="sort_by" value="{{@request()->sort_by}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto search-btn">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="container-sort">
                        <div class="select-wrapper sort">
                            <div class="col-auto select-click">
                                <div class="select">
                                    <div class="select__trigger"><span>{{ (@request()->sort_by) ? @request()->sort_by : 'Sort by' }}</span>
                                        <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                    </div>
                                    <div class="form-control custom-options">
                                        <span selected class="custom-option select-sortby" data-value="Property Name A to Z">Property Name A to Z</span>
                                        <span selected class="custom-option select-sortby" data-value="No. of Bedrooms">No. of Bedrooms</span>
                                        <span selected class="custom-option select-sortby" data-value="Property Type">Property Type</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-search">
                        <div class="row justify-content-center mobile-grid">
                            @forelse($properties as $property)
                            <div class="col-md-4 col-xl-4 col-sm-6 mb-3 ">
                                <div class="card shadow-0 border rounded-3 card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-xl-12 card-name">
                                                <div class="info-top">
                                                    <div class="des-ID">
                                                        <a href="javascript:void(0)">{{ $property->name }}</a>
                                                        <span class="property-ID">{{ $property->property_id }}</span>
                                                    </div>
                                                    <div class="bed">
                                                        <img src="{{ asset('img/bed.png') }}">
                                                        <span>{{ $property->no_of_bedrooms }}</span>
                                                    </div>
                                                </div>
                                                <div class="info-bottom">
                                                    <div>
                                                        <div class="result">
                                                            <b>Destination:</b>
                                                            <span>{{ $property->destination }}</span>
                                                        </div>
                                                        <div class="result">
                                                            <b>Max Guests:</b>
                                                            <span>{{ $property->max_guests }}</span>
                                                        </div>
                                                        <div class="result">
                                                            <b>No. of Bathrooms:</b>
                                                            <span>{{ $property->no_of_bathrooms }}</span>
                                                        </div>
                                                        <div class="result">
                                                            <b>Property Type:</b>
                                                            <span>{{ $property->property_type }}</span>
                                                        </div>
                                                        <div class="result">
                                                            <b>No. of Beds:</b>
                                                            <span>{{ $property->no_of_beds }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="click-btn">
                                                        <button class="{{ ($property->clickup_id) ? 'active' : 'disabled' }}" onclick="{{ ($property->clickup_id) ? 'window.open(\''.$property->clickup_id.'\', \'\', \'popup\')' : '' }}">ClickUp</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="col-md-12 col-xl-10 mb-3">
                                    <div class="card shadow-0 border rounded-3">
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-xl-6">
                                                <p class="text-truncate mb-4 mb-md-0">
                                                    Data not found!
                                                </p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            @if($properties)
            <div class="row justify-content-center float-end pt-3 pagina">
                {!! $properties->appends($_GET)->links('pagination::bootstrap-4') !!}
            </div>
            @endif
            </div>

        </section>

        <script>
            $(document).ready(function(){
                $('.select-destination-name').click(function(){
                    $('.destination-label span').html($(this).attr('data-value'));
                    $('input[name=city]').val($(this).attr('data-value'));
                });
                $('.select-bedrooms').click(function(){
                    $('.bedrooms-label span').html($(this).attr('data-value'));
                    $('input[name=bedrooms]').val($(this).attr('data-value'));
                });
                $('.select-sortby').click(function(){
                    $('input[name=sort_by]').val($(this).attr('data-value'));
                    $('form.search-form').submit();
                });
            });
            $( function() {
                $('.select2').select2();
                $( ".datepicker" ).datepicker({
                dateFormat: "dd-mm-yy"
              });
            });
        </script>
        <script>
            document.querySelector('.select-click').addEventListener('click', function() {
                this.querySelector('.select').classList.toggle('open');
            })

            window.addEventListener('click', function(e) {
                const select = document.querySelector('.select')
                if (!select.contains(e.target)) {
                    select.classList.remove('open');
                }
            });


            document.querySelector('.description').addEventListener('click', function() {
                this.querySelector('.select').classList.toggle('open');
            })

            window.addEventListener('click', function(e) {
                const select = document.querySelector('.select')
                if (!select.contains(e.target)) {
                    select.classList.remove('open');
                }
            });

            document.querySelector('.baderooms').addEventListener('click', function() {
                this.querySelector('.select').classList.toggle('open');
            })

            window.addEventListener('click', function(e) {
                const select = document.querySelector('.select')
                if (!select.contains(e.target)) {
                    select.classList.remove('open');
                }
            });
        </script>
    </body>
</html>
