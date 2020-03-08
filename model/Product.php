<?php

include 'model/DataHandler.php';

class Product
{

	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
	}


	/**
	 * @return string
	 * @throws Exception
	 */
	public function create()
	{
		try {

			$array = [
				'name',
				'description',
				'price',
				'platform',
				'resolution',
				'refresh_rate',
				'audio_type',
				'included_info',
				'colour',
				'warranty',
				'ean',
				'sku',
				'brand',
				'image_url',
				'in_sale',
			];

			$query = "INSERT INTO products (";
			foreach ($array as $key => $value) {
				$query .= "{$value}";
				($key !== count($array) - 1) ? $query .= ", " : "";
			}
			$query .= ") ";

			$query .= "VALUES (";
			foreach ($array as $key => $value) {
				$query .= ":{$value}";
				($key !== count($array) - 1) ? $query .= ", " : "";
			}
			$query .= ") ";

			$stmt = $this->dataHandler->preparedQuery($query);

			if (isset($_POST['name'])) {
				$stmt->bindValue(':name', $_POST['name']);
			} else {
				json_encode(['message' => "Not created, there was no name set."]);
			}

			foreach ($array as $value) {
				$text = ":" . $value;

				switch ($value) {
					case "in_sale":
						$stmt->bindValue($text, isset($_POST[$value]) ? $this->checkBoolean($_POST[$value]) : NULL);
						break;
					default:
						$stmt->bindValue($text, isset($_POST[$value]) ? $_POST[$value] : NULL);
						break;
				}
			}
			$stmt->execute();

			if (isset($_FILES['image'])) {
				$entryId = $this->dataHandler->lastInsertId();
				$this->uploadToAzure($_FILES['image'], $entryId);
			}


			return json_encode(['message' => "Successfully added product!"]);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), (int) $e->getCode());
		}
	}

	public function uploadFile($file)
	{

		$target_dir  = "view/images/";
		$target_file = $target_dir . basename($file['name']);

		if (!file_exists('view/images')) {
			mkdir('view/images', 0777, true);
		}

		if (move_uploaded_file($file["tmp_name"], $target_file)) {
			$file['url'] = $target_file;
		}


		return $file['url'];
  }

	public function uploadToAzure ($file, $id)
	{

		$storageToken = getenv('STORAGE_SAS_TOKEN');
		$accountName = getenv('STORAGE_ACCOUNT_NAME');
		$containerName = getenv('STORAGE_CONTAINER_NAME');


		$fileName = urlencode($file['name']);
		$url = "https://{$accountName}.blob.core.windows.net/{$containerName}/{$id}/{$fileName}{$storageToken}";

		$storageConn = curl_init();
		// $imageReader = fopen($file['tmp_name'], 'r');
		// $imageSize = filesize($file['tmp_name']);
		// $imageContent = fread($imageReader, $imageSize);

		curl_setopt($storageConn, CURLOPT_URL, $url);
		curl_setopt($storageConn, CURLOPT_PUT, true);
		// curl_setopt($storageConn, CURLOPT_POSTFIELDS, 'test');
		curl_setopt($storageConn, CURLOPT_HTTPHEADER, array(
			'x-ms-blob-type: BlockBlob',
			"x-ms-original-content-length: 4"
		));

		$res = curl_exec($storageConn);

		echo curl_getinfo($storageConn, CURLINFO_HTTP_CODE);
		echo $res;

		if (curl_errno($storageConn)) {
			echo curl_error($storageConn);
		}

		// fclose($imageReader);
		curl_close($storageConn);
  }

	public function checkBoolean($value)
	{
		return $value ? 1 : 0;
	}

	/**
	 * @param Int $id
	 * @return array
	 * @throws Exception
	 */
	public function get($id)
	{

		if (!empty($id)) {

			try {

				$query = "SELECT *  ";
				$query .= "FROM products ";
				$query .= "WHERE id = :id";

				$stmt = $this->dataHandler->preparedQuery($query);

				$stmt->bindParam(':id', $id, PDO::PARAM_INT);

				$stmt->execute();

				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				$data = $stmt->fetch();

				$data['id']      = (int) $data['id'];
				$data['price']   = (float) $data['price'];
				$data['in_sale'] = (bool) $data['in_sale'];


				return $data;
			} catch (Exception $e) {
				throw new Exception($e->getMessage(), (int) $e->getCode());
			}
		} else {
			return ["No ID specified! please try again"];
		}
	}

	public function getAll()
	{
		try {

			$query = "SELECT *  ";
			$query .= "FROM products ";

			$sales = isset($_GET["sales"]) ? (bool) $_GET["sales"] : NULL;

			if (!is_null($sales)) {

				if ($sales) {
					$query .= "WHERE in_sale = TRUE ";
				} else {
					$query .= "WHERE in_sale = FALSE ";
				}
			}

			$limit = isset($_GET["limit"]) ? (int) $_GET["limit"] : 0;

			if ($limit > 0) {
				$query .= "LIMIT {$limit} ";
			}


			$stmt = $this->dataHandler->preparedQuery($query);

			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);


			$data = $stmt->fetchAll();
		} catch (PDOException $e) {
			throw new \PDOException($e->getMessage(), (int) $e->getCode());
		}

		return $data;
	}
}
