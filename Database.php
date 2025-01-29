<?php
class Database
{
    public $connection;

    public function __construct($config, $username = 'root', $password = '')
    {

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable error mode
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            die("Database connection failed. Check logs for details.");
        }
    }

    public function query($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            return false;
        }
    }
}
