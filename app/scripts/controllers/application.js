'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ApplicationCtrl
 * @description
 * # ApplicationCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('ApplicationCtrl', ['$rootScope', '$scope', '$routeParams', 'AuthService', 'USER_ROLES', 'db', 
  function ($rootScope, $scope, $routeParams, AuthService, USER_ROLES, db) {
		  
	var viewName = $routeParams.viewName ? $routeParams.viewName : '';
	$scope.viewName = 'views/' + viewName + '.html';
	$rootScope.selectedNav = viewName;
	
	$rootScope.currentUser = null;
//	$scope.userRoles = USER_ROLES;
//	$scope.isAuthorized = AuthService.isAuthorized;

	$scope.getUser = function() {
		db.User.find(3).then(function(reply) {
			$rootScope.currentUser = reply;
		}, function (reply) {
			console.log("Failed: ", reply);
		});
	};
	
	$scope.getUser();
  }]);


