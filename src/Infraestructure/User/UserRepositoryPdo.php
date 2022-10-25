<?php 
namespace TheWisePad\Infraestructure\User;

use PDO;
use TheWisePad\Application\Factories\ControllerFactory;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\User\User;
use TheWisePad\Domain\User\UserRepository;
use TheWisePad\Infraestructure\ConnectionPdo;

class UserRepositoryPdo implements UserRepository
{
    private $pdo;

    public function __construct()
    {
        $pdo = new ConnectionPdo();
        $this->pdo = $pdo->getConnection();
    }

    public function addUser(User $user): void
    {
        $query = "INSERT INTO user VALUES (:name, :email, :password)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":name", $user->getName());
        $stmt->bindParam(":email", $user->getEmail());
        $stmt->bindParam(":password", $user->getPassword());

        $stmt->execute();
    }

    public function findByEmail(Email $email): User
    {
        $query = "SELECT * FROM user WHERE email = '$email'";
        $user = $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        $user = current($user);

        $encoder = ControllerFactory::makeEncoder();

        return User::create($user['name'], $user['email'], new $encoder($user['password']));
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM user";
        $users = $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }
}