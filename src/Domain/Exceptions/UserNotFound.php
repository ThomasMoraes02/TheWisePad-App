<?php 
namespace TheWisePad\Domain\Exceptions;

use DomainException;

class UserNotFound extends DomainException
{
    public function __construct()
    {
        parent::__construct("User not found");
    }
}