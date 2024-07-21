<?php

namespace UmamZ\UkppLubangsa\Repository\Impl;

use UmamZ\UkppLubangsa\Domain\Session;
use UmamZ\UkppLubangsa\Repository\SessionRepository;

class SessionRepositoryImpl implements SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session) : Session
    {
        $statement = $this->connection->prepare('INSERT INTO sessions(session_id, user_id) VALUES (?, ?)');
        $statement->execute([$session->getId(), $session->getUserId()]);
        return $session;
    }


    public function findById(string $id): ?Session
    {
        $statement = $this->connection->prepare('SELECT session_id, user_id FROM sessions WHERE session_id = ?');
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $session = new Session(
                    $row['session_id'],
                    $row['user_id']
                );
                
                return $session;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll() : void
    {
        $statement = $this->connection->prepare('DELETE FROM sessions');
        $statement->execute();
    }

    public function deleteById(string $id) : void
    {
        $statement = $this->connection->prepare('DELETE FROM sessions WHERE session_id = ?');
        $statement->execute([$id]);
    }
}
