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
					$user = $user->toArray();
					unset($user['updated']);
					unset($user['created']);
					unset($user['password']);
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
	
}