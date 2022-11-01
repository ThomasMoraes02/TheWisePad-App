<?php

// Config base path
define("BASE_PATH", "/projetos/thewisepad");

// Config Encoder Password
define("ENCODER", "TheWisePad\Infraestructure\PasswordArgonII");

// Config Repository
define("USER_REPOSITORY", "TheWisePad\Infraestructure\User\UserRepositoryPdo");

define("NOTE_REPOSITORY", "TheWisePad\Infraestructure\Note\NoteRepositoryPdo");

// Config Token Manager
define("TOKEN_MANAGER", "TheWisePad\Infraestructure\TokenJWT");

define("JWT_SECRET_TOKEN", "token-jwt-thewisedev");

define("JWT_EXPIRATION_TOKEN", 1);

// Config Database
define("DB_DRIVER", "sqlite"); //mysql

define("DB_HOST", "localhost");

define("DB_DATABASE", "thewisedev");

define("DB_USER", "root");

define("DB_PASSWORD", "sua-senha");