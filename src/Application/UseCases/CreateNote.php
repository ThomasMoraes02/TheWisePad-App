<?php 
namespace TheWisePad\Application\UseCases;

use DomainException;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\Note\NoteRepository;
use TheWisePad\Domain\User\UserRepository;

class CreateNote implements UseCase
{
    private $noteRepository;

    private $userRepository;

    public function __construct(NoteRepository $noteRepository, UserRepository $userRepository)
    {
        $this->noteRepository = $noteRepository;
        $this->userRepository = $userRepository;
    }

    public function perform(array $request)
    {
        $user = $this->userRepository->findByEmail(new Email($request['email']));
        $newNote = new Note($user, $request['title'], $request['content']);

        $userNotes = $this->noteRepository->findAllNotesFrom($user->getEmail());

        if(!empty($userNotes)) {
            array_filter($userNotes, function($note) use ($newNote) {

                if($newNote->getTitle() == $note['title']) {
                    throw new DomainException("Note already exists: " . $note['title']);
                }
            });
        }

        $this->noteRepository->addNote($newNote);
        
        return [
            'Note created'
        ];
    }
}