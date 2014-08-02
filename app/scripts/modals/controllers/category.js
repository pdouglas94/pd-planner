angular.module('pdPlannerApp')
	.controller('CategoryModalCtrl', ['$scope', 'db', '$modalInstance', function($scope, db, $modalInstance) {
		$scope.newCategory = new db.Category;
					
		$scope.packageCategory = function() {
			$modalInstance.close($scope.newCategory);
		};
		
		$scope.cancel = function() {
			$modalInstance.dismiss(null);
		};			
	}]);


