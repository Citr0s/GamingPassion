<?php namespace GamingPassion\Mappers;

use GamingPassion\Models\User;

class UserMapper
{
    public static function map($record) : User
    {
        $response = new User();

        $response->username = $record['username'];
        $response->email = $record['email'];
        $response->gender = $record['gender'];
        $response->home = $record['home'];
        $response->active = $record['active'];
        $response->joined = $record['joined'];
        $response->thumbnail = $record['thumbnail'];
        $response->status = $record['status'];

        return $response;
    }
}