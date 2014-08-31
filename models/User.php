<?php

class User extends baseUser {

	/*
	 * When requesting user information, leaves out password field as well as created and updated
	 */
	public function toArray() {
		$user = array();
		
		$user['id'] = $this->getId();
		$user['username'] = $this->getUsername();
		$user['email'] = $this->getEmail();
		$user['type'] = $this->getType();
		$user['image'] = $this->getImage();
		
		return $user;
	}
}