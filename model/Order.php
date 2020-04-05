<?php

require 'model/Contact.php';
require 'model/PaymentMethod.php';

class Order
{


	public static $insert_array = [
		'contact_id',
		'total_price_inc',
		'total_price_ex',
		'payment_id',
    'ordered_date',
    'mollie_id'
	];

	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
    $this->mollie = new \Mollie\Api\MollieApiClient();
    $this->mollie->setApiKey($_ENV['MOLLIE_KEY']);
	}

	public function get($id)
	{
		$query = "SELECT * FROM orders ";
		$query .= "JOIN  product_order ON orders.id = product_order.order_id ";
		$query .= "WHERE orders.id = :id ";

		$stmt = $this->dataHandler->preparedQuery($query);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();

		return $data;
  }

  public function getStatus ($data)
  {
    if (!isset($data['id'])) {
      return [
        'message' => 'Missing order ID'
      ];
    }

    $orderId = $data['id'];
    $order   = $this->get($orderId);

    if (!isset($order[0])) {
      return [
        'message' => 'Unknown order'
      ];
    }

    $order    = $order[0];
    $response = [
      'id'                => $order['id'],
      'payment_method_id' => $order['payment_id']
    ];

    // Check mollie payment
    if (isset($order['mollie_id'])) {
      $mollieId = $order['mollie_id'];
      $molliePayment = $this->mollie->payments->get($mollieId);

      $response['mollie_status'] = $molliePayment->status;
    }

    return $response;
  }

	public function create($data)
	{
		/**
		 * Creates New contact
		 */
		$contactModel = new Contact();
		try {
			$id_contact = $contactModel->create($data);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), (int)$e->getCode());
		}

		$data['contact_id']      = $id_contact;
		$data['price']           = $this->calculateTotalPrice($data["product_id"]);
		$data['total_price_inc'] = $data['price'];
    $data['total_price_ex']  = ($data['price'] * 0.79);

    // Mollie payment
    $paymentLink;
    if ($data['payment_id'] === '2') {
      $molliePayment = $this->mollie->payments->create([
        "amount" => [
          "currency" => "EUR",
          "value" => number_format($data['price'] + 0.30, 2)
        ],
        "description" => "Multiversum payment #{$id_contact}",
        "redirectUrl" => "{$_ENV['BASE_URL']}/order/processing?orderId=51"
      ]);

      $paymentLink = $molliePayment->getCheckoutUrl();
      $data['mollie_id'] = $molliePayment->id;
    }

		$data['ordered_date'] = \Carbon\Carbon::now()->toDateTimeString();

		$id_order = $this->insertOrder($data);

    $this->insertRelationProduct($data['product_id'], $id_order);



		// $mailable = new Mailable();
    // $mail     = $mailable->sendConfirmationMail($data['email'], $data, $id_order);

    $response = [
			'message'    => "Successfully registerd order.",
			'order_id'   => (int)$id_order,
			'contact_id' => (int)$id_contact,
    ];

    if (isset($paymentLink)) {
      $response['paymentLink'] = $paymentLink;
    }

		return $response;
	}

	public function getLastOrders($limit = NULL)
	{
		$query = "SELECT * FROM orders ORDER BY id DESC ";

		if ($limit) {
			$query .= "LIMIT {$limit}";
		}

		$stmt = $this->dataHandler->readsData($query);

		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		$data = $stmt->fetchAll();

		foreach ($data as $key => $item) {
			$paymentMethod = new PaymentMethod((int)$item['payment_id']);
			$contact       = new Contact();
			$contact       = $contact->get($item['contact_id']);

			$data[$key]['id']              = (int)$item['id'];
			$data[$key]['product']         = $this->getFirstRelationProductName($item['id']);
			$data[$key]['total_price_inc'] = (float)$item['total_price_inc'];
			$data[$key]['total_price_inc'] = (float)$item['total_price_inc'];
			$data[$key]['total_price_ex']  = (float)$item['total_price_ex'];
			$data[$key]['payment_name']    = $paymentMethod->name;
			$data[$key]['contact_name']    = $contact['firstname'] . " " . $contact['lastname'];

			unset($data[$key]['payment_id']);
			unset($data[$key]['contact_id']);

		}

		return $data;
	}

	private function insertOrder($data)
	{
		$query = Tools::insertQuery(self::$insert_array, "orders");

		$stmt = $this->dataHandler->preparedQuery($query);

		foreach (self::$insert_array as $value) {
			$text = ":" . $value;

			switch ($value) {
				default:
					$stmt->bindValue($text, isset($data[$value]) ? $data[$value] : NULL);
					break;
			}
		}

		$stmt->execute();

		return $this->dataHandler->lastInsertId();
	}

	public function calculateTotalPrice($products)
	{
		$products   = explode(',', $products);
		$totalPrice = 0;

		foreach ($products as $product) {
			$model   = new Product();
			$product = $model->get((int)$product);

			$totalPrice += $product['price'];
		}

		return $totalPrice;
	}

	public function getFirstRelationProductName($order_id)
	{
		$query = "SELECT products.name FROM product_order JOIN products ON product_order.product_id = products.id WHERE product_order.order_id = :order_id";

		$stmt = $this->dataHandler->preparedQuery($query);
		$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		$data = $stmt->fetch();

		return $data['name'];
	}

	public function insertRelationProduct($id_product, $order_id)
	{
		try {

			$query = "INSERT INTO product_order (product_id, order_id) VALUES (:id_product, :order_id)";

			$stmt = $this->dataHandler->preparedQuery($query);
			$stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
			$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

			$stmt->execute();

		} catch (Exception $e) {

		}

	}
}
