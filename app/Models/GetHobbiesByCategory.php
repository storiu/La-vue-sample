<?php

namespace App\Models;

class GetHobbiesByCategory
{
    public $category;
    public $hobbies = [];
    public $pagination;

    function __construct($categoryInfoData, $hobbiesInfoData, $paginationData)
    {
        $this->category = new Category($categoryInfoData);

        foreach ($hobbiesInfoData as $dbData) {
            array_push($this->hobbies, new GetHobbies($dbData));
        }

        $this->pagination = $paginationData;
    }
}

class GetHobbies
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

    function __construct($hobbiesInfoData)
    {
        $this->id = $hobbiesInfoData->pid;
        $this->title = $hobbiesInfoData->title;
        $this->date = $hobbiesInfoData->date;
        $this->author = new User($hobbiesInfoData);
        $this->category_id = $hobbiesInfoData->category_id;
        $this->description = $hobbiesInfoData->description;
        $this->rating = $hobbiesInfoData->rating;
        $this->photo = $hobbiesInfoData->photo;
        $this->commentsNb = $hobbiesInfoData->commentsNb;
    }
}

class Category
{
    public $id;
    public $name;
    public $icon;

    function __construct($categoryInfoData)
    {
        $this->id = $categoryInfoData->id;
        $this->name = $categoryInfoData->name;
        $this->icon = $categoryInfoData->icon;
    }
}
