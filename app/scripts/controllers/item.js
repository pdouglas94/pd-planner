'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ItemCtrl
 * @description
 * # ItemCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('ItemCtrl', ['SITE_URL', '$modal', '$http', '$scope', 'db', 'item',
	function (SITE_URL, $modal, $http, $scope, db, item) {
		console.log('item controller');
		$scope.item = item;
		$scope.hello = 'HELLO, YOU ARE AT THE: ';
	}]);