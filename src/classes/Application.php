<?php

namespace Sooky\DatabaseImport\classes;

class Application
{
    public \PDO $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function run()
    {
        echo 'Working';
    }

    public function initDatabase()
    {
        $this->db->migrate();
    }

    public function dropDatabase()
    {
        $this->db->drop();
    }
}