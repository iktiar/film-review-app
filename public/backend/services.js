var bookWishlistAppServices = angular.module('bookWishlistAppServices', [
	'LocalStorageModule',
	'restangular'
]);

bookWishlistAppServices.factory('userService', ['$http', 'localStorageService', function($http, localStorageService) {

	function checkIfLoggedIn() {

		if(localStorageService.get('token'))
			return true;
		else
			return false;

	}

	function signup(name, email, password, onSuccess, onError) {

		$http.post('/api/auth/signup', 
		{
			name: name,
			email: email,
			password: password
		}).
		then(function(response) {

			localStorageService.set('token', response.data.token);
			onSuccess(response);

		}, function(response) {

			onError(response);

		});

	}

	function login(email, password, onSuccess, onError){

		$http.post('/api/v1/login', 
		{
			email: email,
			password: password
		}).
		then(function(response) {
            if(response.data.status =='error')
            {   console.log('invalide');

            	onError(response);
            }
			if(response.data.status =='success'){
				localStorageService.set('token', response.data.data.api_token);
                onSuccess(response);
			}
		}, function(response) {

		});

	}

	function logout(){
        $http.get('/api/v1/logout/'+getCurrentToken()).
		then(function(response) {
            if(response.data.status =='error')
            {   console.log('logout error');

            	onError(response);
            }
			if(response.data.status =='success'){
				console.log('logout ok');
				localStorageService.remove('token');
                onSuccess(response);
			}
		}, function(response) {

		});
		

	}

	function getCurrentToken(){
		return localStorageService.get('token');
	}

	return {
		checkIfLoggedIn: checkIfLoggedIn,
		signup: signup,
		login: login,
		logout: logout,
		getCurrentToken: getCurrentToken
	}

}]);

bookWishlistAppServices.factory('bookService', ['Restangular', 'userService', function(Restangular, userService) {

	function getAll(onSuccess, onError){
		Restangular.all('api/films').getList().then(function(response){
           onSuccess(response);
		
		}, function(){

			onError(response);

		});
	}

	function getById(bookId, onSuccess, onError){

		Restangular.one('api/films', bookId).get().then(function(response){

			onSuccess(response);

		}, function(response){

			onError(response);

		});

	}

	function create(data, onSuccess, onError){

		Restangular.all('api/films').post(data).then(function(response){

			onSuccess(response);
		
		}, function(response){
			
			onError(response);
		
		});

	}

	function update(bookId, data, onSuccess, onError){

		Restangular.one("api/films").customPUT(data, bookId).then(function(response) {
				
				onSuccess(response);

			}, function(response){
				
				onError(response);
			
			}
		);

	}

	function remove(bookId, onSuccess, onError){
		Restangular.one('api/films/', bookId).remove().then(function(){

			onSuccess();

		}, function(response){

			onError(response);

		});
	}

	Restangular.setDefaultHeaders({ 'Authorization' : 'Bearer ' + userService.getCurrentToken() });

	return {
		getAll: getAll,
		getById: getById,
		create: create,
		update: update,
		remove: remove
	}

}]);