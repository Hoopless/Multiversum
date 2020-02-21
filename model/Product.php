<?php


class Product
{

    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var number $price
     */
    public $price;

    /**
     * @var string $ean
     */
    public $ean;

    /**
     * @var string $release_date
     */
    public $release_date;

    /**
     * @var boolean $sale
     */
    public $sale;

    /**
     * @var Stock $stock
     */
    public $stock;

    /**
     * @var string $edited_at
     */
    public $edited_at;
    /**
     * @var object
     */
    public $products;

    /**
     * @param array $data
     * @throws Exception
     */
    public function create($data)
    {


        try {

            $pdo = new PDO(DB::DSN, DB::USERNAME, DB::PASSWORD);
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
        $pdo = new PDO(DB::DSN, DB::USERNAME, DB::PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT *  ";
        $query .= "FROM products";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS);

        $this->products = $stmt->fetchAll();

        return $this->products;
    }


}