<?php namespace GamingPassion;

class Database
{
    public $connection;

    function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }
}
