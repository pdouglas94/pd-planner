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
	'ui.bootstrap',
	'ui.bootstrap-slider'
  ])
  
  .config(['$urlRouterProvider', function ($urlRouterProvider) {
    $urlRouterProvider.otherwise('/');

  }])
  
  .run(['$rootScope', function($rootScope) {
		$rootScope.views = [
			{link: '', name: 'Home'},
			{link: 'about', name:'About'},
			{link: 'planner', name:'Planner'},
			{link: 'login', name:'Login'}
		];

		$rootScope.selectedNav = '';
	}])

	.constant('SITE_URL', 'http://pd-planner/');