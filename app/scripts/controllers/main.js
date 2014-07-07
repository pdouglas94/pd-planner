'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('MainCtrl', ['$rootScope', '$scope', '$routeParams', function ($rootScope, $scope, $routeParams) {

	var viewName = $routeParams.viewName ? $routeParams.viewName : '';
	$scope.viewName = 'views/' + viewName + '.html';
	$rootScope.selectedNav = viewName;
	
  }]);
