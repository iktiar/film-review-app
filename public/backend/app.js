var filmListApp = angular.module('filmListApp', [
  'ngRoute',
  'filmListAppControllers',
  'ui.bootstrap',
  'ngTagsInput'
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

filmListApp.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                        document.getElementById("photoname").value =  element[0].files[0].name;

                    });

                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);