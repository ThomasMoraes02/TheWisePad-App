<?php

use TheWisePad\Infraestructure\Note\NoteRepositoryMongodb;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\TokenJWT;
use TheWisePad\Infraestructure\User\UserRepositoryMongodb;

// Display Errors
// ini_set('display_errors', 1);

// Config base path
define("BASE_PATH", "/projetos/thewisepad");

// Config Encoder Password
define("ENCODER", PasswordArgonII::class);

// Config Repository
define("USER_REPOSITORY", UserRepositoryMongodb::class);

define("NOTE_REPOSITORY", NoteRepositoryMongodb::class);

// Config Token Manager
define("TOKEN_MANAGER", TokenJWT::class);

define("JWT_SECRET_TOKEN", "token-jwt-thewisedev");

define("JWT_EXPIRATION_TOKEN", 1);

// Config Database
define("DB_DRIVER", "mongodb");

define("DB_HOST", "localhost");

define("DB_DATABASE", "thewisedev");

define("DB_USER", "root");

define("DB_PASSWORD", "sua-senha");