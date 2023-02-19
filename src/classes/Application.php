<?php

namespace Sooky\DatabaseImport\classes;

use PDO;
use Sooky\DatabaseImport\interfaces\Reader;

class Application
{
    public PDO $db;
    public Reader $reader;
    public array $params;
    public Preparator $preparator;
    public static PDO $database;

    public function __construct($config)
    {
        $db = Database::getInstance($config['db']);

        $this->preparator = new Preparator();
        $this->reader = new CsvReader();
        $this->db = $db;
        $this->params = $config['params'];
        self::$database = $db;
    }

    public function import(): void
    {
        foreach($this->params as $param) {
            $readData = $this->reader->read($param);
            $data = $this->prepare($readData);

            foreach ($data as $d) {
                $product = Product::findOne(['sku' => $d['sku']]);

                if(!$product) {
                    $product = new Product();
                }

                $product->load($d);
                $product->save();
            }

            echo 'Database updated' . PHP_EOL;

        }
    }

    protected function prepare($readData)
    {
        return $this->preparator->prepare($readData);
    }

    public function initDatabase(): void
    {
        $this->db->migrate();
    }

    public function dropDatabase(): void
    {
        $this->db->drop();
    }
}