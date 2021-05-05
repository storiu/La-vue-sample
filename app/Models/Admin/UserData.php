<?php

namespace App\Models\Admin;

class UserData
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
        $this->email = $dbData->email;
        $this->avatar = $dbData->avatar;
        $this->is_admin = $dbData->is_admin === 1;
    }
}
