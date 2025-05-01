<?php
namespace Models;
use Core\Database;

class Phrase
{
    private $connection;
    private $table;
    private $primaryKey;
    private $columns;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->table = 'phrases';
        $this->primaryKey = 'id';
        $this->columns = ['phrase'];
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":{$this->primaryKey}", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function filter($ids_mood)
    {
        $sql = "SELECT * FROM mood_phrases WHERE mood_id in(:ids_mood)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":ids_mood", $ids_mood);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}