var filmListAppControllers = angular.module('filmListAppControllers', ['bookWishlistAppServices']);

filmListAppControllers.controller('LoginController', ['$scope', '$http', '$location', 'userService', function ($scope, $http, $location, userService) {

    $scope.login = function() {
        userService.login(
            $scope.email, $scope.password,
            function(response){
                $location.path('/');
            },
            function(response){
                alert('Something went wrong with the login process. Try again later!');
            }
        );
    }

    $scope.email = '';
    $scope.password = '';

    if(userService.checkIfLoggedIn())
        $location.path('/');

}]);

filmListAppControllers.controller('SignupController', ['$scope', '$location', 'userService', function ($scope, $location, userService,) {

	$scope.signup = function() {
        userService.signup(
            $scope.name, $scope.email, $scope.password,
            function(response){
                alert('Great! You are now signed in! Welcome, ' + $scope.name + '!');
                $location.path('/');
            },
            function(response){
                alert('Something went wrong with the signup process. Try again later.');
            }
        );
    }

    $scope.name = '';
    $scope.email = '';
    $scope.password = '';

    if(userService.checkIfLoggedIn())
        $location.path('/');

}]);

filmListAppControllers.controller('MainController', ['$scope', '$location', 'userService', 'bookService', function ($scope, $location, userService, bookService) {

    $scope.logout = function(){
        userService.logout();
        $location.path('/login');
    }

    $scope.refresh = function(){

        bookService.getAll(function(response){
            
          $scope.films = response;
          /*for pagination*/
          $scope.viewby = 1;
		  $scope.totalItems = $scope.films.length;
		  console.log($scope.totalItems);
		  $scope.currentPage = 1;
		  $scope.itemsPerPage = $scope.viewby;
		  $scope.maxSize = 3; //Number of pager buttons to show

		  $scope.setPage = function (pageNo) {
		    $scope.currentPage = pageNo;
		  };

		  $scope.pageChanged = function() {
		    console.log('Page changed to: ' + $scope.currentPage);
		  };

			$scope.setItemsPerPage = function(num) {
			  $scope.itemsPerPage = num;
			  $scope.currentPage = 1; //reset to first page
			}
          /*End*/ 

         

        
        }, function(){
            
            alert('Some errors occurred while communicating with the service. Try again later.');
        
        });

    }
    /*
    if(!userService.checkIfLoggedIn())
        $location.path('/login');
     */   

    $scope.films = [];

    $scope.refresh();

}]);