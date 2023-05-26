<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <title>Property</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css?v=' . rand(1111, 999999)) }}" rel="stylesheet">

    <!-- Scripts -->
    <script type='text/javascript' src='{{ asset('js/jquery.min.js') }}'></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/loadingoverlay.min.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .select2-selection--single {
            height: 38px !important;
            padding-top: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px;
        }
    </style>
</head>

<body class="antialiased">
    <section>
        <div class="container-header">
            <div class="header">
                <div class="logo-class">
                    <div class="droparrow-wrapper">
                        <img class="droparrow" src="{{ asset('img/down-arrow-black.png') }}">
                    </div>
                    <a href="{{ url('') }}"><img class="logo"
                            src="{{ asset('img/tripwix_logo_caribbeangreen6.png') }}"></a>
                </div>

                <div class="header-right">
                    <div class="ticket" id="ticket-btn">
                        <img src="{{ asset('img/ticket.png') }}">
                        <div class="ticketbtn" role="button">Send ticket</div>
                    </div>
                    <div class="ticket-form" id="ticket-form">
                        <form method="post" action="{{ url('index.php/create-task') }}" class="creteTicketForm">
                            @csrf
                            <p>Please close the dates:</p>
                            <div class="col-auto search-input d-flex">

                                <input type="text" name="daterange_mobile"
                                    value="{{ @request()->daterange_mobile }}" class="regervation"
                                    placeholder="Please select" inputmode="none"
                                    style="color: #636366; font-size: 9px; font-weight: 500; font-family: Inter-Regular;
                                                    border: 1px solid #8e8e93; border-radius: 3px; padding: 9px 12px; width: 100%!important;margin-bottom: 17px;" />
                                <!-- <input class="calendar daterange" type="text" name="daterange_mobile" value="{{ @request()->daterange_mobile ?? date('m/d/Y') . ' - ' . date('m/d/Y') }}"
                                            style="color: #636366; font-size: 9px; font-weight: 500; font-family: Inter-Regular;
                                                    border: 1px solid #8e8e93; border-radius: 3px; padding: 9px 12px; width:100%!important;
                                                    text-align: center; margin-bottom: 17px;"/> -->
                            </div>
                            <p>Property ID</p>
                            <div class="ticket-id">
                                <input id="property_id" name="property_id" placeholder="Property ID">
                            </div>
                            <div class="select-form">
                                <select name="requestee_id">
                                    <option value="">Requestee</option>
                                    @foreach ($salesPersonsList as $salesPerson)
                                        <option value="{{ $salesPerson->id }}">{{ $salesPerson->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="ticket-send ticket-send-btn">Send Ticket</button>
                        </form>
                    </div>
                    <div class="ticket-form class-thanks" id="ticket-thanks">
                        <img src="{{ asset('img/bitmap@3x.png') }}">
                        <h2>Thanks!</h2>
                        <p>We have received the ticket and will update the availability accordingly.</p>
                        <button class="closeThanksBtn" onclick="closeTicket()">Close</button>
                    </div>
                    <div class="searchHeader" id="searchHeader">
                        <img class="loupe" src="{{ asset('img/loupe.png') }}">
                        <input class="searchClass" onkeyup="searchProperties(this.value)" type="search" id="search"
                            name="search" placeholder="Search Name/ID">
                        <div class="search-dropdown" id="webSearchResults">
                        </div>
                    </div>
                </div>
                <div class="searchMobile" id="mobileSearch">
                    <div class="searchWrappMobile">
                        <input class="searchClassMobile" onkeyup="searchProperties(this.value)" value=""
                            type="search" id="searchMobile" name="search" placeholder="Search Name/ID">
                    </div>
                    <div class="dropdownSearchMobile" id="mobileSearchResults">
                    </div>
                </div>
            </div>
        </div>
        <div class="sales-platform">
            <div class="search-sales">
                <div class="form-class">
                    <h1>Find homes quickly</h1>
                    <div class="form-wrapper">
                        <form method="GET" action="{{ url('') }}" class="row g-3 form-input search-form">
                            <div class="col-auto description">
                                <div class="select">
                                    <div class="select__trigger destination-label">
                                        <span>{{ @request()->city ? @request()->city : 'Destination' }}</span>
                                        <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                    </div>
                                    <div class="form-control custom-options">
                                        @foreach ($cities as $city)
                                            <span class="custom-option select-destination-name"
                                                data-value="{{ $city }}">{{ $city }}</span>
                                        @endforeach
                                        <input type="text" class="d-none" name="city"
                                            value="{{ @request()->city }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto community-div description">
                                <div class="select">
                                    <div class="select__trigger community-label">
                                        <span class="text-capitalize">{{ @request()->community ? ucwords(strtolower(@request()->community)) : 'All Communities' }}</span>
                                        <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                    </div>
                                    <div class="form-control custom-options community-options">
                                        @foreach ($communities as $community)
                                            <span class="custom-option select-community-name"
                                                data-value="{{ $community }}">{{ ucwords(strtolower($community)) }}</span>
                                        @endforeach
                                    </div>
                                    <input type="text" class="d-none community_input" name="community" value="{{ ucwords(strtolower(@request()->community)) }}" />
                                </div>
                            </div>
                            <div class="col-auto search-input d-flex">
                                <!--  <input class="calendar daterange" type="text" name="daterange" value="{{ @request()->daterange ?? date('m/d/Y') . ' - ' . date('m/d/Y') }}"
                                            style="color: #636366; font-size: 9px; font-weight: 500; font-family: Inter-Regular;
                                                    border: 1px solid #8e8e93; border-radius: 3px;     padding: 9px 12px;"/> -->
                                <input type="text" name="daterange" value="{{ @request()->daterange }}"
                                    class="regervation" placeholder="Please select" inputmode="none"
                                    style="color: #636366; font-size: 9px; font-weight: 500; font-family: Inter-Regular;
                                border: 1px solid #8e8e93; border-radius: 3px;     padding: 9px 12px;" />
                            </div>
                            <div class="col-auto baderooms">
                                <div class="select">
                                    <div class="select__trigger bedrooms-label">
                                        <span>{{ @request()->bedrooms ? @request()->bedrooms : 'Bedrooms' }}</span>
                                        <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                    </div>
                                    <div class="form-control custom-options">
                                        <span selected class="custom-option select-bedrooms"
                                            data-value="">Bedrooms</span>
                                        @for ($i = 1; $i <= $maxBedrooms; $i++)
                                            <span class="custom-option select-bedrooms"
                                                data-value="{{ $i }}">{{ $i }}</span>
                                        @endfor
                                        <input type="text" class="d-none" name="bedrooms"
                                            value="{{ @request()->bedrooms }}" />
                                    </div>
                                </div>
                            </div>

                            <input type="text" class="d-none" name="sort_by" value="{{ @request()->sort_by }}" />
                            <input type="text" class="d-none" name="view_types" value="{{ @request()->view_types }}" />
                            <input type="text" class="d-none" name="placement_types" value="{{ @request()->placement_types }}" />

                            <div class="col-auto search-btn">
                                <button type="submit" class="btn btn-primary mb-3">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container-sort{{ $properties ? ' d-block' : '' }}">
                <div class="select-wrapper sort">

                    <div class="col-auto select-click filteri">
                        <div class="select  filterr">
                            <div class="select__trigger" role="button">
                                <span>Filters</span>
                                <img class="downarrow" src="{{ asset('img/icon-filter@3x.png') }}">
                            </div>
                        </div>

                        <div class="filter-form" id="filter-form">
                            <img class="iconblack-x" src="{{ asset('img/iconblack-xmark@3x.png') }}">
                            <p style="text-align: left;">View types</p>
                            <div class="select-form">
                                <select class="view_types">
                                    <option value="">All view types</option>
                                    @foreach($viewTypes as $viewType)
                                    <option value="{{ $viewType }}" {{ (@request()->view_types == $viewType) ? 'selected' : '' }}>{{ $viewType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p style="text-align: left;">Placement Types</p>

                            <div class="select-form">
                                <select class="placement_types">
                                    <option value="">All placement types</option>
                                    @foreach($placementTypes as $placementType)
                                    <option value="{{ $placementType }}" {{ (@request()->placement_types == $placementType) ? 'selected' : '' }}>{{ $placementType }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="ticket-send set-filters-btn" style="width:100%">Set Filters</button>
                        </div>

                        <div class="select sort-dropdown">
                            <div class="select__trigger">
                                <span>{{ @request()->sort_by ? @request()->sort_by : 'Sort by' }}</span>
                                <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                            </div>
                            <div class="form-control custom-options open-sort">
                                <span selected class="custom-option select-sortby"
                                    data-value="Community Ascending">Community Ascending</span>
                                <span selected="" class="custom-option select-sortby"
                                    data-value="Price Low to High">Price Low to High</span>
                                <span selected class="custom-option select-sortby"
                                    data-value="Property Name A to Z">Property Name A to Z</span>
                                <span selected class="custom-option select-sortby" data-value="No. of Bedrooms">No. of
                                    Bedrooms</span>
                                <span selected class="custom-option select-sortby" data-value="Property Type">Property
                                    Type</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-search{{ $properties ? ' open' : '' }}">
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
                                                <div class="bed" style="position: relative;">
                                                    <div class="bed-number">
                                                        <img src="{{ asset('img/bed.png') }}">
                                                        <span>{{ $property->no_of_bedrooms }}</span>
                                                    </div>
                                                    <div class="average-price">
                                                        <div class="average-night">
                                                            @if ($property->average == '99999999999999999999')
                                                                <p>N/A</p>
                                                            @else
                                                                <p>{!! $property->currency_symbol !!}{{ number_format($property->average, 2) }}
                                                                </p>
                                                                <p>Average/Night</p>
                                                            @endif
                                                        </div>
                                                        <img class="infoImage"
                                                            src="{{ asset('img/icon-info@3x.png') }}">
                                                    </div>

                                                    <div class="information">
                                                        <img class="infoClose"
                                                            src="{{ asset('img/icon-xmark@3x.png') }}">
                                                        <div class="date-price">
                                                            <p>Breakdown:</p>
                                                            <p>{{ date('M d', strtotime(@$startDate)) }} -
                                                                {{ date('M d', strtotime(@$endDate)) }}</p>
                                                        </div>
                                                        <div class="average-price-date">
                                                            @foreach ($property->prices as $key => $price)
                                                                <div class="order">
                                                                    <p>{{ date('M d', strtotime($key)) }}</p>
                                                                    @if ($price > 0)
                                                                        <p>{!! $property->currency_symbol !!}{{ number_format($price, 2) }}
                                                                        </p>
                                                                    @else
                                                                        <p>N/A</p>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="total">
                                                            <p>Total</p>
                                                            @if ($property->total_price > 0)
                                                                <p>{!! $property->currency_symbol !!}{{ number_format($property->total_price, 2) }}
                                                                </p>
                                                            @else
                                                                <p>N/A</p>
                                                            @endif
                                                        </div>
                                                        <div class="note-card">
                                                            @if ($property->total_price > 0)
                                                                <p>*Add VAT/Fees when sending client</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!--<div class="information-mobile">
                                                        <p class="breakdown">Breakdown:</p>
                                                        <p class="date-mobile">{{ date('M d', strtotime(@$startDate)) }} - {{ date('M d', strtotime(@$endDate)) }}</p>
                                                        <div class="note-card">
                                                            @if ($property->total_price > 0)
<p>*Add VAT/Fees when sending client</p>
@endif
                                                        </div>
                                                        <div class="average-price-date">
                                                            @foreach ($property->prices as $key => $price)
<div class="order">
                                                                <p>{{ date('M d', strtotime($key)) }}</p>
                                                                @if ($price > 0)
<p>{!! $property->currency_symbol !!} {{ number_format($price, 2) }}</p>
@else
<p>N/A</p>
@endif
                                                            </div>
@endforeach
                                                        </div>
                                                        <div class="total">
                                                            <p>Total</p>
                                                            @if ($property->total_price > 0)
<p>{!! $property->currency_symbol !!} {{ number_format($property->total_price, 2) }}</p>
@else
<p>N/A</p>
@endif
                                                        </div>
                                                    </div>-->
                                                </div>
                                            </div>
                                            <div class="info-bottom">
                                                <div>
                                                    <div class="result">
                                                        <b>Community:</b>
                                                        <span>{{ ucwords(strtolower($property->community)) }}</span>
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
                                                <div class="click-btn mini-icons">
                                                    @if ($property->future_events == 0)
                                                        <div style="margin-bottom: 12px;">
                                                            <img style="width: 11px;"
                                                                src="{{ asset('img') }}/invalid-name@3x.png">
                                                        </div>
                                                    @endif
                                                    <div style="display: flex; gap: 3px;">
                                                        <a class="{{ $property->pis ? 'active' : 'disabled' }}"
                                                            target="_blank"
                                                            href="{{ $property->pis ? $property->pis : 'javascript:void(0)' }}">
                                                            <img class="p-icon" src="{{ asset('img') }}/p@3x.png">
                                                        </a>
                                                        <a class="{{ $property->google_calendar_link ? 'active' : 'disabled' }}"
                                                            target="_blank"
                                                            href="{{ $property->google_calendar_link ? $property->google_calendar_link : 'javascript:void(0)' }}">
                                                            <img class="calendar-icon"
                                                                src="{{ asset('img') }}/invalid-name1@3x.png">
                                                        </a>
                                                        <a class="{{ $property->clickup_id ? 'active' : 'disabled' }}"
                                                            target="_blank"
                                                            href="{{ $property->clickup_id ? $property->clickup_id : 'javascript:void(0)' }}">
                                                            <img class="clickup-icon"
                                                                src="{{ asset('img') }}/bitmap1@3x.png">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>

            @if ($properties)
                <div class="row justify-content-center float-end pt-3 pagina">
                    {!! $properties->appends($_GET)->links('pagination::bootstrap-4') !!}
                </div>
            @endif

            @if (!$properties)
                <div class="container-default">
                    <h2>Useful links</h2>
                    <div class="default-page">
                        <a href="#" target="_blank" role="button">
                            <div class="box">
                                <img src="{{ asset('img/box-1.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/_invalid-name@3x.png') }}">
                                    <h2>Our Collection</h2>
                                    <p>See all our best homes soon...</p>
                                </div>
                            </div>
                        </a>

                        <a href="https://doc.clickup.com/4656098/d/h/4e2z2-8080/ceef9f6e09ea4e1" target="_blank"
                            role="button">
                            <div class="box">
                                <img src="{{ asset('img/screenshot-2022-12-09-at-12-28-55@3x.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/simpol-2.png') }}">
                                    <h2>Clickup Views</h2>
                                    <p>See all of our homes in Clickup table views.</p>
                                </div>
                            </div>
                        </a>
                        <a href="https://sharing.clickup.com/4656098/tl/h/4e2z2-8060/db7242fdd0ba935" target="_blank"
                            role="button">
                            <div class="box">
                                <img src="{{ asset('img/box-3.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/simbol-3.png') }}">
                                    <h2>Product Roadmap</h2>
                                    <p>See whats coming next for the Sales Platform.</p>
                                </div>
                            </div>
                        </a>
                        <a href="https://forms.clickup.com/4656098/f/4e2z2-8040/D676DELAIT01WNQR3F" target="_blank"
                            role="button">
                            <div class="box">
                                <img src="{{ asset('img/box-4.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/simpol-4.png') }}">
                                    <h2>Request Change</h2>
                                    <p>Ask for a new feature or report a bug.</p>
                                </div>
                            </div>
                        </a>

                        <a href="https://doc.clickup.com/4656098/d/h/4e2z2-8720/970ca46603a3d1b" target="_blank"
                            role="button">
                            <div class="box">
                                <img src="{{ asset('img/bitmap6@3x.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/icon-marketing1@3x.png') }}">
                                    <h2>Current Marketing</h2>
                                    <p>See which campaigns we have running. (Promos, offers, etc…)</p>
                                </div>
                            </div>
                        </a>

                        <a href="https://doc.clickup.com/4656098/d/h/4e2z2-8740/86a51af83a6956d" target="_blank"
                            role="button">
                            <div class="box">
                                <img src="{{ asset('img/bitmap7@3x.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/icon-contract@3x.png') }}">
                                    <h2>Contracts</h2>
                                    <p>Contracts for Sales</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ config('app.url') . '/index.php/error_logs' }}" target="_blank" role="button">
                            <div class="box">
                                <img src="{{ asset('img/bitmap8@3x.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/icon-warning@3x.png') }}">
                                    <h2>Error Logs</h2>
                                    <p>Logs for our errors</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include('notification')

    <script>
        const ticketBtn = document.querySelector('.ticket');
        const ticketForm = document.querySelector('.ticket-form');
        const ticketFormThanks = document.querySelector('.class-thanks');
        const seacrhHeader = document.querySelector('.searchHeader');

        $(document).ready(function() {

            $('.select-destination-name').click(function() {
                const value = $(this).attr('data-value');
                $('.destination-label span').html(value);
                $('input[name=city]').val(value);

                const _self = $(".community-div");
                _self.LoadingOverlay('show');
                $.ajax({
                    type: 'GET',
                    url: '{{ url("get-communities") }}' + '?destination=' + value,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            $(".community-options").html('');
                            res.communities.map(function(community) {
                                humanName = community.toLowerCase();
                                $(".community-options").append(`<span class="custom-option select-community-name text-capitalize" data-value="${community}">${humanName}</span>`);
                            });
                        }
                    },
                    error: function(request, status, error) {
                        showAjaxErrorMessage(request);
                    },
                    complete: function(res) {
                        $('.community-label span').html('All Communities');
                        $('.community_input').val('');
                        _self.LoadingOverlay('hide');
                    }
                });

            });

            $(document).on('click', '.select-community-name', function() {
                const value = $(this).attr('data-value');
				humanName = value.toLowerCase();
                $('.community-label span').html(humanName);
                $('.community_input').val(value);
            });

            $('.select-bedrooms').click(function() {
                $('.bedrooms-label span').html($(this).attr('data-value'));
                $('input[name=bedrooms]').val($(this).attr('data-value'));
            });
            $('.select-sortby').click(function() {
                $('input[name=sort_by]').val($(this).attr('data-value'));
                $('form.search-form').submit();
            });

            $('.set-filters-btn').click(function() {
                $('form.search-form').submit();
            });

            $(".view_types").change(function() {
                $("input[name=view_types]").val($(this).val());
            });

            $(".placement_types").change(function() {
                $("input[name=placement_types]").val($(this).val());
            });

            $(".ticket-send-btn").click(function(e) {
                e.preventDefault();
                const _self = $(this);
                const _form = $('.creteTicketForm');
                const formData = _form.serialize();
                _self.LoadingOverlay('show');
                $.ajax({
                    type: _form.attr('method'),
                    url: _form.attr('action'),
                    processData: false,
                    dataType: 'json',
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            //successMessage('Task successfully created');
                            ticketForm.classList.remove('open')
                            ticketFormThanks.classList.add('open')
                            $("#property_id").val('');
                            $(".datepicker").val('');
                        } else {
                            errorMessage('Task not created');
                        }
                    },
                    error: function(request, status, error) {
                        showAjaxErrorMessage(request);
                    },
                    complete: function(res) {
                        _self.LoadingOverlay('hide');
                    }
                });
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

        document.querySelector('.community-div').addEventListener('click', function() {
            this.querySelector('.select').classList.toggle('open');
        })

        document.querySelector('.sort-dropdown').addEventListener('click', function() {
            this.querySelector('.open-sort').classList.toggle('open');
        })

        document.querySelector('.baderooms').addEventListener('click', function() {
            this.querySelector('.select').classList.toggle('open');
        })

        window.addEventListener('click', function(e) {
            const select = document.querySelector('.select')
            if (!select.contains(e.target)) {
                select.classList.remove('open');
            }
        });


        let width = window.screen.availWidth;
        const mobileWidth = '810';
        const searchOpen = document.querySelector('.searchClass');
        const searchDrop = document.querySelector('.search-dropdown');
        const loupe = document.querySelector('.loupe');
        const loupeParent = document.querySelector('.searchHeader');
        const droparrow = document.querySelector('.droparrow');
        const droparrowWrapper = document.querySelector('.droparrow-wrapper');
        const logo = document.querySelector('.logo');
        const logoClass = document.querySelector('.logo-class');
        const searchMobile = document.querySelector('.searchMobile');
        const salesPlatform = document.querySelector('.sales-platform');
        const body = document.querySelector('body');
        var scrollPos;
        // const infoMobile = ;


        const infoIcon = document.querySelectorAll('.average-price img');
        const infoCard = document.querySelectorAll('.information');
        const informationClose = document.querySelectorAll('.infoClose');
        // const informationMobile = document.querySelectorAll('.information-mobile');


        for (const info of infoIcon) {
            info.addEventListener('click', function() {
                const averagePrice = info.parentElement;
                const informationCard = averagePrice.nextElementSibling;
                informationCard.classList.add('open')
            })
        }
        for (const iClose of informationClose) {
            iClose.addEventListener('click', function() {
                for (const card of infoCard) {
                    card.classList.remove('open')
                }
            })
        }

        // if(width < mobileWidth){
        //     for(const info of infoIcon){
        //         info.addEventListener('click',function(){
        //             const averagePrice = info.parentElement;
        //             const informationCard = averagePrice.nextElementSibling;
        //             const infoMobile = informationCard.nextElementSibling;

        //             infoMobile.classList.add('open')
        //             logo.classList.add('display')
        //             ticketBtn.classList.add('open')
        //             loupeParent.classList.add('open')
        //             droparrowWrapper.classList.add('open')
        //             droparrow.classList.add('open')
        //             body.classList.toggle('open')
        //             // save scroll position to a variable
        //             scrollPos = $(window).scrollTop();
        //             $('html, body').scrollTop($("#ticket-btn").offset().top);

        //             droparrowWrapper.addEventListener('click',function(){
        //                 infoMobile.classList.remove('open')
        //                 $('html, body').scrollTop(scrollPos);
        //             })
        //         })
        //     }
        // }

        searchOpen.addEventListener('click', function() {
            searchDrop.classList.toggle('display')
            document.getElementById("webSearchResults").innerHTML = '';
            document.getElementById("mobileSearchResults").innerHTML = '';
        })
        seacrhHeader.addEventListener('click', function() {
            openSearch();
        })

        function openSearch() {
            document.getElementById("webSearchResults").innerHTML = '';
            document.getElementById("mobileSearchResults").innerHTML = '';
            droparrow.classList.add('open')
            logo.classList.add('display')
            logoClass.classList.add('open')
            searchMobile.classList.add('open')
            droparrowWrapper.classList.add('open')

            if (width < mobileWidth) {
                salesPlatform.classList.add('d-none')
                loupeParent.classList.add('d-none')
                loupeParent.classList.add('d-none')
                ticketBtn.classList.remove('open')
                ticketBtn.classList.add('d-none')
                ticketFormThanks.classList.remove('open')
                ticketForm.classList.remove('open')

            }
        }

        function closeSearch() {
            droparrow.classList.remove('open')
            logo.classList.remove('open')
            logoClass.classList.remove('open')
            searchMobile.classList.remove('open')
            searchDrop.classList.remove('display')
            salesPlatform.classList.remove('d-none')

            if (width < mobileWidth) {
                loupe.classList.remove('d-none')
            }
            loupe.classList.remove('d-none')
            $('#search').val('');
        }

        droparrowWrapper.addEventListener('click', function() {
            droparrowWrapper.classList.remove('open')
            seacrhHeader.classList.remove('open')
            loupeParent.classList.remove('d-none')
            ticketBtn.classList.remove('d-none')
            logo.classList.remove('display')


            closeSearch()
            closeTicket()
        })

        const regervation = document.querySelector('.regervation');
        const applayBtn = document.querySelector('.btn-primary');
        let clickCalendar = '';

        window.addEventListener('click', function(e) {
            if (regervation) {
                regervation.addEventListener('click', function() {
                    clickCalendar = 'click';
                });
            }
            if (applayBtn) {
                applayBtn.addEventListener('click', function() {
                    clickCalendar = '';
                });
            }

            width = window.innerWidth;
            if (width < mobileWidth) {
                if (!document.getElementById('searchHeader').contains(e.target) &&
                    !document.getElementById('mobileSearch').contains(e.target) &&
                    !document.getElementById('ticket-btn').contains(e.target) &&
                    !document.getElementById('ticket-form').contains(e.target) &&
                    !document.getElementById('ticket-thanks').contains(e.target) &&
                    !document.getElementById('ui-datepicker-div').contains(e.target)) {
                    closeSearch();
                    closeTicket();
                }
            } else {
                if (!document.getElementById('searchHeader').contains(e.target) &&
                    !document.getElementById('mobileSearch').contains(e.target)) {
                    closeSearch();
                }
                if (!document.getElementById('ticket-btn').contains(e.target) &&
                    !document.getElementById('ticket-form').contains(e.target) &&
                    !document.getElementById('ticket-thanks').contains(e.target) &&
                    !document.getElementById('ui-datepicker-div').contains(e.target) &&
                    clickCalendar != 'click'
                ) {
                    closeTicket();
                }

            }
        })



        ticketBtn.addEventListener('click', function() {
            toggleTicket()
        })

        function closeTicket() {
            droparrow.classList.remove('open')
            logo.classList.remove('open')
            logoClass.classList.remove('open')
            droparrowWrapper.classList.remove('open')
            ticketBtn.classList.remove('open')
            ticketFormThanks.classList.remove('open')
            ticketForm.classList.remove('open')
            salesPlatform.classList.remove('d-none')
            loupeParent.classList.remove('d-none')
            $('#ticket-form form')[0].reset()
            body.classList.remove('open');
        }

        function toggleTicket() {
            ticketBtn.classList.toggle('open')
            ticketFormThanks.classList.remove('open')
            ticketForm.classList.toggle('open')

            if (width < mobileWidth) {
                searchMobile.classList.remove('open')
                loupeParent.classList.add('d-none')
                salesPlatform.classList.add('d-none')
                loupeParent.classList.toggle('d-none')
                body.classList.toggle('open');
                droparrowWrapper.classList.toggle('open')
                logo.classList.toggle('display');
                seacrhHeader.classList.toggle('open');
                droparrow.classList.add('display')


            }
            $('#ticket-form form')[0].reset()
        }

        function openTicket() {
            droparrow.classList.add('open')
            logo.classList.add('open')
            logoClass.classList.add('open')
            droparrowWrapper.classList.add('open')
            ticketBtn.classList.add('open')
            ticketFormThanks.classList.remove('open')
            ticketForm.classList.add('open')

            if (width < mobileWidth) {
                searchMobile.classList.remove('open')
                loupeParent.classList.add('d-none')
                salesPlatform.classList.add('d-none')
                loupeParent.classList.add('d-none')
                body.classList.add('open');
            }
            $('#ticket-form form')[0].reset()
        }

        function searchProperties(searchString) {
            document.getElementById("webSearchResults").innerHTML = '';
            document.getElementById("mobileSearchResults").innerHTML = '';
            if (searchString === "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("webSearchResults").innerHTML = this.responseText;
                document.getElementById("mobileSearchResults").innerHTML = this.responseText;
            }
            xhttp.open("GET", "index.php/search-properties?searchString=" + searchString);
            xhttp.send();
        }

        if (width > mobileWidth) {
            salesPlatform.classList.remove('open')
        }


        // filter js

        const filterButton = document.querySelector('.filterr');
        const filterForm = document.getElementById('filter-form');
        const closeFilters = document.querySelector('.iconblack-x');

        filterButton.addEventListener('click', function() {
            toggleFilter();
        });
        closeFilters.addEventListener('click', function() {
            closeFilter();
        });

        function toggleFilter() {
            filterForm.classList.toggle('open');
            closeFilters.classList.remove('none');


            if (width < mobileWidth) {
                searchMobile.classList.remove('open')
                loupeParent.classList.add('d-none')
                loupeParent.classList.toggle('d-none')
                body.classList.toggle('open');
                droparrowWrapper.classList.toggle('open')
                logo.classList.toggle('display');
                seacrhHeader.classList.toggle('open');
                droparrow.classList.add('display');
                closeFilters.classList.add('none');
                ticketBtn.classList.add('open')

            }
        }

        function closeFilter() {
            filterForm.classList.remove('open');

            droparrow.classList.remove('open')
            logo.classList.remove('open')
            droparrowWrapper.classList.remove('open')
            ticketBtn.classList.remove('open')
            loupeParent.classList.remove('d-none')
            body.classList.remove('open');
        }

        /**
         * Show Ajax Error Message
         * @param response
         */
        function showAjaxErrorMessage(response, form = false) {
            const responseJson = JSON.parse(response.responseText);
            const errors = responseJson.errors;

            if (errors !== undefined) {
                Object.keys(errors).forEach(function(item) {
                    for (let value of errors[item]) {
                        errorMessage(value);
                    }
                });
            } else if (responseJson.message !== undefined) {
                errorMessage(responseJson.message);
            }

        }

        /**
         * Show Success Message
         * @param message
         * @param title
         */
        function successMessage(message, title) {
            if (!title) title = "Success!";
            toastr.remove();
            toastr.success(message, '', {
                closeButton: true,
                timeOut: 4000,
                progressBar: true,
                newestOnTop: true
            });
        }

        /**
         * Show Error Message
         * @param message
         * @param title
         */
        function errorMessage(message, title) {
            if (!title) title = "Error!";
            toastr.remove();
            toastr.error(message, '', {
                closeButton: true,
                timeOut: 4000,
                progressBar: true,
                newestOnTop: true
            });
        }
    </script>
    <script>
        $('input[name="dates"]').daterangepicker();


        $(function() {
            $('input.daterange').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {});
        });
    </script>
    <script>
        $(function() {
            $('.regervation').daterangepicker({
                    "autoapply": true,
                    "linkedCalendars": false,
                },
                function(start, end, label) {
                    $('#displayRegervation').text('Registration date is: ' + start.format('YYYY-MM-DD') +
                        ' to ' + end.format('YYYY-MM-DD'));
                });
            $('.drp-calendar.right').hide();
            $('.drp-calendar.left').addClass('single');

            $('.calendar-table').on('DOMSubtreeModified', function() {
                var el = $(".prev.available").parent().children().last();
                if (el.hasClass('next available')) {
                    return;
                }
                el.addClass('next available');
                el.append('<span></span>');
            });
        });
    </script>
</body>

</html>
