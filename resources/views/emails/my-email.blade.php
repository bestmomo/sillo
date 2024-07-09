<!DOCTYPE html>
<html>

<head>
    <title>{{ $sujet }}</title>
</head>

<body>
    <h2>Hello Wold, <b>{{ $name }}</b>!</h2>
    <hr>
    The current time is {{ time() }} seconds since 01/01/1970.<br>
    The complete current date is <b>{{ date('Y-m-d H:i:s', time()) }}</b>.
    <hr>

    <p>{{ $contenu }}</p>
</body>

</html>
