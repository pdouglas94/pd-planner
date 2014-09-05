angular.module('pdPlannerApp')
	.controller('NewUserModalCtrl', ['$scope', '$modalInstance', 'alerts', function($scope, $modalInstance, alerts) {
		$scope.newUser = {};
				
		if (alerts) {
			$scope.alerts = alerts.messages;
		} else {
			$scope.alerts = [];
		}
		
		var addAlert = function(add_message, add_type) {
			if ($scope.alerts.length > 0) {
				$scope.alerts.splice(0,1);
			}
			$scope.alerts.push({message: add_message, type: add_type});
		};

		$scope.closeAlert = function($index) {
			$scope.alerts.splice($index, 1);
		};
		
		$scope.saveNewUser = function() {
			if ($scope.newUser.username && $scope.newUser.password && $scope.newUser.password2) {
				$modalInstance.close($scope.newUser);
			} else {
				addAlert('You must fill in all fields.', 'warning')
			}
		};
}]);