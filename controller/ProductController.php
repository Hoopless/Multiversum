<?php


class ProductController
{
    public function index()
    {
        header('Content-Type: application/json');

        require "model/Product.php";

        $product  = new Product;
        $products = $product->getAll();

        $pushed_data = [];

        foreach ($products as $product) {
            $pushed_data[] = [
                'id'    => $product['id'],
                'name'  => $product['name'],
                'price' => $product['price'],
            ];
        }

        return json_encode($pushed_data);
    }
}