<?php
//zorgen dat je gegevens in andere file zet
class Dbh {

    protected $server;
    protected $username;
    protected $password;
    protected $table;
    protected $engine;
    protected $charset = "testdb";


    public function connect() {
        $this->server = 'localhost';
        $this->username = '83502';
        $this->password = "xS33&j3hYajj06*99vud^0M6";
        $this->table = '83502_DB';
        $this->charset = 'utf8mb4';
        $this->engine = "MySqli";

        try {
            $dsn = "mysql:host=".$this->server.";dbname=".$this->table.";charset=".$this->charset;//.";engine=".$this->engine;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (Exception $e) {
            echo "Connection failed: ".$e->getMessage();
        }
    }
}