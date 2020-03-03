<?php


class Product
{

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" .
                             $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    /**
     * @return string
     * @throws Exception
     */
    public function create()
    {

        try {

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


            $stmt = $this->pdo->prepare($query);
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

    /**
     * @param Int $id
     * @return array
     * @throws Exception
     */
    public function get($id){

        if (! empty($id)) {

            try {

                $query = "SELECT *  ";
                $query .= "FROM products ";

                $query .= "WHERE id = :id";

                $stmt = $this->pdo->prepare($query);

                $stmt->bindParam(':id', $id);

                $stmt->execute();

                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $data = $stmt->fetchAll();

                return $data;

            } catch(Exception $e) {
                Throw new Exception($e->getMessage(), (int)$e->getCode());
            }


        } else {
            return ["No ID specified! please try again"];
        }
    }

    public function getAll()
    {
        try {

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


            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);


            $data = $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $data;
    }


}