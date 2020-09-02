<?php

require_once __DIR__."/../config/Database.php";

class DAO
{
    protected $connection;

    public function __construct()
    {
        try {
            $this->connection = Database::getConnection();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}