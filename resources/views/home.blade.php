<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> Flower Store </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        
        <style>
            html, body {
                margin: 0;
                padding: 0;
                background: #ffe6ee;
            }
        </style>

    </head> 
    <body>
        <div id="app">
            <home></home>
        </div>
    </body>

    <script src="{{ mix('js/app.js') }}"></script>
</html>
