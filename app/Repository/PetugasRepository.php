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
        $statement->execute([$petugas->id, $petugas->nama, $petugas->kontak]);
        return $petugas;
    }


    public function findById(int $id): ?Petugas
    {
        $statement = $this->connection->prepare('SELECT petugas_id, nama, kontak FROM petugas WHERE petugas_id = ?');
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $petugas = new Petugas;
                $petugas->id = $row['petugas_id'];
                $petugas->nama = $row['nama'];
                $petugas->kontak = $row['kontak'];
                
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
                $petugas = new Petugas;
                $petugas->id = $row['petugas_id'];
                $petugas->nama = $row['nama'];
                $petugas->kontak = $row['kontak'];
                
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
            $alamat = new Petugas();
            $alamat->id = $row['petugas_id'];
            $alamat->kontak = $row['kontak'];
            $alamat->nama = $row['nama'];

            $result[] = $alamat;
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
