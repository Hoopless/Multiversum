<?php

require_once 'model/User.php';

class UserController
{

	public function __construct()
	{
		$this->user = new User();
	}

	public function checkSession()
	{
		header('Content-Type: application/json');

		$data = $this->user->checkedLoggedIn();

		return json_encode($data);
	}

	public function checkOnLogin($data)
	{
		header('Content-Type: application/json');

		$data = $this->user->checkAccount($data['email'], $data['password']);

		return json_encode($data);
	}
}
