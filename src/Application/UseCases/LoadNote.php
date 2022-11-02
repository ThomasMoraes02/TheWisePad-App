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
        $request['page'] = (isset($request['page'])) ? $request['page'] : 0;
        $request['per_page'] = (isset($request['per_page'])) ? $request['per_page'] : 0;

        $notes = $this->noteRepository->findAllNotesFrom(new Email($request['email']), $request['page'], $request['per_page']);

        if(empty($notes)) {
            return ['Notes not found'];
        }
        
        return $notes;
    }
}