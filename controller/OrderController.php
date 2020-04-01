<?php


require 'model/Order.php';
require 'model/OrderStatistics.php';

class OrderController
{
	public function __construct()
	{
		$this->order           = new Order();
		$this->orderStatistics = new OrderStatistics();
	}

	public function create($data)
	{
		header('Content-Type: application/json');

		$data = $this->order->create($data);

		return json_encode($data);
	}

	public function getLastOrders()
	{
		header('Content-Type: application/json');

		if (! User::checkLoggedIn()) {
			return json_encode(['message' => "Not logged in"]);
		}

		$data = $this->order->getLastOrders(10);

		return json_encode($data);
	}

	public function getPaymentMethods()
	{
		$data = PaymentMethod::getAllPaymentMethods();
		header('Content-Type: application/json');

		return json_encode($data);
	}

	public function getStatsbyMonth()
	{
		if (! User::checkLoggedIn()) {
			return json_encode(['message' => "Not logged in"]);
		}

		$year = \Carbon\Carbon::now()->year;

		$data = $this->orderStatistics->getGroupedbyMonth($year);

		header('Content-Type: application/json');

		return json_encode($data);
	}
}
