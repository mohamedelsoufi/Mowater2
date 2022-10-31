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
    Thank you for creating an account with us. Don't forget to complete your registration!
    <br>
    <br>
    <br>
    Please click on the link below or copy it into the address bar of your browser to confirm your email address:
    <br>
    <br>
    <br>

    <a href="{{ route('user.verify', $details['verification_code'])}}">Confirm my email address </a>

    <br/>
</div>

</body>
</html>
