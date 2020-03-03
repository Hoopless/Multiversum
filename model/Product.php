<?php


class Product
{

    /**
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function create()
    {

        try {

            $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" .
                           $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $array = [
                'name',
                'description',
                'price',
                'platform',
                'resolution',
                'refresh_rate',
                'input_type',
                'included_info',
                'colour',
                'warranty',
                'ean',
                'sku',
                'brand',
                'image_url',
                'in_sale',
            ];

            $query = "INSERT INTO products (";
            foreach ($array as $key => $value) {
                $query .= "{$value}";
                ($key !== count($array) - 1) ? $query .= ", " : "";
            }
            $query .= ") ";

            $query .= "VALUES (";
            foreach ($array as $key => $value) {
                $query .= ":{$value}";
                ($key !== count($array) - 1) ? $query .= ", " : "";
            }
            $query .= ") ";


            $stmt = $pdo->prepare($query);
            if (isset($_POST['name'])) {
                $stmt->bindValue(':name', $_POST['name']);
            } else {
                return "Not created, there was no name set.";
            }

            foreach ($array as $value) {
                $text = ":" . $value;
                $stmt->bindValue($text, isset($_POST[$value]) ? $_POST[$value] : NULL);
            }
            $stmt->execute();

        } catch (Exception $e) {
            throw new Exception ($e->getMessage(), (int)$e->getCode());
        }

    }

    public function getAll()
    {
        try {

            $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" .
                           $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT *  ";
            $query .= "FROM products ";

            $sales = isset($_GET["sales"]) ? (boolean)$_GET["sales"] : NULL;

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


            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);


            $data = $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $data;
    }


}