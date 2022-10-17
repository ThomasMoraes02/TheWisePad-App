<?php 
namespace TheWisePad\Domain\Exceptions;

use DomainException;

class NoteNotFound extends DomainException
{
    public function __construct()
    {
        parent::__construct("Note not found");
    }
}