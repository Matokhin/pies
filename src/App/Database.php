<?php
namespace App;

class Database {
    public static function connect(): \PDO {
        return new \PDO('mysql:host=localhost;dbname=pirozhki;charset=utf8', 'root', '');
    }
}
