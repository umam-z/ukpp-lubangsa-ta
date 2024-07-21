<?php

namespace UmamZ\UkppLubangsa\Repository\Impl;

use UmamZ\UkppLubangsa\Domain\User;
use UmamZ\UkppLubangsa\Repository\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user) : User
    {
        $statement = $this->connection->prepare('INSERT INTO users(user_id, username, password) VALUES (?, ?, ?)');
        $statement->execute([$user->getId(), $user->getNama(), $user->getPassword()]);
        return $user;
    }


    public function findById(int $id): ?User
    {
        $statement = $this->connection->prepare('SELECT user_id, username, password FROM users WHERE user_id = ?');
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User(
                    $row['user_id'],
                    $row['username'],
                    $row['password']
                );
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }
    
    public function findByUsername(string $username): ?User
    {
        $statement = $this->connection->prepare('SELECT user_id, username, password FROM users WHERE username = ?');
        $statement->execute([$username]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User(
                    $row['user_id'],
                    $row['username'],
                    $row['password']
                );
                
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll() : void
    {
        $statement = $this->connection->prepare('DELETE FROM users');
        $statement->execute();
    }
}
