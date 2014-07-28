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
	$scope.newItem = new db.Item;
	
	$scope.loadInfo = function() {
		//This needs to be fixed to indicate current user id
		var params = {
			user_id: 3
		};
		
		$http.post(SITE_URL + 'rest/categories/get-user-data.json' + '?' + $.param(params)).then(
		function(reply){
			$scope.categories = reply.data.categories;
			for (var i in $scope.categories) {
				var current = $scope.categories[i].id;
				$scope.categories[i].list = reply.data.todos[current];
			}
		}, function(reply) {
			console.log(reply);
		});
	};
	
	$scope.loadInfo();
	
	$scope.addCategory = function() {
		$scope.newCategory.name = $scope.addCat;
		$scope.newCategory.user_id = $scope.currentUser.id;

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
			$scope.newItem.name = $scope.addItem;
			$scope.newItem.description = $scope.addDesc;
			$scope.newItem.priority = $scope.addPrior;
			$scope.newItem.complete = 0;
			$scope.newItem.progress = 0;
			$scope.newItem.category_id = $scope.activeCategory.id;
			$scope.newItem.save().then(function(reply) {
				console.log(reply);
			}, function(reply) {
				console.log(reply);
			});
			$scope.newItem.complete = false;
			$scope.newItem.expanded = false;
			$scope.activeCategory.list.push($scope.newItem);
			$scope.addItem = '';
			$scope.addDesc = '';
			$scope.addPrior = '';
			$scope.newItem = new db.Item;
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
		switch ($scope.activeCategory.list[$index].priority) {
			case 1:
				return "High";
			case 2:
				return "Medium";
			case 3:
				return "Low";
		}
		return "None";
	};
  }]);

