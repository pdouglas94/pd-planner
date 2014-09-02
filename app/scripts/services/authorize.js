angular.module('pdPlannerApp')
	.factory('AuthService', ['$http', 'Session', 'db', 'SITE_URL', function ($http, Session, db, SITE_URL) {
		return {
			login: function (credentials, issues) {
				return $http.post(SITE_URL + 'rest/index/login.json?' + $.param(credentials)).then(
					function (reply) {
						var data = reply.data;
						if (data.authenticated == true) {
							Session.create(data.user.id, data.user.type);
						} else {
							issues.messages = data.messages;
						}
					}, function(reply) {});
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
