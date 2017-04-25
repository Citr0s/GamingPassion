<?php namespace GamingPassion\Validators;

use GamingPassion\Models\ValidationResponse;

class UsernameValidator
{
    public static function validateUsername($database, $username) : ValidationResponse
    {
        $response = new ValidationResponse();

        if(empty($username))
        {
            $response->addError("Username cannot be empty.");
            return $response;
        }

        $response->validatedField = $database->connection->real_escape_string($username);

        return $response;
    }
}