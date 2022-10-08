<?php

require_once __DIR__ . '/settings.php';

class DatabaseHandler {

    public static function connect() {
        $cfg = getSettings()['database'];

        try {
            return new PDO(
                'mysql:host=' . $cfg['host'] . 
                ';dbname=' . $cfg['name'],
                $cfg['username'],
                $cfg['password']
            );
        } catch (PDOException $e) {
            print_r("PDO Error : " . $e->getMessage());
            die();
        }
    }
}