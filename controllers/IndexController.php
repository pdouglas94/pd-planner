<?php

class IndexController extends ApplicationController {

	function index() {
		redirect('app');
	}
	
	public function login() {
		/*
		 * Notes:
		 * password is not secure unless hashed!
		 */
		$credentials = $_REQUEST;
		
		if (!empty($credentials['username']) && !empty($credentials['password'])) {
			$user = User::retrieveByUsername($credentials['username']);
			if ($user) {
				if ($user->getPassword() === $credentials['password']) {
					$this['authenticated'] = true;
					$expiration = time() + 60*60*24;
					setcookie('user', $user->getId(), $expiration);
					$this['user'] = $user;
				} else {
					$this['messages'] = 'Password was not correct';
				}
			} else {
				$this['messages'] = 'User was not found';
			}
		} else {
			$this['messages'] = 'Request was not complete';
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
			unset($_COOKIE['user']);
			return true;
		}
		return false;
	}
}