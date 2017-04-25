<?php namespace GamingPassion\Factories;

use GamingPassion\Database;
use GamingPassion\Mappers\UserMapper;
use GamingPassion\Models\User;
use GamingPassion\Validators\UsernameValidator;

class UserFactory
{
    private $database;

    function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getUserByUsername($username) : User
    {
        $validationResponse = UsernameValidator::validateUsername($this->database, $username);

        if($validationResponse->hasError)
            return $validationResponse->error->message;

        $databaseResponse = $this->database->connection->query( "SELECT * FROM `users` WHERE username = '{$validationResponse->validatedField}' LIMIT 1");
        $row = $databaseResponse->fetch_assoc();

        return UserMapper::map($row);
    }
}