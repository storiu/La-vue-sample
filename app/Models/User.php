<?php

namespace App\Models;

class User
{
    public $id;
    public $name;
    public $nickname;
    public $email;
    public $avatar;
    public $is_admin;

    function __construct($dbData)
    {
        $this->id = $dbData->id;
        $this->name = $dbData->name;
        $this->nickname = $dbData->nickname;

        if (isset($dbData->email)) {
            $this->email = $dbData->email;
        }

        $this->avatar = $dbData->avatar;

        if (isset($dbData->is_admin)) {
            $this->is_admin = $dbData->is_admin === 1;
        }
    }
}
