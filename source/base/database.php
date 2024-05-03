<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'ZZWarehouse';
    private $username = 'root';
    private $password = '';
    private $dbHandler;
    private $statement;
    private $error;

    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        
        // Create a new PDO instance
        try {
            $this->dbHandler = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function beginTransaction() {
        $this->inTransaction = true;
        return $this->dbHandler->beginTransaction();
    }

    public function commit() {
        $this->inTransaction = false;
        return $this->dbHandler->commit();
    }

    public function rollBack() {
        $this->inTransaction = false;
        return $this->dbHandler->rollBack();
    }

    public function query($sql) {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    public function bind($parameter, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    public function execute() {
        return $this->statement->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function single() {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount() {
        return $this->statement->rowCount();
    }
}

?>