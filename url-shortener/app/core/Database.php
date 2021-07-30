<?php

namespace core;


use PDO;


class Database
{
    use Singleton;

    private PDO $dbh;


    /**
     * Database constructor.
     */
    private function __construct()
    {
        $config = config('db');

        $this->dbh = new PDO('mysql:dbname=' . $config['dbname'] . ';host=' . $config['host'],
            $config['user'], $config['password']);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    /**
     * Execute SQL
     * @param string $sql This must be a valid SQL statement for the target database server.
     * @param array $data An array of values with as many elements as there are bound parameters in the SQL statement being executed
     * @return bool TRUE on success or FALSE on failure.
     */
    public function execute(string $sql, array $data = []): bool
    {
        $sth = $this->dbh->prepare($sql);
        return $sth->execute($data);
    }


    /**
     * Query Object
     * @param string $sql This must be a valid SQL statement for the target database server.
     * @param array $data An array of values with as many elements as there are bound parameters in the SQL statement being executed
     * @param string $className Class name or object
     * @return object|bool Returns Object or FALSE on failure
     */
    public function query(string $sql, array $data = [], string $className = ''): object|bool
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($data);
        $sth->setFetchMode(PDO::FETCH_CLASS, $className);
        return $sth->fetch();
    }


    /**
     * Get the ID of the last row that was inserted into the database
     * @return string returns a string representing the row ID
     */
    public function lastInsertId(): string
    {
        return $this->dbh->lastInsertId();
    }

}