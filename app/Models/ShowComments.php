<?php

namespace App\Models;

class ShowComments
{
    public $comments = [];
    public $pagination;

    function __construct($dbData, $paginationData)
    {
        foreach ($dbData as $entry) {
            array_push($this->comments, new Comment($entry));
        }

        $this->pagination = $paginationData;
    }
}

class Comment
{
    public $id;
    public $author;
    public $content;

    public function __construct($dbData)
    {
        $this->id = $dbData->cid;
        $this->author = new User($dbData);
        $this->content = $dbData->content;
    }
}
