<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\Petugas;

class PetugasRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Petugas $petugas) : Petugas
    {
        $statement = $this->connection->prepare('INSERT INTO petugas(petugas_id, nama, kontak) VALUES (?, ?, ?)');
        $statement->execute([$petugas->getId(), $petugas->getNama(), $petugas->getKontak()]);
        return $petugas;
    }


    public function findById(int $id): ?Petugas
    {
        $statement = $this->connection->prepare('SELECT petugas_id, nama, kontak FROM petugas WHERE petugas_id = ?');
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $petugas = new Petugas(
                    $row['petugas_id'],
                    $row['nama'],
                    $row['kontak']
                );
                
                return $petugas;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByNama(string $nama): ?Petugas
    {
        $statement = $this->connection->prepare('SELECT petugas_id, nama, kontak FROM petugas WHERE nama = ?');
        $statement->execute([$nama]);

        try {
            if ($row = $statement->fetch()) {
                $petugas = new Petugas(
                    $row['petugas_id'],
                    $row['nama'],
                    $row['kontak']
                );
                
                return $petugas;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(string $petugasId) : void
    {
        $statement = $this->connection->prepare('DELETE FROM petugas WHERE petugas_id = ?');
        $statement->execute([$petugasId]);
    }

    public function getAll() : array
    {
        $statement = $this->connection->prepare('SELECT petugas_id, nama, kontak FROM petugas');
        $statement->execute();

        $result = [];

        foreach ($statement as $row) {
            $petugas = new Petugas(
                $row['petugas_id'],
                $row['nama'],
                $row['kontak']
            );

            $result[] = $petugas;
        }
        return $result;
    }

    public function countAll() : int
    {
        $statement = $this->connection->prepare('SELECT count(*) as count FROM pemeriksaan');
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        $jumlah = $row['count'];

        return $jumlah;
    }
}
