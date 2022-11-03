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
        $request['id'] = (isset($request['id'])) ? $request['id'] : '';

        if($request['id'] != '') {
            $note = $this->noteRepository->findById($request['id']);

            if(empty($note)) {
                return ['Notes not found'];
            }

            return [
                '_id' => $request['id'],
                'title' => $note->getTitle(),
                'content' => $note->getContent(),
                'email' => strval($note->getUser()->getEmail())
            ];
        }

        $notes = $this->noteRepository->findAllNotesFrom(new Email($request['email']), $request['page'], $request['per_page']);

        if(empty($notes)) {
            return ['Notes not found'];
        }
        
        return $notes;
    }
}