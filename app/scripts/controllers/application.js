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
		'$scope', 
		'$routeParams',
		'$state',
		'$q',
		'$http',
		'Session',
		'SITE_URL',
		'AuthService', 
		'USER_ROLES',
		'AUTH_EVENTS',
		'db', 
  function ($rootScope, 
		$scope, 
		$routeParams, 
		$state,
		$q, 
		$http, 
		Session, 
		SITE_URL, 
		AuthService, 
		USER_ROLES, 
		AUTH_EVENTS, 
		db) {
	  	  
	var viewName = $routeParams.viewName ? $routeParams.viewName : '';
	$scope.viewName = 'views/' + viewName + '.html';
	$rootScope.selectedNav = viewName;
	
	$scope.userRoles = USER_ROLES;
	$scope.isAuthorized = AuthService.isAuthorized;
	
	$http.get(SITE_URL + 'rest/index/is-logged-in.json').then(function(reply) {
		if (reply.data.loggedIn == true) {
			var user = reply.data.user;
			Session.create(user.id, user.type);
		}
	}).then(function() {
		if (AuthService.isLoggedIn() == false) {
			$state.go('login');
		} else {
			$rootScope.userPromise = $rootScope.getCurrentUser();
		}
	});
	
	$rootScope.getCurrentUser = function () {
		return db.User.find(Session.userId).then(function(reply) {
			$rootScope.currentUser = reply;
		}, function(reply) {});
	};
	
	$scope.viewUser = function() {
		if (AuthService.isLoggedIn() == true) {
			$state.go('user', {id: Session.id});
		}
	};
  }]);