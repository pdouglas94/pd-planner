'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ListCtrl
 * @description
 * # PlannerCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('PlannerCtrl', ['SITE_URL', '$scope', 'db', function (SITE_URL, $scope, db) {
		  
	$scope.categories = [];
	$scope.activeCategory = {name:null, list:null};
	
	$scope.toDoExpand = false;
	$scope.catExpand = false;
	
	$scope.addCategory = function() {
		//add to database
//		db.Category = {user_id:$scope.currentUser.id, name:$scope.addCat};
//		$http.post(SITE_URL + 'rest/categories.json').success(function(reply){
//			$scope.something = reply;
//		});
//		db.Category.save(function(reply) {
//			console.log(reply);
//		}, function(reply) {
//			console.log(reply);
//		});
		$scope.categories.push({name:$scope.addCat, list:[]});
		$scope.addCat = '';
	};
	
	$scope.removeCategory = function($index) {
		//remove from database
		$scope.categories.splice($index, 1);
	};
	
	$scope.switchToDo = function($index) {
		var value = $scope.activeCategory.list[$index].expanded;
		if (value === true){
			value = false;
		}
		else {
			value = true;
		}
		$scope.activeCategory.list[$index].expanded = value;
	};
	
	$scope.switchExpand = function(value) {
		if ($scope[value]) {
			$scope[value] = false;
		}
		else {
			$scope[value] = true;
		}
	};
	
	$scope.addToDoItem = function() {
		//add to database
		if ($scope.activeCategory.list !== null){
			$scope.activeCategory.list.push({
				todo:$scope.addItem, 
				desc:$scope.addDesc, 
				prior:$scope.addPrior,
				complete:false, 
				expanded:false
			});
			$scope.addItem = '';
			$scope.addDesc = '';
			$scope.addPrior = '';
		}
		else {
			alert("You must make a category first!");
		}
	};
	
	$scope.removeToDoItem = function($index) {
		$scope.activeCategory.list.splice($index, 1);
		//remove from database
	};
	
	$scope.getPriority = function($index) {
		switch ($scope.activeCategory.list[$index].prior) {
			case '1':
				return "High";
			case '2':
				return "Medium";
			case '3':
				return "Low";
		}
		return "None";
	};
  }]);

