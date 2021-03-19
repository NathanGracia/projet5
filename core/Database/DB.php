<?php 
namespace Core\Model;
use PDO;
use PDOException;

class DB {
    private static $_instance = null;

    private $DB;


    public function __construct(){
 
        $user = "root";
        $password ="";
        try
        {
            $db = new PDO ('mysql:host=localhost;dbname=projet5', $user, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            ]);
        }catch(PDOException $e){
            print "Erreur : " .$e->getMessage()."<br>";die;
        }
     
        $this->DB = $db;
      
         
    }
    public static function getInstance() {
 
        if(is_null(self::$_instance)) {
            self::$_instance = new DB();  
        
        }
  
        return self::$_instance;
      }
   






    
}