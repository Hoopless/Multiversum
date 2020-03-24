<?php

require "model/Product.php";

header("Cache-Control: stale-while-revalidate=3600");

class ProductController
{
	public function __construct()
	{
		$this->product = new Product;
	}

	public function index()
	{
		header('Content-Type: application/json');

		$products = $this->product->getAll();

		$pushed_data = [];

		foreach ($products as $product) {
			$pushed_data[] = [
				'id'        => (int)$product['id'],
				'name'      => $product['name'],
				'price'     => (float)$product['price'],
				'in_sale'   => (boolean)$product['in_sale'],
				'image_url' => $product['image_url'],
			];
		}

		return json_encode($pushed_data);
	}

	public function show($id)
	{

		header('Content-Type: application/json');

		return json_encode($this->product->get($id));

	}

	public function update($data)
	{

		if (! $this->product->update($data)){
			$id_product = $data["id"];
			return json_encode(['message' => "failed to update product with id {$id_product}"]);
		}

		return json_encode(['message' => 'succesfully updated product']);

	}

	public function create()
	{
		header('Content-Type: application/json');

		$product = new Product;
		try {
			return json_encode($product->create());
		} catch (Exception $e) {
			return die($e);
		}
	}
}
