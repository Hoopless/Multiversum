<?php


class Product
{

    /**
     * @param array $data
     * @throws Exception
     */
    public function create($data)
    {


        try {

            $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=".  $_ENV['DB_PORT'] .";dbname=" . $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "INSERT INTO products (name, description, price, ean, release_date, sale) ";
            $query .= "VALUES (:name, :description, :price, :ean, :release_date, :sale)";


            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':name', $data['name']);
            $stmt->bindValue(':description', $data['description']);
            $stmt->bindValue(':price', $data['price']);
            $stmt->bindValue(':ean', $data['ean']);
            $stmt->bindValue(':release_date', $data['release_date']);
            $stmt->bindValue(':sale', $data['sale']);
            $stmt->execute();


            $stmt->setFetchMode(PDO::FETCH_CLASS);


            foreach ($stmt->fetchAll() as $key => $value) {
                echo $value->firstname;
            }

        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

    }

    public function getAll()
    {
        $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=".  $_ENV['DB_PORT'] .";dbname=" . $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT *  ";
        $query .= "FROM products";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $debug = 1;

        $data = $stmt->fetchAll();

        return $data;
    }


}