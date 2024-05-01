<?php

class DB
{
    private $host = "db";
    private $port = "5432";
    private $user = "testuser";
    private $pwd = "testpwd";
    private $dbname = "testdb";

    public function connect()
    {
        $dsn = "pgsql:host=". $this->host .";port=". $this->port.";dbname=". $this->dbname;
        $this->pdo = new PDO($dsn, $this->user, $this->pwd);
    }




}