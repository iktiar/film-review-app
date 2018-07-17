<!DOCTYPE html>
<html lang="en" ng-app="filmListApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Film Application</title>

        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="bower_components/angular/angular.min.js"></script>
        <script src="bower_components/lodash/dist/lodash.min.js"></script>
        <script src="bower_components/angular-route/angular-route.min.js"></script>
        <script src="bower_components/angular-local-storage/dist/angular-local-storage.min.js"></script>
        <script src="bower_components/restangular/dist/restangular.min.js"></script>
        <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.js"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        
        <link href="bower_components/angularjs-datepicker/src/css/angular-datepicker.css" rel="stylesheet" type="text/css" /> 

        <script src="backend/app.js"></script>
        <script src="backend/controllers.js"></script>
        <script src="backend/services.js"></script>
        
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Film Application</h1>
                </div>
            </div>

            <div ng-view></div>
        </div>

        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="bower_components/angularjs-datepicker/src/js/angular-datepicker.js"></script> 
    </body>
</html>