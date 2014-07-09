/* May want to seperate categories/todo items into seperate file like this. */

angular.module('pdPlannerApp.services.categories')
	.service('categories', function () {
		this.categories = [];
		this.activeCategory = {name:null, list:null};
		return {
			addCategory: function (addCat) {
				this.categories.push({name:addCat, list:[]});
				//this.addCat = '';
			},
			removeCategory: function($index) {
				this.categories.splice($index, 1);
			},
			switchExpand: function($index) {
				var value = this.activeCategory.list[$index].expanded;
				if (value === true){
					value = false;
				}
				else {
					value = true;
				}
				this.activeCategory.list[$index].expanded = value;
			},
			addToDoItem: function(addItem, addDesc, addPrior) {
				if (this.activeCategory.list !== null){
					this.activeCategory.list.push({
						todo:addItem, 
						desc:addDesc, 
						prior:addPrior,
						complete:false, 
						expanded:false
					});
					//$scope.addItem = '';
					//$scope.addDesc = '';
					//$scope.addPrior = '';
				}
				else {
					alert("You must make a category first!");
				}
			},
			removeToDoItem: function($index) {
				this.activeCategory.list.splice($index, 1);
			},
			getPriority: function($index) {
				switch (this.activeCategory.list[$index].prior) {
					case '1':
						return "High";
					case '2':
						return "Medium";
					case '3':
						return "Low";
				}
				return "None";
			}
		};
	});