'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ListCtrl
 * @description
 * # PlannerCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('PlannerCtrl', ['Session', 'SITE_URL', '$modal', '$http', '$scope', 'db', 
	function (Session, SITE_URL, $modal, $http, $scope, db) {
	
	$scope.categories = [];
	$scope.activeCategory = {name:null, list:null};
	$scope.dropOpen = false;
	
	$scope.loadInfo = function() {
		var params = {
			user_id: Session.userId
		};
		
		$http.post(SITE_URL + 'rest/categories/get-user-data.json' + '?' + $.param(params)).then(
		function(reply){
			$scope.categories = reply.data.categories;
			for (var i in $scope.categories) {
				var current = $scope.categories[i].id;
				$scope.categories[i].list = reply.data.todos[current];
			}
		}, function(reply) {
			alert("Could not get categories from the database: " + reply);
		});
	};
	
	$scope.$on('user-loaded', function() {
		$scope.$apply(function() {
			$scope.loadInfo();
		});
	});
	
	$scope.setActiveCat = function(index) {
		$scope.activeCategory = $scope.categories[index];
	};
	
	var addCategory = function(addCat) {
		addCat.user_id = Session.userId;

		addCat.save().then(function(reply) {
			reply.list = [];
			$scope.categories.push(reply);
		}, function(reply) {
			alert("Something went wrong with saving your new category: " + reply);
		});
	};
	
	$scope.removeCategory = function($index) {
		
		if (!confirm('Are you sure you want to delete this item?')) {
			return;
		}
		var remove = $scope.categories.splice($index, 1);
		var remove_cat = remove[0];
		
		var rem = new db.Category;
		rem.fromJSON(remove_cat);
		if ($scope.categories[0]) {
			$scope.activeCategory = $scope.categories[0];
		}
		else {
			$scope.activeCategory = {name:null, list:null};
		}
		rem.remove(function (reply) {
			alert("Item was successfully removed: " + reply.name);
		}, function(reply) {
			alert("Item was not removed: " + reply);
		});
	};
	
	var addToDoItem = function(todo_item) {
		if ($scope.activeCategory.list !== null){
			var newItem = todo_item;
			todo_item.complete = 0;
			todo_item.progress = 0;
			todo_item.category_id = $scope.activeCategory.id;
			todo_item.save().then(function(reply) {
				reply.expanded = false;
				$scope.activeCategory.list.push(reply);
			}, function(reply) {
				alert("ToDo Item did not save: " + reply);
			});
		}
		else {
			alert("You must make a category first!");
		}
	};
	
	$scope.removeToDoItem = function($index) {
		
		if (!confirm('Are you sure you want to delete this item?')) {
			return;
		}
		var remove = $scope.activeCategory.list.splice($index, 1);
		var remove_item = remove[0];
		
		var rem = new db.Item;
		rem.fromJSON(remove_item);
		rem.category_id = remove_item.categoryId;
		rem.remove(function (reply) {
			alert("Item was successfully removed: " + reply.name);
		}, function(reply) {
			alert("Item was not removed: " + reply);
		});
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
	
	$scope.openToDoModal = function() {
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/todo.html',
			controller: 'ToDoModalCtrl',
			size: 'sm'
		});

		modalInstance.result.then(function (newItem) {
			addToDoItem(newItem);
		}, function (cancel) {
			
		});
	};
	
	$scope.openCategoryModal = function() {
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/category.html',
			controller: 'CategoryModalCtrl',
			size: 'sm'
		});
		
		modalInstance.result.then(function (newCat) {
			addCategory(newCat);
		}, function (cancel) {
			
		});
	};
  }]);

