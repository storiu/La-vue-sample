<?php

namespace App\Models;

class GetSingleUserHobbies
{
    public $user;
    public $hobbies = [];
    public $pagination;

    function __construct($userInfoDbData, $hobbiesInfoDbData, $paginationData)
    {
        $this->user = new GetSingleUserHobbiesUser($userInfoDbData);
        foreach ($hobbiesInfoDbData as $dbData) {
            array_push($this->hobbies, new GetSingleUserHobbiesHobby($userInfoDbData, $dbData));
        }
        $this->pagination = $paginationData;
    }
}

class GetSingleUserHobbiesUser
{
    public $id;
    public $name;
    public $nickname;
    public $avatar;
    public $followers;
    public $following;
    public $followed;

    public function __construct($userInfoDbData)
    {
        $this->id = $userInfoDbData->id;
        $this->name = $userInfoDbData->name;
        $this->nickname = $userInfoDbData->nickname;
        $this->avatar = $userInfoDbData->avatar;
        $this->followers = $userInfoDbData->followers;
        $this->following = $userInfoDbData->following;
        $this->followed = $userInfoDbData->followed == 1;
    }
}

class GetSingleUserHobbiesHobby
{
    public $id;
    public $title;
    public $date;
    public $category_id;
    public $description;
    public $rating;
    public $photo;
    public $author;
    public $commentsNb;

    function __construct($userInfoDbData, $hobbyInfoDbData)
    {
        $this->id = $hobbyInfoDbData->id;
        $this->title = $hobbyInfoDbData->title;
        $this->author = new User($userInfoDbData);
        $this->date = $hobbyInfoDbData->date;
        $this->category_id = $hobbyInfoDbData->category_id;
        $this->description = $hobbyInfoDbData->description;
        $this->rating = $hobbyInfoDbData->rating;
        $this->photo = $hobbyInfoDbData->photo;
        $this->commentsNb = $hobbyInfoDbData->commentsNb;
    }
}
