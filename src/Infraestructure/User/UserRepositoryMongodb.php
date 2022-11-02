<?php 
namespace TheWisePad\Infraestructure\User;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\User\User;
use MongoDB\Operation\FindOneAndUpdate;
use TheWisePad\Domain\User\UserRepository;
use TheWisePad\Domain\Exceptions\UserNotFound;
use TheWisePad\Infraestructure\ConnectionManager;

class UserRepositoryMongodb implements UserRepository
{
    /**
     * @var MongoDB\Client;
     */
    private $mongo;

    private $connection;

    private $collection = "user";

    public function __construct()
    {
        $this->connection = ConnectionManager::connect();
        $this->mongo = $this->connection->selectCollection($this->collection);
    }

    public function addUser(User $user): void
    {
        $id = $this->getNextId();

        $document = [
            "_id" => $id,
            "name" => $user->getName(),
            "email" => strval($user->getEmail()),
            "password" => strval($user->getPassword())
        ];

        $this->mongo->insertOne($document);
    }

    public function findByEmail(Email $email): User
    {
        $findUser = $this->mongo->find(['email' => strval($email)])->toArray();
        $findUser = current($findUser);

        if(empty($findUser)) {
            throw new UserNotFound();
        }

        $encoderClass = ENCODER;
        $encoder = new $encoderClass;
        $encoder->setPasswordHash($findUser['password']);

        return User::create($findUser['name'], $findUser['email'], $encoder);
    }

    public function findAll(): array
    {
        $users = $this->mongo->find()->toArray();
        return $users;
    }

    private function getNextId()
    {
        $collection = $this->connection->selectCollection("counters");

        $result = $collection->findOneAndUpdate(
            ['_id' => 'user_id'],
            ['$inc' => ['seq' => 1]],
            ['upsert' => true, 'projection' => [ 'seq' => 1 ],'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );

        return $result['seq'];
    }
}