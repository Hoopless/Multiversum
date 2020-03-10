<?php

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

$request     = $_SERVER['REQUEST_URI'];
$trimmed_url = trim($request, '/');
$url         = explode('?', $trimmed_url, 2);


header('Access-Control-Allow-Origin: *');

require 'controller/RequestController.php';

$controller = new RequestController();
$controller->handleRequest($url[0]);


