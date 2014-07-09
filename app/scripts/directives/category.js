angular.module('pdPlannerApp.directives.category', [])
	.directive('category', function () {
		return {
			restrict: 'EA',
			transclude: true,
			replace: true,
			templateUrl: '/app/views/overlays/category.html'
		};
	});