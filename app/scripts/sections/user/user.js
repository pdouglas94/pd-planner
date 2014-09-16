angular.module('pdPlannerApp')
  .controller('UserCtrl', ['$scope', '$rootScope', 'user', 'db', function($scope, $rootScope, user, db) {
	$scope.user = user;
}]);