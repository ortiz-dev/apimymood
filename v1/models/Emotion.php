<?php
namespace Models;
use Core\Database;

class Emotion
{
    private $connection;
    private $table;
    private $primaryKey;
    private $columns;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->table = 'emotions';
        $this->primaryKey = 'id';
        $this->columns = ['name', 'keywords'];
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        $key = array_keys($data)[0];
        $value = array_values($data)[0];
        $sql = "SELECT * FROM {$this->table} WHERE {$key} = :$key";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":{$key}", $value);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $columns = implode(', ',$this->columns);
        $values = ':'.implode(', :',$this->columns);
        $sql = "INSERT INTO {$this->table}({$columns}) VALUES({$values})";
        $stmt = $this->connection->prepare($sql);
        foreach($data as $key => $value){
            if(in_array($key, $this->columns)){
                $stmt->bindValue(":{$key}", $value);
            }
        }
        $stmt->execute();
        return $stmt->rowCount();
    }
}