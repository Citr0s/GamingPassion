<?php namespace GamingPassion\Models;

class ValidationResponse
{
    public $error;
    public $hasError;
    public $validatedField;

    function __construct()
    {
        $this->error = new Error();
    }

    public function addError($message)
    {
        $this->hasError = true;
        $this->error->message = $message;
    }
}