<?php

require 'model/Page.php';

class PageController
{
	public function __construct()
	{
		$this->pageModel = new Page();
	}

	public function get($id)
	{
		$data = $this->pageModel->get($id);

		return $data;
	}

	public function update($data)
	{
		$data = $this->pageModel->update($data);

		return json_encode($data);
	}
}
