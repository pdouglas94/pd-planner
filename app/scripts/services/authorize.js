angular.module('pdPlannerApp')
	.factory('AuthService', ['$http', 'Session', 'db', 'SITE_URL', function ($http, Session, db, SITE_URL) {
		return {
			login: function (credentials, issues) {
				if (typeof issues == 'undefined') {
					var issues = {};
				}
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
			isLoggedIn: function () {
				return !!Session.userId;
			},
			isAuthorized: function (authorizedRoles) {
				if (!angular.isArray(authorizedRoles)) {
					authorizedRoles = [authorizedRoles];
				}
				return (this.isLoggedIn() &&
					authorizedRoles.indexOf(Session.userRole) !== -1);
			}
		};
    }]);
