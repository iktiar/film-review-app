var filmListApp = angular.module('filmListApp', [
  'ngRoute',
  'filmListAppControllers'
]);

filmListApp.config(['$routeProvider', function($routeProvider) {
    
    $routeProvider.
    when('/login', {
        templateUrl: 'backend/partials/login.html',
        controller: 'LoginController'
    }).
    when('/signup', {
        templateUrl: 'backend/partials/signup.html',
        controller: 'SignupController'
    }).
    when('/', {
        templateUrl: 'backend/partials/index.html',
        controller: 'MainController'
    }).
    otherwise({
        redirectTo: '/'
    });

}]);