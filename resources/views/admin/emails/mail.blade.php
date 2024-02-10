<!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME') }}</title>
</head>
<body>
    <p> Hi {{$name}},
    <p>{!! $body !!}</p>
     
    <p>
        Thank you,
        <br>
        Team {{env('APP_NAME')}}    
    </p>
</body>
</html>