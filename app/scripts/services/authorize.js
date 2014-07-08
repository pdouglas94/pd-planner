angular.module('pdPlannerApp')
	.constant('USER_ROLES', {
		all: '*',
		admin: 'admin',
		editor: 'editor',
		guest: 'guest'
	})
  
	.constant('AUTH_EVENTS', {
		loginSuccess: 'auth-login-success',
		loginFailed: 'auth-login-failed',
		logoutSuccess: 'auth-logout-success',
		sessionTimeout: 'auth-session-timeout',
		notAuthenticated: 'auth-not-authenticated',
		notAuthorized: 'auth-not-authorized'
	})
  
	.factory('AuthService', ['$http', 'Session', function ($http, Session) {
		return {
			login: function (credentials) {
				return $http
					.post('/app/views/login.html', credentials)
					.then(function (res) {
						Session.create(res.id, res.userid, res.role);
					});
			},
			isAuthenticated: function () {
				return !!Session.userId;
			},
			isAuthorized: function (authorizedRoles) {
				if (!angular.isArray(authorizedRoles)) {
					authorizedRoles = [authorizedRoles];
				}
				return (this.isAuthenticated() &&
					authorizedRoles.indexOf(Session.userRole) !== -1);
			}
		};
    }]);
