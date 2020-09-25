<?php 
namespace Core\Model;
use PDO;

class DB {
    private static $_instance = null;

    private $DB;


    public function __construct(){
 
        $user = "root";
        $password ="";
        try
        {
            $db = new PDO ('mysql:host=localhost;dbname=projet5', $user, $password);
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
   




    public function findAll(string $table){
        try
        {
            $sqlQuery = 'SELECT * from '. $table;
            
            $result = [];
 
            foreach(  $this->DB->query($sqlQuery) as $row){
                array_push($result, $row);
            }
        }catch(PDOException $e){
            var_dump( "Erreur : " .$e->getMessage()."<br>");die;
        }
      
        return $result ;
       

    }

    public function findWhere(string $table, array $params){
        try
        {
            $sqlQuery = 'SELECT * from '. $table . ' WHERE ';

            foreach ($params as $param){
                $sqlQuery.= key($params) ." = '" . $param . "'";
            }
            
            $result = [];
          
            foreach(  $this->DB->query($sqlQuery) as $row){
                array_push($result, $row);
            }
        }catch(PDOException $e){
            "Erreur : " .$e->getMessage()."<br>";die;
        }
   
        return $result ;
       

    }

    
}