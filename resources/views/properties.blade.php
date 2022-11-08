<!DOCTYPE html>
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


        <section style="background-color: #eee;padding-bottom: 25px;" >

            <div class="container py-5">

                <div class="row justify-content-center mb-3">
                    <div class="col-md-12 col-xl-10">
                        <form class="row g-3">
                            <div class="col-auto">
                                <label for="end_date" class="visually-hidden">Destination</label>
                                <select name="city" class="form-control select2" placeholder="City">
                                    <option value="">Select Destination</option>
                                    @foreach($cities as $city) 
                                    <option {{ (@request()->city == $city) ? 'selected' : '' }} value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <label for="start_date" class="visually-hidden">Start Date</label>
                                <input type="text" autocomplete="off" name="start_date" class="form-control datepicker" placeholder="Start Date" value="{{ @request()->start_date }}">
                            </div>
                            <div class="col-auto">
                                <label for="end_date" class="visually-hidden">End Date</label>
                                <input type="text" autocomplete="off" name="end_date" class="form-control datepicker" placeholder="End Date" value="{{ @request()->end_date }}">
                            </div>
                            <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row justify-content-center ">

                    {{-- <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                            Home
                          </button>
                          <div class="collapse show" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                              <li><a href="#" class="link-dark rounded">Overview</a></li>
                              <li><a href="#" class="link-dark rounded">Updates</a></li>
                              <li><a href="#" class="link-dark rounded">Reports</a></li>
                            </ul>
                          </div>
                        </li>
                      </ul>     --}}

                @forelse($properties as $property)

                    <div class="col-md-4 col-xl-4 col-sm-6 mb-3">
                        <div class="card shadow-0 border rounded-3">
                            <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                    <img src="https://drive.google.com/uc?export=view&id=1Sn6W0tj7ICdyhiRrRHN_Mze5dVwFdZir"
                                    class="w-100" />
                                    <a href="#!">
                                    <div class="hover-overlay">
                                        <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                    </div>
                                    </a>
                                </div>
                                </div> --}}
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <h5><a href="javascript:void(0)" style="color:black;text-decoration: none;" >
                                        {{ $property->name }}
                                    </a></h5>
                                    <div class="row">
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>Destination</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->destination }}</span>
                                        </div>
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>Country</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->country }}</span>
                                        </div>
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>Property ID</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->property_id }}</span>
                                        </div>
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>Property Type</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->property_type }}</span>
                                        </div>
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>Max Guests</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->max_guests }}</span>
                                        </div>
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>No. of Beds</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->no_of_beds }}</span>
                                        </div>
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>No. of Bathrooms</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->no_of_bathrooms }}</span>
                                        </div>
                                        <div class="mt-1 mb-0 text-muted small col-6">
                                            <b>No. of Bedrooms</b>
                                            <span class="text-primary"> • </span>
                                            <span>{{ $property->no_of_bedrooms }}</span>
                                        </div>
                                    </div>

                                    {{-- <p class="text-truncate1 mb-4 mb-md-0">
                                        {!! Str::words($property->description, 50, '...') !!}
                                    </p> --}}

                                </div>
                                {{-- <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <h4 class="mb-1 me-1">$13.99</h4>
                                        <span class="text-danger"><s>$20.99</s></span>
                                    </div>
                                    <h6 class="text-success">Free shipping</h6>
                                    <div class="d-flex flex-column mt-4">
                                        <button class="btn btn-primary btn-sm" type="button">Details</button>
                                        <button class="btn btn-outline-primary btn-sm mt-2" type="button">
                                        Add to wishlist
                                        </button>
                                    </div>
                                </div> --}}
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

                @if($properties)
                <div class="row justify-content-center float-end pt-3">
                    {!! $properties->appends($_GET)->links('pagination::bootstrap-4') !!}
                    {{-- 'pagination::bootstrap-4' --}}
                </div>
                @endif
            </div>

        </section>

        <script>
            $( function() {
                $('.select2').select2();
                $( ".datepicker" ).datepicker({
                dateFormat: "dd-mm-yy"
              });
            } );
        </script>
    </body>
</html>
