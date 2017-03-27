<?php namespace GamingPassion;

use GamingPassion\Models\User;
use GamingPassion\Models\ValidationResponse;

class Database
{
    public $connection;

    function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getUserByUsername($username)
    {
        $validationResponse = $this->validateUsername($username);

        if($validationResponse->hasError)
            return $validationResponse->error->message;

        $databaseResponse = $this->connection->query( "SELECT * FROM `users` WHERE username = '{$validationResponse->validatedField}' LIMIT 1");
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

    private function validateUsername($username) : ValidationResponse
    {
        $response = new ValidationResponse();

        if(empty($username))
        {
            $response->addError("Username cannot be empty.");
            return $response;
        }

        $response->validatedField = $this->connection->real_escape_string($username);

        return $response;
    }
}
