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
	
	//Converts an 'array of objects' or 'object of arrays of objects' to objects of given type
	//is_object assumes an object with arrays as fields
	var converter = function(to_convert, convert_type, is_object) {
		if (!to_convert || to_convert === null) {
			return false;
		}
		switch(convert_type) {
			case 'item':
				if (is_object) {
					for(var i in to_convert) {
						db.Item.inflateArray(to_convert[i]);
					}
				}
				else {
					db.Item.inflateArray(to_convert);
				}
				return true;
			case 'category':
				if (is_object) {
					for(var i in to_convert) {
						db.Category.inflateArray(to_convert[i]);
					}
				}
				else {
					db.Category.inflateArray(to_convert);
				}
				return true;
		}
		return false;
	};
	
	//On initial loading of page, we gather up the categories for the current user.
	$scope.loadInfo = function() {
		var params = {
			userId: Session.userId
		};
		
		$http.post(SITE_URL + 'rest/categories/get-user-data.json' + '?' + $.param(params)).then(
		function(reply){
			var categories = reply.data.categories;
			var todos = reply.data.todos;
			converter(categories, 'category', false);
			converter(todos, 'item', true);
			$scope.categories = categories;
			for (var i in $scope.categories) {
				var current = $scope.categories[i].id;
				$scope.categories[i].list = todos[current];
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
		add_cat.userId = Session.userId;

		add_cat.save().then(function(reply) {
			reply.list = [];
			$scope.categories.push(reply);
		}, function(reply) {
			alert("Something went wrong with saving your new category: " + reply);
		});
	};
	
	var updateCategory = function(cat) {
		if (cat && cat !== null) {
			cat.save().then(function(reply) {
				alert("Category was updated succesfully: " + reply.name);
			}, function(reply){
				alert("Item was not updated successfully: " + reply);
			});
		}
	};
	
	$scope.removeCategory = function($index) {
		
		if (!confirm('Are you sure you want to delete this item?')) {
			return;
		}
		var remove = $scope.categories.splice($index, 1);
		var remove_cat = remove[0];
		
		$scope.activeCategory = {name:null, list:null};
		
		remove_cat.remove(function (reply) {
			alert("Item was successfully removed: " + reply.name);
		}, function(reply) {
			alert("Item was not removed: " + reply);
		});
	};
	
	var addToDoItem = function(todo_item) {
		if ($scope.activeCategory.list !== null){
			todo_item.complete = 0;
			todo_item.progress = 0;
			todo_item.categoryId = $scope.activeCategory.id;
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
		if (todo_item && todo_item !== null) {
			if (todo_item.progress === null) {
				todo_item.progress = 0;
			}
			todo_item.save().then(function(reply) {
				
			}, function(reply){
				alert("Item was not updated successfully: " + reply);
			});
		}
	};
	
	$scope.removeToDoItem = function($index) {
		if (!confirm('Are you sure you want to delete this item?')) {
			return;
		}
		var remove = $scope.activeCategory.list.splice($index, 1);
		var remove_item = remove[0];
		
		remove_item.remove(function (reply) {
			alert("Item was successfully removed: " + reply.name);
		}, function(reply) {
			alert("Item was not removed: " + reply);
		});
	};
	
	//Watches each item in the current list for changes and saves them.
	$scope.$watch('activeCategory.list', function(newVal, oldVal) {
		if (newVal !== null && oldVal !== null) {
			for (var i in newVal) {
				if (oldVal[i] && itemDynamicCompare(newVal[i], oldVal[i]) === false) {
					updateToDoItem(newVal[i]);
				}
			}
		}
	}, true);
	
	//This only compares the values that can be updated in real time without opening the modal.
	var itemDynamicCompare = function(first_item, second_item) {		
		if ((first_item.progress !== second_item.progress) || 
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
			if (newItem.updated === true) {
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
			if (newCat.updated === true) {
				updateCategory(newCat);
			}
			else {
				addCategory(newCat);
			}
		}, function (cancel) {
			
		});
	};
  }]);

