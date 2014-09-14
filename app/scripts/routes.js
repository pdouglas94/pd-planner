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
				controller: ['$scope', function($scope) {
					$scope.sections = [
						{name: 'Planner', link: 'planner.overview'},
						{name: 'Notes', link: 'planner.notes({user_id: currentUser.id})'}
					];
				}],
				templateUrl: SITE_URL + 'app/views/planner.html'
			})
			
			.state('planner.overview', {
				url: 'overview/',
				controller: 'OverviewCtrl',
				templateUrl: SITE_URL + 'app/views/overview.html'
			})
			
			.state('planner.notes', {
				url: 'notes/:user_id',
				controller: ['$scope', 'note', function($scope, note) {
					$scope.note = note[0];
					console.log($scope.note);
					
					$scope.saveNote = function() {
						$scope.note.save().then(function(reply) {
							//Disabled until alerts are moved elsewhere!
							//addAlert("Notes were successfully updated!", 'success')
						}, function(reply) {
							//addAlert("Notes were not saved successfully!" + reply, 'warning');
						});
					};
				}],
				templateUrl: SITE_URL + 'app/views/notes.html',
				resolve: {
					note: ['$stateParams', 'db', function($stateParams, db) {
						return db.Note.findAll({userId: $stateParams.user_id});
					}]
				}
			})
			
			.state('planner.item', {
				url: 'item/:item_id',
				resolve: {	
					item: ['$stateParams', 'db', function($stateParams, db) {
						return db.Item.find($stateParams.item_id);
					}]
				},
				controller: 'ItemCtrl',
				templateUrl: SITE_URL + 'app/views/item.html'
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
