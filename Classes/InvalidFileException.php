<?php

class InvalidFileException extends Exception 
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code)
    }
}