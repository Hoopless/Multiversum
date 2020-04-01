<?php

require 'model/Page.php';

class PageController
{

	public function __construct()
	{
		$this->pageModel = new Page();
	}

	public function index()
	{
		header('Content-Type: application/json');

		$data = $this->pageModel->getAll();

		return json_encode($data);
	}

	public function get($id, $name)
	{
		header('Content-Type: application/json');

		$data = $this->pageModel->get($id, $name);

		return json_encode($data);
	}

	public function update($data)
	{
		if (! User::checkLoggedIn()) {
			return json_encode(['message' => "Not logged in"]);
		}

		$data = $this->pageModel->update($data);

		return json_encode($data);
	}

}
