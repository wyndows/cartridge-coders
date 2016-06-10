app.controller("HomeController", ["$location", "$scope", "ProductService", "ImageService", function($location, $scope, ProductService, ImageService) {
	// $scope.collapseAddForm = true;
	$scope.products = [];
	$scope.images = {};
	// var i, len, keys;

	// $scope.newProduct = {productId: null, attribution: "", misquote: "", submitter: ""};
	// $scope.alerts = [];

	/**
	 * creates a misquote and sends it to the misquote API
	 *
	 * @param misquote the misquote to send
	 * @param validated true if Angular validated the form, false if not
	 **/
	// $scope.createMisquote = function(misquote, validated) {
	// 	if(validated === true) {
	// 		MisquoteService.create(misquote)
	// 			.then(function(result) {
	// 				if(result.data.status === 200) {
	// 					$scope.alerts[0] = {type: "success", msg: result.data.message};
	// 					$scope.newMisquote = {misquoteId: null, attribution: "", misquote: "", submitter: ""};
	// 					$scope.addMisquoteForm.$setPristine();
	// 					$scope.addMisquoteForm.$setUntouched();
	// 				} else {
	// 					$scope.alerts[0] = {type: "danger", msg: result.data.message};
	// 				}
	// 			});
	// 	}
	// };

	/**
	 * fulfills the promise from retrieving the misquotes from misquote API
	 **/
	$scope.getProducts = function() {
		ProductService.all()
			.then(function(result) {
				if(result.status === 200) {
					if(result.data !== undefined) {
						$scope.products = result.data.data;
						// console.log($scope.products);
						var keys = Object.keys($scope.products);
						var len = keys.length;
						// console.log(len);

						for (var i = 0; i < len; i++) {
							var key = keys[i];
							console.log(i);
							console.log("testing");
							ImageService.fetchByProductImageId($scope.products[i]["productImageId"])
								.then(function(result, key) {
									if(result.status === 200) {
										$scope.images[key] = result.data.data;
										console.log(key);
										console.log("testing2");
										console.log($scope.images);
									} else {
										$scope.alerts[0] = {type: "danger", msg: result.message};
									}
								});

						}
					}  else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			}});
		};
	if($scope.products.length === 0) {
		$scope.products = $scope.getProducts();
	}
	// ImageService.fetchByProductImageId($scope.products[0]["productImageId"])
	// 	.then(function(result) {
	// 		if(result.status === 200) {
	// 			if(result.data !== undefined) {
	// 				$scope.image = result.data.data;
	// 				console.log($scope.image);
	// 			} else {
	// 				$scope.alerts[0] = {type: "danger", msg: result.data.message};
	// 			}
	// 		}});


	// console.log($scope.products[0]["productImageId"]);
		// console.log($scope.products[1]["productImageId"]);
		// console.log($scope.products[2]["productImageId"]);
		// console.log($scope.products[3]["productImageId"]);
		// console.log($scope.products[4]["productImageId"]);


		// fLen = $scope.products.length;
		// console.log(fLen);
		// for(i = 0; i < fLen; i++) {
		// 	ImageService.fetchByProductImageId($scope.products[i]["productImageId"])
		//
			// .then(function(result) {
			// if(result.status === 200) {
			// 	$scope.image = result.data.data;
			// 	console.log(i);
			// 	console.log($scope.image);
			// } else {
			// 	$scope.alerts[0] = {type: "danger", msg: result.message};
			// }
							// });

						// });

			// })};
	// / ------ break apart return JSON data in $accessToken
	//
	// $json = json_decode($accessToken);
	// $accessTokenExtractToken = ($json->access_token);


	// $scope.getImageByProductImageId = function() {
	// 	ImageService.fetchByProductImageId($scope.products[0]["productImageId"])
	// 		.then(function(result) {
	// 			if(result.status === 200) {
	// 				$scope.image = result.data.data;
	// 				console.log($scope.image);
	// 			} else {
	// 				$scope.alerts[0] = {type: "danger", msg: result.message};
	// 			}
	// 		});
	// };

	// // after this need to pull the actual image from the server that matches the name
	// $i

	/**
	 * reroute the page to the specified misquote
	 *
	 * @param misquoteId id of the misquote to load
	 **/
	// $scope.loadProduct = function(productId) {
	// 	$location.path("product/" + productId);
	// };

	// subscribe to the delete channel; this will delete from the misquotes array on demand
	// Pusher.subscribe("misquote", "delete", function(misquote) {
	// 	for(var i = 0; i < $scope.misquotes.length; i++) {
	// 		if($scope.misquotes[i].misquoteId === misquote.misquoteId) {
	// 			$scope.misquotes.splice(i, 1);
	// 			break;
	// 		}
	// 	}
	// });

	// subscribe to the new channel; this will add to the misquotes array on demand
	// Pusher.subscribe("misquote", "new", function(misquote) {
	// 	$scope.misquotes.push(misquote);
	// });

	// subscript to the update channel; this will update the misquotes array on demand
	// Pusher.subscribe("misquote", "update", function(misquote) {
	// 	for(var i = 0; i < $scope.misquotes.length; i++) {
	// 		if($scope.misquotes[i].misquoteId === misquote.misquoteId) {
	// 			$scope.misquotes[i] = misquote;
	// 			break;
	// 		}
	// 	}
	// });

	// when the window is closed/reloaded, gracefully close the channel
	// $scope.$on("$destroy", function () {
	// 	Pusher.unsubscribe("product");
	// });

	// load the array on first view

	// if($scope.image.length === 0) {
	// 	$scope.image = $scope.getImageByProductImageId();
	// }
}]);