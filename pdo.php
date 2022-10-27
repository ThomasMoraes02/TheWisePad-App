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
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255)
)";

$tableNote = "CREATE TABLE note (
    note_id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR (255),
    content VARCHAR (255),
    email VARCHAR(255)
)";

$pdo->exec($tableUser);
$pdo->exec($tableNote);

$user = new User("Usuario", new Email("usuario@gmail.com"), new PasswordArgonII("123456"));
$userRepositoryPdo = new UserRepositoryPdo();
$userRepositoryPdo->addUser($user);