<?php


class Contact
{

	public static $insert_array = [
		'firstname',
		'lastname',
		'address',
		'house_number',
		'postcode',
		'city',
		'email',
		'phone',
		'created_at',
	];

	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
	}

	/**
	 * Creates an contact based on the information parsed.
	 *
	 * @param $data
	 * @return string
	 * @throws Exception
	 */
	public function create($data)
	{
		try {
			$query = Tools::insertQuery(self::$insert_array, "contacts");
			$date  = \Carbon\Carbon::now()->toDateString();

			$stmt = $this->dataHandler->preparedQuery($query);

			foreach (self::$insert_array as $value) {
				$text = ":" . $value;

				switch ($value) {
					case "created_at":
						$stmt->bindValue($text, $date);
						break;
					default:
						$stmt->bindValue($text, isset($data[$value]) ? $data[$value] : NULL);
						break;
				}
			}


			$stmt->execute();

			$id_contact = $this->dataHandler->lastInsertId();

			return $id_contact;
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), (int)$e->getCode());
		}
	}

	public function get($id)
	{
		$query = "SELECT * FROM contacts ";
		$query .= "WHERE id = :id ";

		$stmt = $this->dataHandler->preparedQuery($query);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetch();

		return $data;
	}
}
