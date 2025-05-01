<?php
namespace Models;
use Core\Database;

class DailyMood
{
    private $connection;
    private $table;
    private $primaryKey;
    private $columns;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->table = 'daily_moods';
        $this->primaryKey = 'id';
        $this->columns = ['user_id', 'state', 'phrase_id', 'daily_date'];
    }

    public function all($id_user)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":user_id", $id_user);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id_user, $date)
    {
        $sql = "SELECT * FROM {$this->table} WHERE  user_id = :user_id AND daily_date = :daily_date";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":user_id", $id_user);
        $stmt->bindValue(":daily_date", $date);
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

    public function lastId()
    {
        return $this->connection->lastInsertId();
    }
}