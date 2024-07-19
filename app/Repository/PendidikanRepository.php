<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\Pendidikan;

class PendidikanRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Pendidikan $pendidikan) : Pendidikan
    {
        $statement = $this->connection->prepare('INSERT INTO pendidikan(pendidikan_id, lembaga, email, staff) VALUES (?, ?, ?, ?)');
        $statement->execute([$pendidikan->getId(), $pendidikan->getLembaga(), $pendidikan->getEmail(), $pendidikan->getStaff()]);
        return $pendidikan;
    }

    public function findById(int $pendidikanId): ?Pendidikan
    {
        $statement = $this->connection->prepare('SELECT pendidikan_id, lembaga, email, staff FROM pendidikan WHERE pendidikan_id = ?');
        $statement->execute([$pendidikanId]);

        try {
            if ($row = $statement->fetch()) {
                $pendidikan = new Pendidikan(
                    $row['pendidikan_id'],
                    $row['lembaga'],
                    $row['email'],
                    $row['staff']
                );
                
                return $pendidikan;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(int $pendidikanId) : void
    {
        $statement = $this->connection->prepare('DELETE FROM pendidikan WHERE pendidikan_id = ?');
        $statement->execute([$pendidikanId]);
    }

    public function getAll() : array
    {
        $statement = $this->connection->prepare('SELECT pendidikan_id, lembaga, email, staff FROM pendidikan');
        $statement->execute();

        $result = [];

        foreach ($statement as $row) {

            $pendidikan = new Pendidikan(
                $row['pendidikan_id'],
                $row['lembaga'],
                $row['email'],
                $row['staff']
            );

            $result[] = $pendidikan;
        }
        return $result;
    }
}
