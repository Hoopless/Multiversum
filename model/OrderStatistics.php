<?php


class OrderStatistics
{

	public static $months = [
		1  => "januari",
		2  => "februari",
		3  => "maart",
		4  => "april",
		5  => "mei",
		6  => "juni",
		7  => "juli",
		8  => "augustus",
		9  => "september",
		10 => "oktober",
		11 => "november",
		12 => "december",
	];

	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);

	}

	public function getGroupedbyMonth($year)
	{

		$query = "SELECT MONTH(ordered_date) as month, COUNT(*) as amount ";
		$query .= "FROM orders WHERE YEAR(ordered_date) = :year ";
		$query .= "GROUP BY  MONTH(ordered_date) ";

		$stmt = $this->dataHandler->preparedQuery($query);

		$stmt->bindParam(':year', $year);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();

		foreach ($data as $key => $order) {
			$data[$key]['month'] = self::$months[(int)$order['month']];
		}

		return $data;
	}


}
