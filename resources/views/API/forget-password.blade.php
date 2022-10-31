<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>@yield('title',__('words.mowater'))</title>
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
</head>
<body>

<div style="margin:40px;">
    Hi {{$details['nickname']}}: {{ $details['name'] }},
    <br>
    <br>
    <br>
    <p>
        Trouble signing in?

        Resetting your password is easy.

        Just copy and follow the instructions. We’ll have you up and running in no time.
    </p>
    {{$details['verification_code']}}
    <br/>
</div>

</body>
</html>
