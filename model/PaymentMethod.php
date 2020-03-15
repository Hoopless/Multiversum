<?php


class PaymentMethod
{
	/**
	 * @var int $id
	 */
	private $id;
	public $name;
	public $fees;
	public $percentage;

	public function __construct($id = NULL)
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
		$this->id          = $id;
		if ($this->id) {
			$this->getPaymentMethod();
		}
	}


	public function setPaymentMethod()
	{
		try {

			$query = "SELECT name, fees, precentage FROM payment_methods WHERE id = :id";

			$stmt = $this->dataHandler->preparedQuery($query);
			$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			$data = $stmt->fetch();

			$this->name       = $data['name'];
			$this->fees       = $data['fees'];
			$this->percentage = $data['percentage'];

		} catch (Exception $e) {
			throw new Exception($e->getMessage(), (int)$e->getCode());
		}
	}


	/**
	 * Gets all payment methods that are there.
	 *
	 * @return array
	 */
	public static function getAllPaymentMethods()
	{
		$query = "SELECT id, name, fees, precentage FROM payment_methods";

		$dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
		$data        = $dataHandler->readsData($query);
		$results     = $data->fetchAll();

		return $results;
	}
}
