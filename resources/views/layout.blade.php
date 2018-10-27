<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Pace Calculator</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Stylesheets -->
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'
          rel='stylesheet'
          integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO'
          crossorigin='anonymous'>
    <link href="/css/styles.css" rel="stylesheet" media="screen">
</head>
<body>
{{-- Note: Couldn't find a nice way to get an asset via css. So just added it here. Its purely aesthetic --}}
<div class="flex-container" style="background: url({{asset('/images/landing-background.jpg')}}); background-size: contain">
    @yield('content')
</div>
</body>
</html>
