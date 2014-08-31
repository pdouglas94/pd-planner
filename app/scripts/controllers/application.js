'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ApplicationCtrl
 * @description
 * # ApplicationCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('ApplicationCtrl', [
		'$rootScope', 
		'$timeout', 
		'$scope', 
		'$routeParams',
		'$state',
		'$modal',
		'$q',
		'Session', 
		'AuthService', 
		'USER_ROLES',
		'AUTH_EVENTS',
		'db', 
  function ($rootScope, $timeout, $scope, $routeParams, $state, $modal, $q, Session, AuthService, USER_ROLES, AUTH_EVENTS, db) {
	  	  
	var viewName = $routeParams.viewName ? $routeParams.viewName : '';
	$scope.viewName = 'views/' + viewName + '.html';
	$rootScope.selectedNav = viewName;
	
	$scope.userRoles = USER_ROLES;
	$scope.isAuthorized = AuthService.isAuthorized;
	
	if (AuthService.isAuthenticated() == false) {
		$state.go('login');
	}

	$rootScope.getCurrentUser = function (userId) {
		return db.User.find(userId).then(function(reply) {
			$rootScope.currentUser = reply;
		}, function(reply) {});
	};
	
	$rootScope.userPromise = $rootScope.getCurrentUser();
  }]);