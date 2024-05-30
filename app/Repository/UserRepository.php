<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\User;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user) : User
    {
        $statement = $this->connection->prepare('INSERT INTO users(user_id, username, password) VALUES (?, ?, ?)');
        $statement->execute([$user->id, $user->nama, $user->password]);
        return $user;
    }


    public function findById(int $id): ?User
    {
        $statement = $this->connection->prepare('SELECT user_id, username, password FROM users WHERE user_id = ?');
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User;
                $user->id = $row['user_id'];
                $user->nama = $row['username'];
                $user->password = $row['password'];
                
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
                $user = new User;
                $user->id = $row['user_id'];
                $user->nama = $row['username'];
                $user->password = $row['password'];
                
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
