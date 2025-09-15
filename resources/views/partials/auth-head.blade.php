<title>{{ $title ?? 'Escuela' }} | {{ config('app.name', 'Laravel') }}</title>
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Favicon icon -->
<link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet">
<!-- Flux UI Styles -->
@fluxStyles
<!-- Vite CSS -->
@vite('resources/css/app.css')
