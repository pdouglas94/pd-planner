angular.module('pdPlannerApp')
	.controller('ToDoModalCtrl', ['$scope', 'item', 'db', '$modalInstance', function($scope, item, db, $modalInstance) {
		if (item !== null) {
			$scope.item = item;
			$scope.updating = true;
		}
		else {
			$scope.item = new db.Item;
			$scope.updating = false;
		}
					
		$scope.packageItem = function() {
			$scope.item.changed = $scope.updating;
			$modalInstance.close($scope.item);
		};
		
		$scope.cancel = function() {
			$modalInstance.dismiss(null);
		};
	}]);



