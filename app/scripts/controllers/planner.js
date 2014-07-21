'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ListCtrl
 * @description
 * # PlannerCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('PlannerCtrl', ['$rootScope', 'SITE_URL', '$http', '$scope', 'db', 
	function ($rootScope, SITE_URL, $http, $scope, db) {
		  
	$scope.categories = [];
	$scope.activeCategory = {name:null, list:null};
	
	$scope.toDoExpand = false;
	$scope.catExpand = false;
	
	$scope.newCategory = new db.Category;
	
	$scope.loadInfo = function() {
		$http.post(SITE_URL + 'rest/categories/get-user-categories' + '?' + "user_id=" + 3).then(
		function(reply){
			$scope.categories = reply;
			alert($scope.categories);
		}, function(reply) {
			console.log(reply);
		});
	};
	
	$scope.loadInfo();
	
	$scope.addCategory = function() {
		$scope.newCategory.name = $scope.addCat;
		$scope.newCategory.user_id = $scope.currentUser.id;

		console.log($scope.newCategory);
		$scope.newCategory.save().then(function(reply) {
			console.log(reply);
		}, function(reply) {
			console.log(reply);
		});
		$scope.categories.push({name:$scope.addCat, list:[]});
		$scope.addCat = '';
		$scope.newCategory = new db.Category;
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

