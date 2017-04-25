<?php namespace GamingPassion\Factories;

use GamingPassion\Database;
use GamingPassion\Models\User;
use GamingPassion\Validators\UsernameValidator;

class UserFactory
{
    private $database;

    function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getUserByUsername($username)
    {
        $validationResponse = UsernameValidator::validateUsername($this->database, $username);

        if($validationResponse->hasError)
            return $validationResponse->error->message;

        $databaseResponse = $this->database->connection->query( "SELECT * FROM `users` WHERE username = '{$validationResponse->validatedField}' LIMIT 1");
        $row = $databaseResponse->fetch_assoc();

        $response = new User();

        $response->username = $row['username'];
        $response->email = $row['email'];
        $response->gender = $row['gender'];
        $response->home = $row['home'];
        $response->active = $row['active'];
        $response->joined = $row['joined'];
        $response->thumbnail = $row['thumbnail'];
        $response->status = $row['status'];

        return $response;
    }
}