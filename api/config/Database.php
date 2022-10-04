<?php

class DatabaseHandler {
    private $host = 'locahost';
    private $db_name = 'annuaire_nws';
    private $username = 'root';
    private $password = '';
    private $dbh;

    public function connect()
    {
        $this->dbh = null;

        try {
            $this->dbh = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
        } catch (PDOException $e) {
            print_r("PDO Error : " . $e->getMessage());
            die();
        }

        return $this->dbh;
    }
}