angular.module('pdPlannerApp.directives.todo', [])
	.directive('todo', function () {
		return {
			restrict: 'EA',
			transclude: true,
			replace: true,
			templateUrl: '/app/views/overlays/todo.html'
		};
	});