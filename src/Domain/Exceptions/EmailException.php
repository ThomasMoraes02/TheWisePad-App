<?php 
namespace TheWisePad\Domain\Exceptions;

use DomainException;

class EmailException extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct("E-mail is invalid: $email");
    }
}