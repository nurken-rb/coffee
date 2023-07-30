<?php


class DataBase
{
    private string $host = "localhost";
    private string $db_name = "test";
    private string $username = "root";
    private string $password = "gazeta123";
    public PDO $conn;

    public function getConnection(): ?PDO
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            return null;
        }

        return $this->conn;
    }
}

// create table position
//(
//    id      int auto_increment
//        primary key,
//    date    date         not null,
//    sum     int          not null,
//    comment varchar(100) null
//);