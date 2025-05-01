<?php
namespace Models;
use Core\Database;

class Mood
{
    private $connection;
    private $table;
    private $primaryKey;
    private $columns;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->table = 'moods';
        $this->primaryKey = 'id';
        $this->columns = ['emotion'];
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":{$this->primaryKey}", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function filter($data)
    {
        if($data){
            $sql = "SELECT GROUP_CONCAT(id) as id_moods FROM {$this->table} ";
            foreach($data as $emotion){
                if(strpos($sql, 'WHERE')){
                    $sql.=" OR emotion like :$emotion";
                }else{
                    $sql.="WHERE emotion like :$emotion";
                }
            }
            $stmt = $this->connection->prepare($sql);
            foreach($data as $emotion){
                $stmt->bindValue(":{$emotion}", "%$emotion%");
            }
            $stmt->execute();
            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($response){
                return $response[0]['id_moods'];
            }
            return null;
        }
        return null;
    }

}