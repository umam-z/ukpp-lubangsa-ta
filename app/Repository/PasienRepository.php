<?php

namespace UmamZ\UkppLubangsa\Repository;

use PDO;
use UmamZ\UkppLubangsa\Domain\Pasien;

class PasienRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Pasien $pasien) : Pasien
    {
        $statement = $this->connection->prepare('INSERT INTO pasien(pasien_id, nama, nis, pendidikan_id) VALUES (?, ?, ?, ?)');
        $statement->execute([
            $pasien->id,
            $pasien->nama, 
            $pasien->nis,
            $pasien->pendidikanId
        ]);
        
        return $pasien;
    }

    public function findById(int $pasienId): ?Pasien
    {
        $statement = $this->connection->prepare('SELECT pasien_id, nama, nis, pendidikan_id FROM pasien WHERE pasien_id = ?');
        $statement->execute([$pasienId]);

        try {
            if ($row = $statement->fetch()) {
                $petugas = new Pasien;
                $petugas->id = $row['pasien_id'];
                $petugas->nama = $row['nama'];
                $petugas->nis = $row['nis'];
                $petugas->pendidikanId = $row['pendidikan_id'];
                
                return $petugas;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(int $pasienId) : void
    {
        $statement = $this->connection->prepare('DELETE FROM pasien WHERE pasien_id = ?');
        $statement->execute([$pasienId]);
    }

    public function countAll() : int
    {
        $statement = $this->connection->prepare('SELECT count(*) as count FROM pasien');
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $jumlah = $row['count'];

        return $jumlah;
    }
}
