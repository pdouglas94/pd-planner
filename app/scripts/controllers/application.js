'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ApplicationCtrl
 * @description
 * # ApplicationCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('ApplicationCtrl', ['$rootScope', '$scope', '$routeParams', 'AuthService', 'USER_ROLES', 
  function ($rootScope, $scope, $routeParams, AuthService, USER_ROLES) {
		  
	var viewName = $routeParams.viewName ? $routeParams.viewName : '';
	$scope.viewName = 'views/' + viewName + '.html';
	$rootScope.selectedNav = viewName;
	
	$scope.currentUser = null;
	$scope.userRoles = USER_ROLES;
	$scope.isAuthorized = AuthService.isAuthorized;
	
  }]);


