<?php

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

$request  = $_SERVER['REQUEST_URI'];
$base_uri = "api/v1";

$trimmed_url = trim($request, '/');
$url         = explode('?', $trimmed_url, 2);


header('Access-Control-Allow-Origin: *');

switch ($url[0]) {
    case $base_uri . "/mail":
        require 'controller/MailableController.php';

        $controller = new MailableController();
        echo $controller->sendEmail();

        break;

    case $base_uri . "/products":
        require 'controller/ProductController.php';

        $controller = new ProductController();
        echo $controller->index();
        break;

    case $base_uri . '/product':

        require 'controller/ProductController.php';

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $controller = new ProductController();
            echo $controller->create();
        }

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $controller = new ProductController();
            echo $controller->show($_GET['id']);
        }

        break;
    case "/view/image/":

        break;

    case "":
        require "./view/build/index.html";
        break;

    default:
        $assetURL = "./view/build/{$url[0]}";
        if (file_exists($assetURL)) {
            $contentType = mime_content_type($assetURL);
            header("Content-Type: {$contentType}");

            require $assetURL;
        } else {
            require './view/build/index.html';
        }
}
