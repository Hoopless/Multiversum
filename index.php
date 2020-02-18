<?php

require "vendor/autoload.php";

echo getenv('DB_HOST');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


