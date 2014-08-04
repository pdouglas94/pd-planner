angular.module('pdPlannerApp')
	.controller('CategoryModalCtrl', ['$scope', 'category', 'db', '$modalInstance', function($scope, category, db, $modalInstance) {
		
		if (category !== null) {
			$scope.category = category;
			$scope.updating = true;
		}
		else {
			$scope.category = new db.Category;
			$scope.updating = false;
		}
					
		$scope.packageCategory = function() {
			$scope.category.updated = $scope.updating;
			$modalInstance.close($scope.category);
		};
		
		$scope.cancel = function() {
			$modalInstance.dismiss(null);
		};			
	}]);


