angular.module('pdPlannerApp')
	.service('db', ['$http', '$q', 'SITE_URL', function($http, $q, SITE_URL) {
		dabl.Deferred = function () {
			var def = $q.defer(),
				promise = def.promise;
		
			def.promise = function() {
				return promise;
			};
			return def;
		};
		
		var adapter = new dabl.AngularRESTAdapter(SITE_URL + 'rest/', $http),
			db = {},
			Model = dabl.Model,
			Entity = Model.extend('entity', {
				adapter: adapter,
				fields: {
					id: { type: 'int', key: true, computed: true }
					//created: Date,
					//updated: Date
				}
			});
			
		db.User = Entity.extend('user', {
			url: 'users/:id.json',
			fields: {
				type: 'int',
				username: String,
				email: String,
				password: String,
				image: String,
				created: Date
			}
		});
		
		db.Category = Entity.extend('category', {
			url: 'categories/:id.json',
			fields: {
				user_id: 'int',
				name: String
			}
		});
		
		db.Item = Entity.extend('item', {
			url: 'items/:id.json',
			fields: {
				category_id: 'int',
				complete: Boolean,
				description: String,
				priority: 'int',
				progress: 'int',
				name: String
			}
		});
		return db;
	}]);