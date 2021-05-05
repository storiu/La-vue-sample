<?php

namespace App\Models;

class GetFollowers
{
    public $user;
    public $followers = [];

    function __construct($userData, $followersData)
    {
        $this->user = new User($userData);
        foreach ($followersData as $entry) {
            array_push($this->followers, new User($entry));
        }
    }
}
