<!DOCTYPE html>
<html lang="fa">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $code }} - {{ $message }}</title>
        <link type="text/css" rel="stylesheet" href="{{asset('assets/css/fontawesome/font-awesome.min.css' , true)}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('assets/css/error-pages.css' , true)}}" />
    </head>
    <body>
        <div id="notfound">
            <div class="notfound">
                <div class="notfound-bg">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <h1>{{ $code }}</h1>
                <h3>{{ $message }}</h3>
                <a href="/">بازگشت</a>
            </div>
        </div>
    </body>
</html>
