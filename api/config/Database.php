<?php

require_once './settings.php';

class DatabaseHandler {
    private $dbh;

    public function connect() {
        $this->dbh = null;
        $cfg = getSettings()['database'];

        try {
            $this->dbh = new PDO(
                'mysql:host=' . $cfg['host'] . 
                ';dbname=' . $cfg['name'],
                $cfg['username'],
                $cfg['password']
            );
        } catch (PDOException $e) {
            print_r("PDO Error : " . $e->getMessage());
            die();
        }

        return $this->dbh;
    }
}