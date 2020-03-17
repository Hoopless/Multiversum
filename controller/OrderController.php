<?php


require 'model/Order.php';

class OrderController
{
	public function create($data)
	{
		$order = new Order();
		$data = $order->create($data);

		return json_encode($data);
	}
}
