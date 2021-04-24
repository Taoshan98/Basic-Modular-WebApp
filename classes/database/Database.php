<?php

class Database
{
    private $Host;
    private $DBName;
    private $DBUser;
    private $DBPassword;
    private $pdo;
    private $sQuery;
    private $bConnected = false;
    private $parameters;
    private $queryCount = 0;

    public function __construct($Host, $DBName, $DBUser, $DBPassword)
    {
        $this->Host = $Host;
        $this->DBName = $DBName;
        $this->DBUser = $DBUser;
        $this->DBPassword = $DBPassword;
        $this->Connect();
        $this->parameters = array();
    }


    private function Connect(): void
    {
        try {
            $this->pdo = new PDO('mysql:dbname=' . $this->DBName . ';host=' . $this->Host, $this->DBUser, $this->DBPassword, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
            ));
            $this->bConnected = true;
        } catch (PDOException $e) {
            echo $e;
            die();
        }
    }

    private function Init($query, $parameters = array())
    {
        if (!$this->bConnected) {
            $this->Connect();
        }
        try {
            $this->parameters = $parameters;
            $this->sQuery = $this->pdo->prepare($this->BuildParams($query, $this->parameters));

            if (!empty($this->parameters)) {
                if (array_key_exists(0, $parameters)) {
                    $parametersType = true;
                    array_unshift($this->parameters, "");
                    unset($this->parameters[0]);
                } else {
                    $parametersType = false;
                }
                foreach ($this->parameters as $column => $value) {
                    $this->sQuery->bindParam($parametersType ? intval($column) : ":" . $column, $this->parameters[$column]); //It would be query after loop end(before 'sQuery->execute()').It is wrong to use $value.
                }
            }

            $success = $this->sQuery->execute();
            $this->queryCount++;
        } catch (PDOException $e) {
            echo $e;
            die();
        }

        $this->parameters = array();

        return $success;
    }

    private function BuildParams($query, $params = null)
    {
        if (!empty($params)) {
            $rawStatement = explode(" ", $query);
            foreach ($rawStatement as $value) {
                if (strtolower($value) === 'in') {
                    return str_replace("(?)", "(" . implode(",", array_fill(0, count($params), "?")) . ")", $query);
                }
            }
        }
        return $query;
    }

    public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $query = trim($query);
        $rawStatement = explode(" ", $query);
        $this->Init($query, $params);
        $statement = strtolower($rawStatement[0]);
        if ($statement === 'select' || $statement === 'show') {
            return $this->sQuery->fetchAll($fetchmode);
        }

        if ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        }

        return NULL;
    }
    
}
