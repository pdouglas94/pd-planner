'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:OverviewCtrl
 * @description
 * # OverviewCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('OverviewCtrl', ['Session', 'AuthService', 'SITE_URL', '$modal', '$http', '$scope', 'db', '$state',
	function (Session, AuthService, SITE_URL, $modal, $http, $scope, db, $state) {
	
	$scope.categories = [];
	$scope.activeCategory = {name:null, list:null};
	$scope.dropOpen = false;
	$scope.alerts = [];
	
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
			case 'subitem':
				if (is_object) {
					for (var i in to_convert) {
						db.Subitem.inflateArray(to_convert[i]);
					}
				}
				else {
					db.Subitem.inflateArray(to_convert);
				}
				return true;
		}
		return false;
	};
	
	var addAlert = function(add_message, add_type) {
		if ($scope.alerts.length > 0) {
			$scope.alerts.splice(0,1);
		}
		$scope.alerts.push({message: add_message, type: add_type});
	};
	
	$scope.closeAlert = function($index) {
		$scope.alerts.splice($index, 1);
	};
	
	//On initial loading of page, we gather up the categories for the current user.
	$scope.loadInfo = function() {
		var params = {
			userId: Session.userId
		};
		
		db.Category.findAll(params).then(function(reply) {
			$scope.categories = reply;
		}, function(reply) {
			addAlert("Could not retrieve your information: " + reply, 'danger');
		});
	};
	
	if (AuthService.isLoggedIn()) {
		$scope.loadInfo();
	} else {
		$scope.$watch('userPromise', function(newVal, oldVal) {
			if (newVal) {
				$scope.userPromise.then(function() {
					$scope.loadInfo();
				});
			}
		});
	}
	
	$scope.setActiveCat = function($index) {
		$scope.activeCategory = $scope.categories[$index];
		if (!$scope.activeCategory.list) {
			db.Item.findAll({ categoryId: $scope.activeCategory.id }).then(function(reply) {
				$scope.activeCategory.list = reply;
			}, function(reply) {
				addAlert("Could not fetch your todo list for this category: " + reply, 'danger');
			});
		}
	};
	
	var addCategory = function(add_cat) {
		add_cat.userId = Session.userId;
		add_cat.save().then(function(reply) {
			reply.list = [];
			$scope.categories.push(reply);
			$scope.activeCategory = reply;
			addAlert("Category added successfully: " + reply.name, 'success');
		}, function(reply) {
			addAlert("Something went wrong with saving your new category: " + reply, 'warning');
		});
	};
	
	var updateCategory = function(cat) {
		if (cat && cat !== null) {
			cat.save().then(function(reply) {
				addAlert("Category was updated succesfully: " + reply.name, 'success');
			}, function(reply){
				addAlert("Category was not updated successfully: " + reply, 'warning');
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
			addAlert("Item was successfully removed: " + reply.name, 'success');
		}, function(reply) {
			addAlert("Item was not removed: " + reply, 'warning');
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
				addAlert("Item saved successfully: " + reply.name, 'success');
			}, function(reply) {
				addAlert("Item did not save: " + reply, 'warning');
			});
		}
		else {
			if ($scope.categories.length < 1) {
				addAlert("You must make a category first!", 'warning');
			}
			else {
				addAlert("You must make select a category first!", 'warning');
			}
		}
	};
	
	var updateToDoItem = function(todo_item) {
		if (todo_item && todo_item !== null) {
			if (todo_item.progress === null) {
				todo_item.progress = 0;
			}
			todo_item.save().then(function(reply) {
				
			}, function(reply){
				addAlert("Item was not updated successfully: " + reply, 'warning');
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
			addAlert("Item was successfully removed: " + reply.name, 'success');
		}, function(reply) {
			addAlert("Item was not removed: " + reply, 'warning');
		});
	};
	
	//Watches each item in the current list for changes and saves them.
	$scope.$watch('activeCategory.list', function(newVal, oldVal) {
		if (newVal && oldVal) {
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
	
	$scope.priorities = {
		1: 'High',
		2: 'Medium',
		3: 'Low'
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
			if (newItem.changed === true) {
				updateToDoItem(newItem);
				addAlert("Item was updated succesfully: " + reply.name, 'success');
			}
			else {
				addToDoItem(newItem);
			}
		}, function (cancel) {
			
		});
	};
	
	$scope.goItem = function($index) {
		var item = $scope.activeCategory.list[$index];
		if (item && item.id) {
			$state.go('planner.item', {item_id: item.id});
		}
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
			if (newCat.changed === true) {
				updateCategory(newCat);
			}
			else {
				addCategory(newCat);
			}
		}, function (cancel) {
			
		});
	};
  }]);