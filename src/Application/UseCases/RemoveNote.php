<?php 
namespace TheWisePad\Application\UseCases;

use TheWisePad\Domain\Note\NoteRepository;

class RemoveNote implements UseCase
{
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function perform(array $request)
    {
        $note = $this->noteRepository->findById($request['id']);
        $this->noteRepository->removeNote($request['id']);
    }
}