<?php

namespace Sooky\DatabaseImport\classes;

use PDO;

class Database extends PDO
{
    private static PDO $instance;

    public function __construct(array $config)
    {
        $dsn = sprintf("mysql:host=%s;dbname=%s", $config['host'], $config['dbname']);
        try {
            parent::__construct($dsn, $config['user'], $config['password']);
        } catch (\PDOException $e) {
            echo "MySql Connection Error: " . $e->getMessage();
        }

        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInstance($config):PDO
    {
        if(!isset(self::$instance)) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function migrate()
    {
        $this->createTable();
        $this->fillTable();
    }

    public function drop()
    {
        $sql = 'DROP TABLE `products`';
        $this->execute($sql, 'Products table deleted');
    }

    protected function createTable()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `products` (
                `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `sku` varchar(64) NOT NULL,
                `ean` char(13) NOT NULL,
                `name` varchar(256) NOT NULL,
                `shortDesc` varchar(512) NOT NULL,
                `manufacturer` varchar(64) NOT NULL,
                `price` decimal(12,5) NOT NULL,
                `stock` int(11) NOT NULL
            );
        ";

        $this->execute($sql, 'Table products created successfully');
    }

    protected function fillTable()
    {
        $sql = "
            INSERT INTO `products` (`sku`, `ean`, `name`, `shortDesc`, `manufacturer`, `price`, `stock`)
            VALUES ('HYG01788', '8436026590546', 'Nitrilové extrém rukavice tmavomodré L, 100ks/bal', 'Nitrilové
            extrém rukavice.', 'Ecolab', '13.99', '62'),('HYG01791', '8430117512738', 'Profesionálny zelený čistiaci
            pad 15x20cm, 10 ks/bal ', 'Profesionálny zelený čistiac pad 15x20 cm, 10 ks/bal.', 'Sanitec', '24.99',
            '4'),('HYG00542', '8436026590584', 'Jednorázové čiapky 100 ks/bal biele', 'Jednorázové čiapky biele, 100
            ks/bal.', 'Ecolab', '8.99', '211'
            );
        ";

        $stmt = self::$instance->query('SELECT `id` FROM `products`');
        $products = $stmt->fetchAll();

        if(empty($products)) {
            $this->execute($sql, 'Table products filled with data');
        } else {
            echo 'Products table is already filled with data' . PHP_EOL;
        }
    }

    protected function execute($sql, $message)
    {
        $stmt = self::$instance->prepare($sql);
        try {
            $stmt->execute();
            echo $message . PHP_EOL;
        } catch(\PDOException $e) {
            echo 'Something went wrong: ' . $e->getMessage() . PHP_EOL;
        }
    }
}