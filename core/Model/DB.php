<?php 
namespace Core\Model;
use PDO;

class DB {
    private $db;


    public function __construct(){
        
        $user = "root";
        $password ="";
        try
        {
            $db = new PDO ('mysql:host=localhost;dbname=projet5', $user, $password);
        }catch(PDOException $e){
            print "Erreur : " .$e->getMessage()."<br>";die;
        }
        $this->db = $db;
        return $db;
         
    }

        /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db): void
    {
        $this->db = $db;
    }



    public function findAll(String $table){
        try
        {
            $sqlQuery = 'SELECT * from '. $table;
            $result = [];
            foreach( $this->db->query($sqlQuery) as $row){
                array_push($result, $row);
            }
        }catch(PDOException $e){
            var_dump( "Erreur : " .$e->getMessage()."<br>");die;
        }
      
        return $result ;
       

    }

    
}