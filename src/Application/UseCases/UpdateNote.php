<?php 
namespace TheWisePad\Application\UseCases;

use DomainException;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\Note\NoteRepository;
use TheWisePad\Domain\User\UserRepository;

use function PHPSTORM_META\type;

class UpdateNote implements UseCase
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
        $noteOriginal = $this->noteRepository->findById($request['id']);

        if($user->getEmail() != $noteOriginal->getUser()->getEmail()) {
            throw new DomainException("The note is not from this user.");
        }

        $noteTitle = $this->shouldChangeTitle($noteOriginal->getTitle(), $request['title']);
        $noteContent = $this->shouldChangeContent($noteOriginal->getContent(), $request['content']);

        if($noteTitle == true) {
            $this->verifyTitleAlreadyExists($noteOriginal, $request['title']);
            $this->noteRepository->updateTitle($request['id'], $request['title']);
        }

        if($noteContent == true) {
            $this->noteRepository->updateContent($request['id'], $request['content']);
        }

        $noteUpdated = $this->noteRepository->findById($request['id']);

        return [
            'id' => $request['id'],
            'title' => $noteUpdated->getTitle(),
            'content' =>$noteUpdated->getContent(),
        ];
    }

    private function verifyTitleAlreadyExists(Note $note, string $new_title): void
    {
        $userNotes = $this->noteRepository->findAllNotesFrom($note->getUser()->getEmail());

        array_filter($userNotes, function($note) use ($new_title){
            $getTitle = $this->getType($note);
            if($getTitle == $new_title) {
                throw new DomainException('Title already exists: ' . $note['title']);
            }
        });
    }

    private function shouldChangeTitle(string $oldTitle, ?string $newTitle): bool
    {
        $title = ($oldTitle != $newTitle) ? true : false;
        $title = is_null($newTitle) ? false : true;

        return $title;
    }

    private function shouldChangeContent(string $oldContent, ?string $newContent): bool
    {
        $content = ($oldContent != $newContent) ? true : false;
        $content = is_null($newContent) ? false : true;

        return $content;
    }

    private function getType($note)
    {
        if(DB_DRIVER == "mongodb") return $note['title'];
        return  (is_object($note)) ? $note->getTitle() : $note['title'];
    }
}