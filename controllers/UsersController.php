<?php

class UsersController extends ApplicationController {

	/**
	 * Returns all User records matching the query. Examples:
	 * GET /users?column=value&order_by=column&dir=DESC&limit=20&page=2&count_only
	 * GET /rest/users.json&limit=5
	 *
	 * @return User[]
	 */
	function index() {
		$q = User::getQuery(@$_GET);

		// paginate
		$limit = empty($_REQUEST['limit']) ? 25 : $_REQUEST['limit'];
		$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
		$class = 'User';
		$method = 'doSelectIterator';
		$this['pager'] = new QueryPager($q, $limit, $page, $class, $method);

		if (isset($_GET['count_only'])) {
			return $this['pager'];
		}
		return $this['users'] = $this['pager']->fetchPage();
	}

	/**
	 * Form to create or edit a User. Example:
	 * GET /users/edit/1
	 *
	 * @return User
	 */
	function edit($id = null) {
		return $this->getUser($id)->fromArray(@$_GET);
	}

	/**
	 * Saves a User. Examples:
	 * POST /users/save/1
	 * POST /rest/users/.json
	 * PUT /rest/users/1.json
	 */
	function save($id = null) {
		$user = $this->getUser($id);

		try {
			$user->fromArray($_REQUEST);
			if ($user->validate()) {
				$user->save();
				$this->flash['messages'][] = 'User saved';
				$this->redirect('users/show/' . $user->getId());
			}
			$this->flash['errors'] = $user->getValidationErrors();
		} catch (Exception $e) {
			$this->flash['errors'][] = $e->getMessage();
		}

		$this->redirect('users/edit/' . $user->getId() . '?' . http_build_query($_REQUEST));
	}

	/**
	 * Returns the User with the id. Examples:
	 * GET /users/show/1
	 * GET /rest/users/1.json
	 *
	 * @return User
	 */
	function show($id = null) {
		return $this->getUser($id);
	}

	/**
	 * Deletes the User with the id. Examples:
	 * GET /users/delete/1
	 * DELETE /rest/users/1.json
	 */
	function delete($id = null) {
		$user = $this->getUser($id);

		try {
			if (null !== $user && $user->delete()) {
				$this['messages'][] = 'User deleted';
			} else {
				$this['errors'][] = 'User could not be deleted';
			}
		} catch (Exception $e) {
			$this['errors'][] = $e->getMessage();
		}

		if ($this->outputFormat === 'html') {
			$this->flash['errors'] = @$this['errors'];
			$this->flash['messages'] = @$this['messages'];
			$this->redirect('users');
		}
	}
	
	/*
	 * Creates a new user from $_REQUEST data
	 * @return	success	boolean
	 * @return	user		User
	 */
	public function createNewUser() {
		$user = $_REQUEST;
		if (empty($user['username']) || empty($user['password']) || empty($user['password2'])) {
			return $this['success'] = false;
		}
		$newUser = new User;
		
		if ($user['password'] === $user['password2']) {
			$password = password_hash($user['password'], PASSWORD_BCRYPT, array('cost' => 12));
			if ($password !== false) {
				$newUser->setPassword($password);
			} else {
				$this['success'] = false;
			}
		} else {
			return $this['success'] = false;
		}
		$newUser->setUsername($user['username']);
		if (isset($user['email'])) {
			$newUser->setEmail($user['email']);
		}
		
		$newUser->save();
		$expiration = time() + 60*60*24;
		setcookie('user', $newUser->getId(), $expiration, '/', 'pd-planner');
		
		$notes = new Note;
		$notes->setUser($newUser);
		$notes->save();
		$this['user'] = $newUser;
		$this['notes'] = $notes;
		$this['success'] = true;
		return $this;
	}
	
	/*
	 * Overwrite for user getQuery()
	 * Work in progress
	 */
	public static function getQuery($params = null) {
		print_r2($params);
		$q = new Query;
		$q->setTable(User::getTableName());
		
		$q->addColumn(User::ID);
		$q->addColumn(User::USERNAME);
		$q->addColumn(User::TYPE);
		$q->addColumn(User::EMAIL);
		$q->addColumn(User::IMAGE);
		
		die($q);
		$q->add(User::ID, $params['id']);
		return $q;
	}

	/**
	 * @return User
	 */
	private function getUser($id = null) {
		// look for id in param or in $_REQUEST array
		if (null === $id && isset($_REQUEST[User::getPrimaryKey()])) {
			$id = $_REQUEST[User::getPrimaryKey()];
		}

		if ('' === $id || null === $id) {
			// if no primary key provided, create new User
			$this['user'] = new User;
		} else {
			// if primary key provided, retrieve the record from the db
			$this['user'] = User::retrieveByPK($id);
		}
		return $this['user'];
	}

}