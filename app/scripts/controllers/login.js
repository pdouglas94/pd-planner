'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('LoginCtrl', ['$rootScope', '$scope', '$state', '$modal', 'AUTH_EVENTS', 'AuthService', 
	function ($rootScope, $scope, $state, $modal, AUTH_EVENTS, AuthService) {
	
	$scope.loginModal = function(addAlerts) {
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/login.html',
			controller: 'LoginModalCtrl',
			size: 'sm',
			resolve: {
				alerts: function() {
					if (addAlerts) {
						return addAlerts;
					} else {
						return null;
					}
				}
			}
		});

		return modalInstance.result;
	};
	
	$scope.$on(AUTH_EVENTS.loginSuccess, function() {
		$rootScope.userPromise = $rootScope.getCurrentUser();
	});
	
	$scope.login = function(messages) {
		$scope.loginModal(messages).then(function (credentials) {
			if (credentials && credentials.username && credentials.password) {
				var issues = {};
				AuthService.login(credentials, issues).then(function () {
					if (AuthService.isLoggedIn() == true) {
						$scope.$emit(AUTH_EVENTS.loginSuccess);
						$state.go('planner');
					} else {
						$scope.login(issues);
					}
				});
			}
		}, function (cancel) {
			if (cancel === 'newUser') {
				$scope.createNewUser();
			}
		});
	};
	
	$scope.createNewUser = function() {
		console.log('new user');
	};
	
	$scope.newUserModal = function() {
		return;
	};
	
	if (AuthService.isLoggedIn() == true) {
		$state.go('home');
	} else {
		$scope.login();
	}
  }]);