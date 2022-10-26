<?php

define("BASE_PATH", "/projetos/thewisepad");

define("ENCODER", "TheWisePad\Infraestructure\PasswordArgonII");

define("USER_REPOSITORY", "TheWisePad\Infraestructure\User\UserRepositoryPdo");

define("NOTE_REPOSITORY", "TheWisePad\Infraestructure\Note\NoteRepositoryPdo");

define("JWT_SECRET_TOKEN", "token-jwt-thewisedev");

define("JWT_EXPIRATION_TOKEN", 5);