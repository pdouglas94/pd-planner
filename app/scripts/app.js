'use strict';

/**
 * @ngdoc overview
 * @name pdPlannerApp
 * @description
 * # pdPlannerApp
 *
 * Main module of the application.
 */
angular.module('pdPlannerApp', [
	'ngAnimate',
	'ngCookies',
	'ngResource',
	'ngRoute',
	'ngSanitize',
	'ngTouch',
	'ui.router',
	'ui.bootstrap',
	'ui.bootstrap-slider'
  ])
  
  .config(['$urlRouterProvider', function ($urlRouterProvider) {
    $urlRouterProvider.otherwise('/');

  }])
  
  .run(['$rootScope', function($rootScope) {
		$rootScope.leftViews = [
			{link: '', name: 'Home'},
			{link: 'about', name:'About'},
			{link: 'planner', name:'Planner'}
		];
		
		$rootScope.logoutView = {link: 'logout', name: 'Logout'};

		$rootScope.selectedNav = '';
	}])

.constant('SITE_URL', 'http://pd-planner/');