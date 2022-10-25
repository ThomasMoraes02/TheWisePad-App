<?php

use TheWisePad\Domain\Email;
use TheWisePad\Domain\User\User;
use TheWisePad\Infraestructure\ConnectionPdo;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\User\UserRepositoryPdo;

require_once("vendor/autoload.php");

$pdo = new ConnectionPdo();
$pdo = $pdo->getConnection();

$tableUser = "CREATE TABLE user (
    -- id INTEGER DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)
)";

$tableNote = "CREATE TABLE note (
    -- note_id INTEGER DEFAULT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR (255),
    content VARCHAR (255),
    user VARCHAR (255)
)";

// $pdo->exec($tableUser);
// $pdo->exec($tableNote);

// $user = new User("Igor Moraes", new Email("igor@gmail.com"), new PasswordArgonII("654321"));

// $userRepositoryPdo = new UserRepositoryPdo();
// $userRepositoryPdo->addUser($user);

// print_r($user);