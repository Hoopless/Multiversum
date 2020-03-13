<?php

require 'model/Page.php';

class PageController
{
	public function __construct()
	{
		$this->pageModel = new Page();
	}

	public function get($id, $name)
	{
		header('Content-Type: application/json');

		$data = $this->pageModel->get($id, $name);

		return json_encode($data);
	}

	public function update($data)
	{
		$data = $this->pageModel->update($data);

		return json_encode($data);
	}
}
