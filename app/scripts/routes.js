angular.module('pdPlannerApp')
	.config(['$urlRouterProvider', '$stateProvider', 'SITE_URL', function($urlRouterProvider, $stateProvider, SITE_URL) {
		$stateProvider
			.state('home', {
				url: '/',
				controller: 'MainCtrl',
				templateUrl: SITE_URL + 'app/views/main.html'
			})

			.state('about', {
				url: '/about',
				controller: 'AboutCtrl',
				templateUrl: SITE_URL + 'app/views/about.html'
			})
			
			.state('planner', {
				url: '/planner',
				controller: 'PlannerCtrl',
				templateUrl: SITE_URL + 'app/views/planner.html'
			})
			
			.state('login', {
				url: '/login',
				controller: 'LoginCtrl',
				template: '<div></div>'
			})
			
			.state('logout', {
				url: '/logout',
				controller: ['$http', '$state', '$rootScope', function($http, $state, $rootScope) {
					$http.post(SITE_URL + 'rest/index/logout.json').then(function() {
						$rootScope.currentUser = null;
						$state.go('login');
					});
				}],
				template: '<div></div>'
			});
	}]);
