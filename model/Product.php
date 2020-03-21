<?php


class Product
{

	private static $insert_array = [
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
		'point_of_view',
		'height',
		'width',
		'own_display',
	];

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

			$query = Tools::insertQuery(self::$insert_array, "products");

			$stmt = $this->dataHandler->preparedQuery($query);

			if (isset($_POST['name'])) {
				$stmt->bindValue(':name', $_POST['name']);
			} else {
				return ['message' => "Not created, there was no name set."];
			}

			foreach (self::$insert_array as $value) {
				$text = ":" . $value;

				switch ($value) {
					case "in_sale":
					case "own_display":
						$stmt->bindValue($text, isset($_POST[$value]) ? $this->checkBoolean($_POST[$value]) : false, PDO::PARAM_BOOL);
						break;
					default:
						$stmt->bindValue($text, isset($_POST[$value]) ? $_POST[$value] : NULL);
						break;
				}
			}
			$stmt->execute();

			$productID = $this->dataHandler->lastInsertId();
			if (isset($_FILES['image'])) {
				$entryId   = $productID;
				$imageLink = $this->uploadToAzure($_FILES['image'], $entryId);

				$this->updateImage($entryId, $imageLink);
			}


			return [
				'message' => "Successfully added product!",
				'id'      => (int)$productID,
			];
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), (int)$e->getCode());
		}
	}

	public function updateImage($id, $imageLink)
	{
		try {
			$query         = "UPDATE products SET image_url = :image_link WHERE id = :product_id";
			$preparedQuery = $this->dataHandler->preparedQuery($query);

			$preparedQuery->bindParam(':image_link', $imageLink);
			$preparedQuery->bindParam(':product_id', $id);

			$preparedQuery->execute();
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), (int)$e->getCode());
		}
	}

	private function deleteFromAzure($filename)
	{
		$httpClient    = new GuzzleHttp\Client();
		$storageToken  = getenv('STORAGE_SAS_TOKEN');
		$accountName   = getenv('STORAGE_ACCOUNT_NAME');
		$containerName = getenv('STORAGE_CONTAINER_NAME');

		$authenticatedURL = "{$filename}{$storageToken}";

		$httpClient->request('delete', $authenticatedURL);

		return true;
	}

	private function uploadToAzure($file, $id)
	{
		$httpClient    = new GuzzleHttp\Client();
		$storageToken  = getenv('STORAGE_SAS_TOKEN');
		$accountName   = getenv('STORAGE_ACCOUNT_NAME');
		$containerName = getenv('STORAGE_CONTAINER_NAME');

		$fileName         = urlencode($file['name']);
		$fileURL          = "https://{$accountName}.blob.core.windows.net/{$containerName}/{$id}/{$fileName}";
		$authenticatedURL = "{$fileURL}{$storageToken}";

		$uploadReq = $httpClient->request('PUT', $authenticatedURL, [
			'body'    => file_get_contents($file['tmp_name']),
			'headers' => [
				'x-ms-blob-type' => 'BlockBlob',
			],
		]);

		return $fileURL;
	}

	public function getImageURL($id)
	{
		$query = "SELECT image_url FROM products WHERE id = :id";

		$stmt = $this->dataHandler->preparedQuery($query);
		$stmt->bindParam(':id', $id);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetch();


		return $data['image_url'];
	}

	public function checkBoolean($value)
	{
		return $value === "true" ? 1 : 0;
	}

	/**
	 * @param Int $id
	 * @return array
	 * @throws Exception
	 */
	public function get($id)
	{

		if (! isset($data['id'])) {
			return false;
		}

		if (! empty($id)) {

			try {

				$query = "SELECT *  ";
				$query .= "FROM products ";
				$query .= "WHERE id = :id";

				$stmt = $this->dataHandler->preparedQuery($query);

				$stmt->bindParam(':id', $id, PDO::PARAM_INT);

				$stmt->execute();

				$stmt->setFetchMode(PDO::FETCH_ASSOC);

				$data = $stmt->fetch();

				$data['id']      = (int)$data['id'];
				$data['price']   = (float)$data['price'];
				$data['in_sale'] = (bool)$data['in_sale'];


				return $data;
			} catch (Exception $e) {
				throw new Exception($e->getMessage(), (int)$e->getCode());
			}
		} else {
			return ["No ID specified! please try again"];
		}
	}

	public function update($data)
	{
		if (! isset($data['id'])) {
			return false;
		}

		try {
			$query = Tools::updateQuery(self::$insert_array, "products", $data);
			$query .= "WHERE id = :id";


			$stmt = $this->dataHandler->preparedQuery($query);

			$stmt->bindValue(':id', $data['id']);


			foreach (self::$insert_array as $value) {
				if (isset($data[$value]) && ! empty($data[$value])) {
					$text = ":" . $value;

					switch ($value) {
						case "in_sale":
						case "own_display":
							$stmt->bindValue($text, isset($_POST[$value]) ? $this->checkBoolean($_POST[$value]) : false, PDO::PARAM_BOOL);
							break;
						default:
							$stmt->bindValue($text, isset($data[$value]) ? $data[$value] : NULL);
							break;
					}
				}
			}

			$stmt->execute();


			//Delete file from Azure & Reupload if there is a file.
			if (isset($_FILES['image'])) {
				$file_url = $this->getImageURL($data['id']);

				if ($file_url){
					if ($this->deleteFromAzure($file_url)) {
						$entryId   = $data['id'];
						$imageLink = $this->uploadToAzure($_FILES['image'], $entryId);
						$this->updateImage($entryId, $imageLink);
					}
				} else {
					$entryId   = $data['id'];
					$imageLink = $this->uploadToAzure($_FILES['image'], $entryId);
					$this->updateImage($entryId, $imageLink);
				}
			}

			return true;

		} catch (Exception $e) {

			return false;
		}
	}

	public function getAll()
	{
		try {

			$query = "SELECT *  ";
			$query .= "FROM products ";

			$sales = isset($_GET["sales"]) ? (bool)$_GET["sales"] : NULL;

			if (! is_null($sales)) {

				if ($sales) {
					$query .= "WHERE in_sale = TRUE ";
				} else {
					$query .= "WHERE in_sale = FALSE ";
				}
			}

			$limit = isset($_GET["limit"]) ? (int)$_GET["limit"] : 0;

			if ($limit > 0) {
				$query .= "LIMIT {$limit} ";
			}


			$stmt = $this->dataHandler->preparedQuery($query);

			$stmt->execute();

			$stmt->setFetchMode(PDO::FETCH_ASSOC);


			$data = $stmt->fetchAll();
		} catch (PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}

		return $data;
	}
}
