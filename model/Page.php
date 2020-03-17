<?php


header("Cache-Control: stale-while-revalidate=99999999");

class Page
{
	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
	}

	public function get($id = "", $name = "")
	{

		try {
			$query = "SELECT id, name, meta_title, meta_description, json_content FROM pages ";

			$isNameSet = ! empty($name) ? true : false;
			$isIdSet   = ! empty($id) ? true : false;

			if ($isNameSet) {
				$query .= " WHERE name = :name ";
			}

			if ($isIdSet) {
				$query .= " WHERE id = :id ";
			}


			$stmt = $this->dataHandler->preparedQuery($query);

			if ($isIdSet) {
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			}

			if ($isNameSet) {
				$stmt->bindParam(':name', $name);
			}

			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);

			$data = $stmt->fetch();

			$data['content'] = json_decode($data['json_content'], true);

			$data['id'] = (int)$data['id'];

			unset($data['json_content']);


			return $data;
		} catch (Exception $e) {
		}
	}

	public function update($data)
	{

		if (! isset($data['id']) || ! isset($data['json_content'])) {
			return "The ID or JSON_CONTENT is missing.";
		}

		try {

			$array = [
				'meta_title',
				'meta_description',
			];

			$query = "UPDATE pages SET json_content = :json_content, meta_title = :meta_title, meta_description = :meta_description WHERE id = :id;";

			$stmt = $this->dataHandler->preparedQuery($query);

			$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
			$stmt->bindParam(':json_content', $data['json_content']);

			foreach ($array as $value) {
				$text = ":" . $value;
				$stmt->bindValue($text, isset($data[$value]) ? $data[$value] : NULL);
			}

			$stmt->execute();

			$pageID = $data['id'];


			return [
				'message' => "Successfully updated page!",
				'id'      => (int)$pageID,
			];

		} catch (Exception $e) {

		}
	}
}
