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
	
	$scope.setActiveCat = function($index) {
		$scope.activeCategory = $scope.categories[$index];
	};
	
	var addCategory = function(add_cat) {
		add_cat.user_id = Session.userId;

		add_cat.save().then(function(reply) {
			reply.list = [];
			$scope.categories.push(reply);
		}, function(reply) {
			alert("Something went wrong with saving your new category: " + reply);
		});
	};
	
	var updateCategory = function(cat) {
		if (cat) {
			db.Category.find(cat.id).then(function(reply) {
				var update_cat = reply;
				update_cat.fromJSON(cat);
				update_cat.user_id = cat.userId;
				update_cat.save().then(function(reply) {
					alert("Category was updated succesfully: " + reply.name);
				}, function(reply){
					alert("Item was not updated successfully: " + reply);
				});
			}, function(reply) {
				alert("Error: " + reply);
			});
		}
	};
	
	$scope.removeCategory = function($index) {
		
		if (!confirm('Are you sure you want to delete this item?')) {
			return;
		}
		var remove = $scope.categories.splice($index, 1);
		var remove_cat = remove[0];
		
		var rem = new db.Category;
		rem.fromJSON(remove_cat);
		
		$scope.activeCategory = {name:null, list:null};
		
		rem.remove(function (reply) {
			alert("Item was successfully removed: " + reply.name);
		}, function(reply) {
			alert("Item was not removed: " + reply);
		});
	};
	
	var addToDoItem = function(todo_item) {
		if ($scope.activeCategory.list !== null){
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
	
	var updateToDoItem = function(todo_item) {
		if (todo_item !== null) {
			db.Item.find(todo_item.id).then(function(reply) {
				var update_item = reply;
				update_item.fromJSON(todo_item);
				update_item.category_id = todo_item.categoryId;
				if (update_item.progress === null) {
					update_item.progress = 0;
				}
				update_item.save().then(function(reply) {
					
				}, function(reply){
					alert("Item was not updated successfully: " + reply);
				});
			}, function(reply) {
				alert("Error: " + reply);
			});
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
	
	$scope.$watch('activeCategory.list', function(newVal, oldVal) {
		if (newVal !== null && oldVal !== null) {
			for (var i in newVal) {
				if (itemCompare(newVal[i], oldVal[i]) === false) {
					updateToDoItem(newVal[i]);
				}
			}
		}
	}, true);
	
	var itemCompare = function(first_item, second_item) {
		if ((first_item.name !== second_item.name) ||
			(first_item.description !== second_item.description) ||
			(first_item.priority !== second_item.priority) ||
			(first_item.progress !== second_item.progress) || 
			(first_item.complete !== second_item.complete)) {
			return false;
		}
		return true;
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
	
	$scope.openToDoModal = function($index) {
		if ($index !== null) {
			var current_item = $scope.activeCategory.list[$index];
		}
		else {
			var current_item = null;
		}
		
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/todo.html',
			controller: 'ToDoModalCtrl',
			size: 'sm',
			resolve: {
				item: function() {
					return current_item;
				}
			}
		});

		modalInstance.result.then(function (newItem) {
			if (newItem.update) {
				updateToDoItem(newItem);
			}
			else {
				addToDoItem(newItem);
			}
		}, function (cancel) {
			
		});
	};
	
	$scope.openCategoryModal = function($index) {
		if ($index !== null) {
			var current_cat = $scope.categories[$index];
		}
		else {
			var current_cat = null;
		}
		
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/category.html',
			controller: 'CategoryModalCtrl',
			size: 'sm',
			resolve: {
				category: function() {
					return current_cat;
				}
			}
		});
		
		modalInstance.result.then(function (newCat) {
			if (newCat.update) {
				updateCategory(newCat);
			}
			else {
				addCategory(newCat);
			}
		}, function (cancel) {
			
		});
	};
  }]);

