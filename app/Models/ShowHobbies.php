<?php

namespace App\Models;

class ShowHobbies
{
    public $hobbies = [];
    public $pagination;

    function __construct($dbData, $paginationData)
    {
        foreach($dbData as $entry) {
            array_push($this->hobbies, new Hobby($entry));
        }

        $this->pagination = $paginationData;
    }
}

class Hobby
{
    public $id;
    public $title;
    public $date;
    public $author;
    public $category_id;
    public $description;
    public $rating;
    public $photo;
    public $commentsNb;

    public function __construct($dbData)
    {
        $this->id = $dbData->pid;
        $this->title = $dbData->title;
        $this->date = $dbData->date;
        $this->author = new User($dbData);
        $this->category_id = $dbData->category_id;
        $this->description = $dbData->description;
        $this->rating = $dbData->rating;
        $this->photo = $dbData->photo;
        $this->commentsNb = $dbData->commentsNb;
    }
}
