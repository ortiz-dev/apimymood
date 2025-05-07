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

    public function getAll()
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

}