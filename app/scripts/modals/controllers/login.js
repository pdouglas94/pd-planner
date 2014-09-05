angular.module('pdPlannerApp')
	.controller('LoginModalCtrl', ['$scope', 'db', '$modalInstance', 'alerts', function($scope, db, $modalInstance, alerts) {
		$scope.credentials = {};
	
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
		
		$scope.createNewUser = function() {
			$modalInstance.dismiss('newUser');
		};
	
		$scope.login = function() {
			if ($scope.credentials.username && $scope.credentials.password) {
				$modalInstance.close($scope.credentials);
			} else {
				addAlert('You must fill in both fields.', 'warning')
			}
		};
		
	}]);
