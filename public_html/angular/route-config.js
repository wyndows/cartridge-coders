// configure our routes
app.config(function($routeProvider, $locationProvider) {
	$routeProvider

	// route for the home page
		.when('/', {
			controller  : 'HomeController',
			templateUrl : 'angular/views/home.php'
		})

		// route for the category page
		.when('/product', {
			controller  : 'productController',
			templateUrl : 'angular/views/product.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});