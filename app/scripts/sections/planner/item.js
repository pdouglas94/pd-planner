'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:ItemCtrl
 * @description
 * # ItemCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('ItemCtrl', ['SITE_URL', '$state', '$modal', '$http', '$scope', 'db', 'item',
	function (SITE_URL, $state, $modal, $http, $scope, db, item) {
		$scope.item = item;
		$scope.subitems = null;
		
		db.Subitem.findAll({itemId: item.id}).then(function(reply) {
			$scope.subitems = reply;
		}, function(reply) {
			
		});
		
		$scope.priorities = {
			1: 'High',
			2: 'Medium',
			3: 'Low'
		};
		
		$scope.$watchCollection('item', function(newVal, oldVal) {
			if (newVal && (newVal.progress !== oldVal.progress || newVal.complete !== oldVal.complete)) {
				updateToDoItem(newVal);
			}
		});
		
		$scope.removeToDoItem = function() {
			if (!confirm('Are you sure you want to delete this item?')) {
				return;
			}

			$scope.item.remove(function (reply) {
				$state.go('planner.overview');
				//addAlert("Item was successfully removed: " + reply.name, 'success');
			}, function(reply) {
				//addAlert("Item was not removed: " + reply, 'warning');
			});
		};
		
		var updateToDoItem = function(todo_item) {
			if (todo_item && todo_item !== null) {
				if (todo_item.progress === null) {
					todo_item.progress = 0;
				}
				todo_item.save().then(function(reply) {

				}, function(reply){
					//addAlert("Item was not updated successfully: " + reply, 'warning');
				});
			}
		};
		
		$scope.openToDoModal = function() {

			var modalInstance = $modal.open({
				templateUrl: 'scripts/modals/overlays/todo.html',
				controller: 'ToDoModalCtrl',
				size: 'sm',
				resolve: {
					item: function() {
						return $scope.item;
					}
				}
			});

			modalInstance.result.then(function (newItem) {
				if (newItem.changed === true) {
					updateToDoItem(newItem);
					//addAlert("Item was updated succesfully: " + reply.name, 'success');
				}
			}, function (cancel) {

			});
		};
		
		$scope.openSubitemModal = function() {
			return null;
		};
	}]);