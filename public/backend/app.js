var filmListApp = angular.module('filmListApp', [
  'ngRoute',
  'filmListAppControllers',
  'ui.bootstrap',
  '720kb.datepicker'
]);

filmListApp.config(['$routeProvider', function($routeProvider) {
    
    $routeProvider.
    when('/login', {
        templateUrl: 'backend/partials/login.html',
        controller: 'LoginController'
    }).
    when('/registration', {
        templateUrl: 'backend/partials/registration.html',
        controller: 'SignupController'
    }).
    when('/films/create', {
        templateUrl: 'backend/partials/create.html',
        controller: 'CreateController'
    }).
    when('/', {
        templateUrl: 'backend/partials/index.html',
        controller: 'MainController'
    }).
    otherwise({
        redirectTo: '/'
    });

}]);