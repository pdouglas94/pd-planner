angular.module('pdPlannerApp')
	.config(['$urlRouterProvider', '$stateProvider', 'SITE_URL', function($urlRouterProvider, $stateProvider, SITE_URL) {
		$stateProvider
			.state('home', {
				url: '/',
				controller: 'MainCtrl',
				templateUrl: SITE_URL + 'app/views/main.html'
			})

			.state('about', {
				url: '/about/',
				controller: 'AboutCtrl',
				templateUrl: SITE_URL + 'app/views/about.html'
			})
			
			.state('planner', {
				url: '/planner/',
				controller: 'PlannerCtrl',
				templateUrl: SITE_URL + 'app/views/planner.html'
			})
			
			.state('user', {
				url: '/user/:user_id',
				controller: 'UserCtrl',
				templateUrl: SITE_URL + 'app/views/user.html',
				resolve: {
					user: ['$stateParams', 'db', function($stateParams, db) {
						return db.User.find($stateParams.user_id);
					}]
				}
			})
			
			.state('login', {
				url: '/login/',
				controller: 'LoginCtrl',
				template: '<div></div>'
			})
			
			.state('logout', {
				url: '/logout/',
				controller: ['$http', '$state', '$rootScope', 'AuthService', 'Session', function($http, $state, $rootScope, AuthService, Session) {
					if (!AuthService.isLoggedIn()) {
						$state.go('login');
					}
					
					$http.post(SITE_URL + 'rest/index/logout.json').then(function() {
						$rootScope.currentUser = null;
						Session.destroy();
						$state.go('login');
					});
				}],
				template: '<div></div>'
			});
	}]);
