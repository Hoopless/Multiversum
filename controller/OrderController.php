<?php


require 'model/Order.php';

class OrderController
{
	public function __construct()
	{
		$this->order = new Order();
	}

	public function create($data)
	{
		$data = $this->order->create($data);

		header('Content-Type: application/json');

		return json_encode($data);
	}

	public function getLastOrders()
	{
		header('Content-Type: application/json');

		$data = $this->order->getLastOrders(10);

		return json_encode($data);
	}
}
