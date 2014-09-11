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
				}
			});
			
		db.User = Entity.extend('user', {
			url: 'users/:id.json',
			fields: {
				type: 'int',
				username: String,
				email: String,
				password: String,
				image: String
			}
		});
		
		db.Note = Entity.extend('note', {
			url: 'notes/:user_id.json',
			fields: {
				userId: 'int',
				comment: String
			}
		});
		
		db.Category = Entity.extend('category', {
			url: 'categories/:id.json',
			fields: {
				userId: 'int',
				name: String
			}
		});
		
		db.Item = Entity.extend('item', {
			url: 'items/:id.json',
			fields: {
				categoryId: 'int',
				name: String,
				description: String,
				priority: 'int',
				complete: Boolean,
				progress: 'int'
			}
		});
		
		db.Subitem = Entity.extend('subitem', {
			url: 'subitems/:id.json',
			fields: {
				itemId: 'int',
				name: String,
				description: String
			}
		});
		
		return db;
	}]);