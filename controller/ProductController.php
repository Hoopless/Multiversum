<?php

require "model/Product.php";

header("Cache-Control: stale-while-revalidate=3600");

class ProductController
{
    public function index()
    {
        header('Content-Type: application/json');


        $product  = new Product;
        $products = $product->getAll();

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

    public function show($id){

        header('Content-Type: application/json');

        $product = new Product;


        return json_encode($product->get($id));

    }

    public function create()
    {
        header('Content-Type: application/json');

        $product = new Product;
        try {
           return  json_encode($product->create());
        } catch (Exception $e) {
            return die($e);
        }
    }
}
