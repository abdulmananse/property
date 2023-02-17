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
								<table style="width: 80%; margin: auto;">
												<thead>
																<tr class="text-center border-2">
																				<th class="border-4">Sr#</th>
																				<th class="border-4">Datetime</th>
																				<th class="border-4">Type</th>
																				<th class="border-4">Team</th>
																				<th class="border-4">Message</th>
																				<th class="border-4">Destination</th>
																				<th class="border-4">Property</th>
																</tr>
												</thead>
												<tbody>
																@foreach ($errorLogs as $key => $errorLog)
																				<tr class="text-left border-2">
																								<td class="border-4">{{ $key + 1 }}</td>
																								<td class="border-4">{{ date('d M, Y H:i A', strtotime($errorLog->created_at)) }}</td>
																								<td class="border-4" style="text-align: center;">
																												@if ($errorLog->error_type)
																																@if ($errorLog->error_type === 'warning')
																																				<img src="{{ asset('img/warning.png') }}" width="40" />
																																@else
																																				<img src="{{ asset('img/error.png') }}" width="50" />
																																@endif
																												@endif
																								</td>
																								<td class="border-4">
																												@if ($errorLog->error_category)
																																{{ $errorLog->error_category }}
																												@endif
																								</td>
																								<?php
																								[$message, $error] = explode('{ErrorMessage}', $errorLog->message);
																								$error = isset($error) ? json_decode($error, true) : '';
																								?>
																								<td class="border-4" style="word-wrap: break-word;">
																												{{ $message }}
																												<hr />
																												<?php echo '<pre>' . htmlentities($error) . '</pre>'; ?>
																								</td>
																								<td class="border-4">
																												@if ($errorLog->destination_name)
																																{{ $errorLog->destination_name }}
																												@endif
																								</td>
																								<td class="border-4">
																												@if ($errorLog->pis_link)
																																<a href="https://docs.google.com/spreadsheets/d/{{ $errorLog->pis_link }}"
																																				target="_blank">Click to Open PIS</a>
																												@endif
																								</td>
																				</tr>
																@endForeach
												</tbody>
												<table>
				</section>
</body>

</html>
