<?php

namespace App\Models;

class Error
{
    public $error;

    function __construct($message)
    {
        $this->error = new ErrorMessage($message);
    }
}

class ErrorMessage
{
    public $message;

    function __construct($message)
    {
        $this->message = $message;
    }
}
