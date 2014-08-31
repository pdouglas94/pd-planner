angular.module('pdPlannerApp')
	.controller('LoginModalCtrl', ['$scope', 'db', '$modalInstance', function($scope, db, $modalInstance) {
		$scope.credentials = {};
	
		$scope.login = function() {
			$modalInstance.close($scope.credentials);
		};
		
		$scope.cancel = function() {
			$modalInstance.dismiss(null);
		};
	}]);
