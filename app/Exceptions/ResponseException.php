<?php

namespace App\Exceptions;

use Exception;

class ResponseException extends Exception
{
    public function report()
    {
        return false;
    }

}
