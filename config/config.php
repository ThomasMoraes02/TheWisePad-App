<?php

// Config base path
define("BASE_PATH", "/projetos/thewisepad");

// Config Encoder Password
define("ENCODER", "TheWisePad\Infraestructure\PasswordArgonII");

// Config Reppository
define("USER_REPOSITORY", "TheWisePad\Infraestructure\User\UserRepositoryPdo");

define("NOTE_REPOSITORY", "TheWisePad\Infraestructure\Note\NoteRepositoryPdo");

// Config Token Manager
define("JWT_SECRET_TOKEN", "token-jwt-thewisedev");

define("JWT_EXPIRATION_TOKEN", 1);

// Config Database
define("DB_DRIVER", "mysql");

define("DB_HOST", "localhost");

define("DB_DATABASE", "thewisedev");

define("DB_USER", "root");

define("DB_PASSWORD", "123456");