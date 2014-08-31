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
		  
	$scope.loginModal = function() {
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/login.html',
			controller: 'LoginModalCtrl',
			size: 'sm'
		});

		return modalInstance.result;
	};
	
	$scope.$on(AUTH_EVENTS.loginSuccess, function() {
		$rootScope.userPromise = $rootScope.getCurrentUser();
	});
	
	$scope.login = function() {
		$scope.loginModal().then(function (credentials) {
			if (credentials && credentials.username && credentials.password) {
				AuthService.login(credentials).then(function () {
					if (AuthService.isAuthenticated() == true) {
						$scope.$emit(AUTH_EVENTS.loginSuccess);
						$state.go('planner');
					} else {
						$scope.login();
					}
				});
			}
		}, function (cancel) {
			$scope.login();
		});
	};
	
	$scope.login();
  }]);