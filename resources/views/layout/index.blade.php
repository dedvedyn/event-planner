<!doctype html>

<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('APP_NAME')}}</title>
        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div id="app" class="height-100">
            <div class="container height-100">
                <div class="wrapper">
                    <vue-header></vue-header>
                    <router-view></router-view>
                    <div class="push"></div>
                </div>
                <vue-footer></vue-footer>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
