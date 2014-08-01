angular.module('pdPlannerApp')
	.controller('ToDoModalCtrl', ['$scope', 'db', '$modalInstance', function($scope, db, $modalInstance) {
		$scope.newItem = new db.Item;
					
		$scope.packageItem = function() {
			$modalInstance.close($scope.newItem);
		};
		
		$scope.cancel = function() {
			$modalInstance.dismiss(null);
		};
	}]);



