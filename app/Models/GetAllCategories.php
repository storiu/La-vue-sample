<?php

namespace App\Models;

class GetAllCategories
{
    public $categories = [];

    function __construct($dbData)
    {
        foreach ($dbData as $entry) {
            $category = new Category($entry);
            array_push($this->categories, $category);
        }
    }
}

class Category
{
    public $id;
    public $name;
    public $icon;

    function __construct($dbData)
    {
        $this->id = $dbData->id;
        $this->name = $dbData->name;
        $this->icon = $dbData->icon;
    }
}
