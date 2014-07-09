'use strict';

/**
 * @ngdoc overview
 * @name pdPlannerApp
 * @description
 * # pdPlannerApp
 *
 * Main module of the application.
 */
angular
  .module('pdPlannerApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
	'ui.router',
	'pdPlannerApp.directives.todo',
	'pdPlannerApp.directives.category'
  ])
  
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
	  .when('/planner', {
        templateUrl: 'views/planner.html',
        controller: 'PlannerCtrl'
      })
	  .when('/login', {
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl',
      })
      .otherwise({
        redirectTo: '/'
      });
  })
  
  .run(['$rootScope', function($rootScope) {
		$rootScope.views = [
			{link: '', name: 'Home'},
			{link: 'about', name:'About'},
			{link: 'planner', name:'Planner'},
			{link: 'login', name:'Login'}
		];

		$rootScope.selectedNav = '';
	}]);
