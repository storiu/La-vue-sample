<?php

namespace App\Models;

class GetFollowing
{
    public $user;
    public $following = [];

    function __construct($userData, $followingData)
    {
        $this->user = new User($userData);
        foreach ($followingData as $entry) {
            array_push($this->following, new User($entry));
        }
    }
}
