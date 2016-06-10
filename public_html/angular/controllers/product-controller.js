app.controller("ProductController", ["$routeParams", "$scope", "$uibModal", "$window", "ProductService", function($routeParams, $scope, $uibModal, $window, ProductService) {
	$scope.deletedProduct = false;
	$scope.product = null;
	$scope.alerts = [];

	$scope.getProduct = function() {
		ProductService.fetch($routeParams.id)
			.then(function(result) {
				if(result.status === 200) {
					if(result.data !== undefined) {
						$scope.product = result.data;
						$scope.deletedProduct = false;
					} else {
						$scope.alerts[0] = {type: "warning", msg: "Product " + $routeParams.id + " has been deleted"};
						$scope.deletedProduct = true;
					}
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	/**
	 * updates a misquote and sends it to the misquote API
	 *
	 * @param misquote the misquote to send
	 * @param validated true if Angular validated the form, false if not
	 **/
	// $scope.updateMisquote = function(misquote, validated) {
	// 	if(validated === true) {
	// 		MisquoteService.update(misquote.misquoteId, misquote)
	// 			.then(function(result) {
	// 				if(result.data.status === 200) {
	// 					$scope.alerts[0] = {type: "success", msg: result.data.message};
	// 				} else {
	// 					$scope.alerts[0] = {type: "danger", msg: result.data.message};
	// 				}
	// 			});
	// 	}
	// };

	/**
	 * deletes a misquote and sends it to the misquote API, if the user confirms deletion
	 *
	 * @param misquoteId the misquote id to delete
	 **/
	// $scope.deleteMisquote = function(misquoteId) {
	// 	// create a modal instance to prompt the user if she/he is sure they want to delete the misquote
	// 	var message = "Do you really want to delete this misquote?";
	//
	// 	var modalHtml = '<div class="modal-body">' + message + '</div><div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';
	//
	// 	var modalInstance = $uibModal.open({
	// 		template: modalHtml,
	// 		controller: ModalInstanceCtrl
	// 	});

	// if the user clicked "yes", delete the misquote
	// 	modalInstance.result.then(function () {
	// 		MisquoteService.destroy(misquoteId)
	// 			.then(function(result) {
	// 				if(result.data.status === 200) {
	// 					$scope.alerts[0] = {type: "success", msg: result.data.message};
	// 					$scope.deletedMisquote = true;
	// 				} else {
	// 					$scope.alerts[0] = {type: "danger", msg: result.data.message};
	// 				}
	// 			})
	// 	});
	// };

	if($scope.product === null) {
		$scope.getProduct();
	}
}]);

// embedded modal instance controller to create deletion prompt
// var ModalInstanceCtrl = function($scope, $uibModalInstance) {
// 	$scope.yes = function() {
// 		$uibModalInstance.close();
// 	};

// 	$scope.no = function() {
// 		$uibModalInstance.dismiss('cancel');
// 	};
// };
