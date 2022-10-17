<?php 
namespace TheWisePad\Domain\Note;

use TheWisePad\Domain\User\User;

class Note
{
    private $user;

    private $title;

    private $content;

    public function __construct(User $user, string $title, string $content)
    {
        $this->user = $user;
        $this->title = $title;
        $this->content = $content;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}