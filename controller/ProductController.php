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
                'price' => (float) $product['price'],
                'in_sale' => (boolean) $product['in_sale'],
                'image_url' => $product['image_url'],
            ];
        }

        return json_encode($pushed_data);
    }
}