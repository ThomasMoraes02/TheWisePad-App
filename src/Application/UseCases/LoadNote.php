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
        $notes = $this->noteRepository->findAllNotesFrom(new Email($request['email']));

        if(empty($notes)) {
            return ['Notes not found'];
        }
        
        return $notes;
    }
}