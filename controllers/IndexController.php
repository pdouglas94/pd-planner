<?php

class IndexController extends ApplicationController {

	function index() {
		redirect('app');
	}
	
	public function login() {
		$credentials = $_REQUEST;
		$this['messages'] = array();
		
		if (!empty($credentials['username']) && !empty($credentials['password'])) {
			$user = User::retrieveByUsername($credentials['username']);
			if (!empty($user)) {
				if (password_needs_rehash($user->getPassword(), PASSWORD_BCRYPT, array('cost' => 12)) == true) {
					$user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT, array('cost' => 12)));
					$user->save();
				}
				if (password_verify($credentials['password'], $user->getPassword()) == true) {
					$this['authenticated'] = true;
					$expiration = time() + 60*60*24;
					setcookie('user', $user->getId(), $expiration, '/', 'pd-planner');
					$this['user'] = $user;
				} else {
					$this['messages'][] = ['message' => 'Incorrect Password.', 'type' => 'warning'];
				}
			} else {
				$this['messages'][] = ['message' => 'User does not exist.', 'type' => 'warning'];
			}
		} else {
			$this['messages'][] = ['message' => 'Something went wrong.', 'type' => 'danger'];
		}
		
		if (empty($this['authenticated'])) {
			$this['authenticated'] = false;
		}
		
		return $this;
	}
	
	public function isLoggedIn() {
		if (isset($_COOKIE['user'])) {
			$this['loggedIn'] = true;
			$this['user'] = User::retrieveById($_COOKIE['user']);
		} else {
			$this['loggedIn'] = false;
		}
		
		return $this;
	}
	
	public function logout() {
		if (isset($_COOKIE['user'])) {
			setcookie('user', '', time()-1);
			return true;
		}
		return false;
	}
}