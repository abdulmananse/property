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
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

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
            .select2-selection--single {height: 38px !important;padding-top: 4px;}
            .select2-container--default .select2-selection--single .select2-selection__arrow{top:6px;}
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
                        <a href="{{ config('app.url') }}"><img class="logo" src="{{ asset('img/tripwix_logo_caribbeangreen6.png') }}"></a>
                    </div>

                    <div class="header-right">
                        <div class="ticket" id="ticket-btn">
                            <img src="{{ asset('img/ticket.png') }}">
                            <div class="ticketbtn" role="button">Send ticket</div>
                        </div>
                        <div class="ticket-form" id="ticket-form">
                            <form method="post" action="{{ url('index.php/create-task') }}" class="creteTicketForm" >
                                @csrf
                                <p>Please close the dates:</p>
                                <div class="ticket-dates">
                                    <div class="input-form">
                                        <input type="text" autocomplete="off" name="start_date" placeholder="From" class="datepicker">
                                        <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                    </div>
                                    <div class="input-form">
                                        <input type="text" autocomplete="off" name="end_date" placeholder="To" class="datepicker">
                                        <img class="downarrow" src="{{ asset('img/down-arrow.png') }}">
                                    </div>
                                </div>
                                <p>Property ID</p>
                                <div class="ticket-id">
                                    <input id="property_id" name="property_id" placeholder="Property ID">
                                </div>
                                <div class="select-form">
                                    <select name="requestee_id">
                                        <option value="">Requestee</option>
                                        @foreach($salesPersonsList as $salesPerson)
                                        <option value="{{ $salesPerson->id }}">{{ $salesPerson->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="ticket-send">Send Ticket</button>
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
                            <input class="searchClass" onkeyup="searchProperties(this.value)" type="search" id="search" name="search" placeholder="Search Name/ID">
                            <div class="search-dropdown" id="webSearchResults">
                            </div>
                        </div>
                    </div>
                    <div class="searchMobile" id="mobileSearch">
                        <div class="searchWrappMobile">
                            <input class="searchClassMobile" onkeyup="searchProperties(this.value)" value="" type="search" id="searchMobile" name="search" placeholder="Search Name/ID">
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
                            <form class="row g-3 form-input search-form">
                                <div class="col-auto description">
                                    <div class="select">
                                        <div class="select__trigger destination-label">
                                            <span>{{ (@request()->city) ? @request()->city : 'Destination' }}</span>
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
                                <div class="col-auto search-input d-flex">
                                    <input class="calendar" type="text" name="daterange" value="{{ @request()->start_date ?? date('m/d/Y') }} - {{ @request()->end_date ?? date('m/d/Y') }}"
                                            style="color: #636366; font-size: 9px; font-weight: 500; font-family: Inter-Regular;
                                                    border: 1px solid #8e8e93; border-radius: 3px;     padding: 9px 12px;"/>
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
                <div class="container-sort{{ ($properties ? ' d-block' : '')}}">
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

                <div class="container-search{{ ($properties ? ' open' : '')}}">
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
                                                    <a class="{{ ($property->clickup_id) ? 'active' : 'disabled' }}" href="{{ ($property->clickup_id) ? $property->clickup_id : 'javascript:void(0)' }}" target="_blank">ClickUp</a>
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

                @if($properties)
                <div class="row justify-content-center float-end pt-3 pagina">
                    {!! $properties->appends($_GET)->links('pagination::bootstrap-4') !!}
                </div>
                @endif

                @if(!$properties)
                <div class="container-default">
                    <h2>Useful links</h2>
                    <div class="default-page">
                        <a href="#" target="_blank" role="button">
                            <div class="box">
                                <img src="{{ asset('img/box-1.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/invalid-name@3x.png') }}">
                                    <h2>Our Collection</h2>
                                    <p>See all our best homes soon...</p>
                                </div>
                            </div>
                        </a>

                        <a href="https://doc.clickup.com/4656098/d/h/4e2z2-8080/ceef9f6e09ea4e1" target="_blank" role="button">
                            <div class="box">
                                <img src="{{ asset('img/screenshot-2022-12-09-at-12-28-55@3x.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/simpol-2.png') }}">
                                    <h2>Clickup Views</h2>
                                    <p>See all of our homes in Clickup table views.</p>
                                </div>
                            </div>
                        </a>
                        <a href="https://sharing.clickup.com/4656098/tl/h/4e2z2-8060/db7242fdd0ba935" target="_blank" role="button">
                            <div class="box">
                                <img src="{{ asset('img/box-3.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/simbol-3.png') }}">
                                    <h2>Product Roadmap</h2>
                                    <p>See whats coming next for the Sales Platform.</p>
                                </div>
                            </div>
                        </a>
                        <a href="https://forms.clickup.com/4656098/f/4e2z2-8040/D676DELAIT01WNQR3F" target="_blank" role="button">
                            <div class="box">
                                <img src="{{ asset('img/box-4.png') }}">
                                <div class="box-right">
                                    <img src="{{ asset('img/simpol-4.png') }}">
                                    <h2>Request Feature</h2>
                                    <p>Ask for feature or request bugs on the Sales Platform.</p>
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

                $( ".datepicker" ).datepicker({
                    dateFormat: "dd-mm-yy"
                });

                $(".ticket-send").click(function(e){
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
                        success:function (res) {
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
                        error: function (request, status, error) {
                            showAjaxErrorMessage(request);
                        },
                        complete:function (res) {
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

            searchOpen.addEventListener('click',function(){
                searchDrop.classList.toggle('open')
                document.getElementById("webSearchResults").innerHTML = '';
                document.getElementById("mobileSearchResults").innerHTML = '';
            })
            loupe.addEventListener('click',function(){
                openSearch();
            })

            function openSearch(){
                document.getElementById("webSearchResults").innerHTML = '';
                document.getElementById("mobileSearchResults").innerHTML = '';
                droparrow.classList.add('open')
                logo.classList.add('open')
                logoClass.classList.add('open')
                searchMobile.classList.add('open')
                droparrowWrapper.classList.add('open')
                if(width < mobileWidth){
                    salesPlatform.classList.add('d-none')
                }
                loupeParent.classList.add('d-none')
                ticketBtn.classList.remove('open')
                ticketBtn.classList.add('d-none')
                ticketFormThanks.classList.remove('open')
                ticketForm.classList.remove('open')
                if(width < mobileWidth){
                    loupeParent.classList.add('d-none')
                }
            }

            function closeSearch(){
                droparrow.classList.remove('open')
                logo.classList.remove('open')
                logoClass.classList.remove('open')
                searchMobile.classList.remove('open')
                searchDrop.classList.remove('open')
                salesPlatform.classList.remove('d-none')

                if(width < mobileWidth){
                    loupe.classList.remove('d-none')
                }
                loupe.classList.remove('d-none')
                $('#search').val('');
            }

            droparrow.addEventListener('click',function(){
                droparrowWrapper.classList.remove('open')
                seacrhHeader.classList.remove('open')
                loupeParent.classList.remove('d-none')
                ticketBtn.classList.remove('d-none')
                closeSearch()
                closeTicket()
            })



            ticketBtn.addEventListener('click', function(){
                toggleTicket()
            })

            function closeTicket(){
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

            function toggleTicket(){
                droparrow.classList.toggle('open')
                logo.classList.toggle('open')
                logoClass.classList.toggle('open')
                droparrowWrapper.classList.toggle('open')
                ticketBtn.classList.toggle('open')
                ticketFormThanks.classList.remove('open')
                ticketForm.classList.toggle('open')

                if(width < mobileWidth){
                    searchMobile.classList.remove('open')
                    loupeParent.classList.add('d-none')
                    salesPlatform.classList.add('d-none')
                    loupeParent.classList.toggle('d-none')
                    body.classList.toggle('open');
                }
                $('#ticket-form form')[0].reset()
            }

            function openTicket(){
                droparrow.classList.add('open')
                logo.classList.add('open')
                logoClass.classList.add('open')
                droparrowWrapper.classList.add('open')
                ticketBtn.classList.add('open')
                ticketFormThanks.classList.remove('open')
                ticketForm.classList.add('open')

                if(width < mobileWidth){
                    searchMobile.classList.remove('open')
                    loupeParent.classList.add('d-none')
                    salesPlatform.classList.add('d-none')
                    loupeParent.classList.add('d-none')
                    body.classList.add('open');
                }
                $('#ticket-form form')[0].reset()
            }

            function searchProperties(searchString){
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
                xhttp.open("GET", "index.php/search-properties?searchString="+searchString);
                xhttp.send();
            }

            if(width > mobileWidth){
                salesPlatform.classList.remove('open')
            }


            /**
             * Show Ajax Error Message
             * @param response
             */
            function showAjaxErrorMessage(response, form = false)
            {
                const responseJson = JSON.parse(response.responseText);
                const errors = responseJson.errors;

                if (errors !== undefined) {
                    Object.keys(errors).forEach(function (item) {
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
            function successMessage(message, title)
            {
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
            function errorMessage(message, title)
            {
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
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                });
            });

        </script>
    </body>
</html>
