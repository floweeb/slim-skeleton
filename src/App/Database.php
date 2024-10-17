<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(
        private string $db_type,
        private string $host,
        private string $db_name,
        private string $user,
        private string $password,
        private string $port,
    ) {}
    public function getConnection(): PDO
    {
        if ($this->db_type == "pgsql") {
            $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->db_name";
        } else {
            $dsn = "mysql:host=$this->host;dbname=$this->db_name;port=$this->port;charset=utf8";
        }

        return new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
