'use strict';

/**
 * @ngdoc function
 * @name pdPlannerApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the pdPlannerApp
 */
angular.module('pdPlannerApp')
  .controller('LoginCtrl', ['$rootScope', '$scope', '$state', '$modal', '$http', 'AUTH_EVENTS', 'AuthService', 'SITE_URL', 'Session',
	function ($rootScope, $scope, $state, $modal, $http, AUTH_EVENTS, AuthService, SITE_URL, Session) {
	
	$scope.loginModal = function(addAlerts) {
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/login.html',
			controller: 'LoginModalCtrl',
			persist: true,
			size: 'sm',
			resolve: {
				alerts: function() {
					if (addAlerts) {
						return addAlerts;
					} else {
						return null;
					}
				}
			}
		});

		return modalInstance.result;
	};
	
	$scope.$on(AUTH_EVENTS.loginSuccess, function() {
		$rootScope.userPromise = $rootScope.getCurrentUser();
	});
	
	var doLogin = function(credentials, issues) {
		AuthService.login(credentials, issues).then(function () {
			if (AuthService.isLoggedIn() == true) {
				$scope.$emit(AUTH_EVENTS.loginSuccess);
				$state.go('planner');
			} else {
				$scope.login(issues);
			}
		});
	};
	
	$scope.login = function(messages) {
		$scope.loginModal(messages).then(function (credentials) {
			if (credentials && credentials.username && credentials.password) {
				var issues = {};
				doLogin(credentials, issues);
			}
		}, function (cancel) {
			if (cancel === 'newUser') {
				$scope.createNewUser();
			}
		});
	};
	
	$scope.createNewUser = function(messages) {
		$scope.newUserModal(messages).then(function (newUser) {
			if (newUser && newUser.password && newUser.password2 && newUser.username) {
				var issues = {};
				$http.post(SITE_URL + 'rest/users/create-new-user.json?' + $.param(newUser)).then(function(reply) {
					if (reply.data.success == true) {
						Session.create(reply.data.user.id, reply.data.user.type);
						$scope.$emit(AUTH_EVENTS.loginSuccess);
					}
				}, function(reply) {
					$scope.createNewUser();
				});
			}
		}, function(cancel) {});
	};
	
	$scope.newUserModal = function(addAlerts) {
		var modalInstance = $modal.open({
			templateUrl: 'scripts/modals/overlays/new_user.html',
			controller: 'NewUserModalCtrl',
			persist: true,
			size: 'sm',
			resolve: {
				alerts: function() {
					if (addAlerts) {
						return addAlerts;
					} else {
						return null;
					}
				}
			}
		});

		return modalInstance.result;
	};
	
	if (AuthService.isLoggedIn() == true) {
		$state.go('home');
	} else {
		$scope.login();
	}
  }]);