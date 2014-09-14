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
		$scope.item = item;
		$scope.subitems = null;
		
		db.Subitem.findAll({itemId: item.id}).then(function(reply) {
			$scope.subitems = reply;
		}, function(reply) {
			
		});
	}]);