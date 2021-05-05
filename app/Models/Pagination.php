<?php

namespace App\Models;

class Pagination
{
    public $curPage;
    public $totalPages;

    function __construct($curPage, $totalPages)
    {
        $this->curPage = $curPage;
        $this->totalPages = $totalPages;
    }
}
