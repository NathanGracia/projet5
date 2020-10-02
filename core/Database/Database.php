<?php

namespace Core\Database;

use PDO;

class Database
{
    private static $instance = null;

    private $db;

    private function __construct()
    {
        $user = "root";
        $password ="";
        try
        {
            $this->db = new PDO ('mysql:host=localhost;dbname=projet5', $user, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            ]);
        }catch(PDOException $e){
            print "Erreur : " .$e->getMessage()."<br>";die;
        }
    }

    public static function getDatabase(): Database
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query(string $statement, array $parameters = [], string $classFQN = null, bool $oneResult = false)
    {
        $request = $this->db->prepare($statement);

        if ($classFQN) {
            $request->setFetchMode(PDO::FETCH_CLASS, $classFQN);
        }

        $request->execute($parameters);

        if ($oneResult) {
            return $request->fetch();
        }

        return $request->fetchAll();
    }
}