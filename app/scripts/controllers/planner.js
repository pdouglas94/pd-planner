'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ListCtrl
 * @description
 * # PlannerCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('PlannerCtrl', function ($scope) {

	//$scope.toDoList = [];
	$scope.categories = [];
	$scope.activeCategory = {name:null, list:null};
	
	$scope.addCategory = function() {
		$scope.categories.push({name:$scope.addCat, list:[]});
	};
	
	$scope.removeCategory = function($index) {
		$scope.categories.splice($index, 1);
	};
	
	$scope.switchExpand = function($index) {
		var value = $scope.activeCategory.list[$index].expanded;
		if (value === true){
			value = false;
		}
		else {
			value = true;
		}
		$scope.activeCategory.list[$index].expanded = value;
	};
	
	$scope.addToDoItem = function() {
		if ($scope.activeCategory.list !== null){
			$scope.activeCategory.list.push({todo:$scope.addItem, complete:false, expanded:false});
		}
		else {
			alert("You must make a category first!");
		}
	};
	
	$scope.removeToDoItem = function($index) {
		$scope.activeCategory.list.splice($index, 1);
	};
  });

