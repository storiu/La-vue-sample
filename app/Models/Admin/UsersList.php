<?php

namespace App\Models\Admin;

use App\Models\User;

class UsersList
{
    public $users = [];
    public $pagination;

    function __construct($usersData, $paginationData)
    {
        foreach($usersData as $entry) {
            array_push($this->users, new User($entry));
        }

        $this->pagination = $paginationData;
    }
}
