<?php 
namespace TheWisePad\Application\UseCases;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\NoteRepository;

class LoadNote implements UseCase
{
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function perform(array $request)
    {
        return $this->noteRepository->findAllNotesFrom(new Email($request['email']));
    }
}