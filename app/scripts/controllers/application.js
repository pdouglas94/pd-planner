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
		'Session', 
		'AuthService', 
		'USER_ROLES', 
		'db', 
  function ($rootScope, $timeout, $scope, $routeParams, Session, AuthService, USER_ROLES, db) {
		  
	var viewName = $routeParams.viewName ? $routeParams.viewName : '';
	$scope.viewName = 'views/' + viewName + '.html';
	$rootScope.selectedNav = viewName;
	
	$rootScope.currentUser = null;
	$scope.userRoles = USER_ROLES;
//	$scope.isAuthorized = AuthService.isAuthorized;

	$scope.getUser = function() {
		db.User.find(3).then(function(reply) {
			$rootScope.currentUser = reply;
			Session.create(1, $rootScope.currentUser.id, USER_ROLES.all);
			$timeout(function() {
				$rootScope.$broadcast('user-loaded');
			}, 100);
		}, function (reply) {
			console.log("Failed: ", reply);
		});
	};
	
	$scope.getUser();
  }]);


