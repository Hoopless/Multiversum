<?php


class Page
{
	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
	}

	public function get($id)
	{
		if (! empty($id)) {

			try {
				$query = "SELECT * FROM pages WHERE id = :id";

				$stmt = $this->dataHandler->preparedQuery($query);

				$stmt->bindParam(':id', $id, PDO::PARAM_INT);

				$stmt->execute();

				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				$data = $stmt->fetch();

				return $data;
			} catch (Exception $e) {
			}

		} else {
			return ["No ID specified! please try again"];
		}
	}

	public function update($data)
	{
		try {

			$query = "UPDATE pages SET content = :content WHERE id = :id;";

			$stmt = $this->dataHandler->preparedQuery($query);

			$stmt->bindParam(':content', $data['id']);
			$stmt->bindParam(':content', $data['content']);

			$stmt->execute();

			$pageID = $this->dataHandler->lastInsertId();


			return json_encode([
				'message' => "Successfully updated product!",
				'id'      => (int)$pageID,
			]);

		} catch (Exception $e) {

		}
	}
}
