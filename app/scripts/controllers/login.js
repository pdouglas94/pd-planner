'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('LoginCtrl', ['$rootScope', '$scope', 'AUTH_EVENTS', 'AuthService', function ($rootScope, $scope, AUTH_EVENTS, AuthService) {

	$scope.credentials = {
		username: '',
		password: ''
	};
	
	$scope.login = function (credentials) {
		AuthService.login(credentials).then(function () {
			$rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
		}, function () {
			$rootScope.$broadcast(AUTH_EVENTS.loginFailed);
		});
	};
  }]);