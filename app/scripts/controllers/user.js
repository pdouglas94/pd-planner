angular.module('pdPlannerApp')
  .controller('UserCtrl', ['$scope', '$rootScope', 'user', 'db', function($scope, $rootScope, user, db) {
	$scope.user = null;

	if (user !== null) {
		$scope.user = user;
	} else {
		//Needs to be loaded first!
		$scope.user = $rootScope.currentUser;
	}
	
	db.User.find({id:3}).then(function(reply) {
		$scope.user = reply;
	}, function() {
		console.log('Something went wrong');
	});

}]);