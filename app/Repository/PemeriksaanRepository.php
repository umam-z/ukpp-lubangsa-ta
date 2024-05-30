<?php

namespace UmamZ\UkppLubangsa\Repository;

use PDO;
use UmamZ\UkppLubangsa\Domain\Pemeriksaan;

class PemeriksaanRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Pemeriksaan $pemeriksaan) : Pemeriksaan
    {
        $statement = $this->connection->prepare('INSERT INTO pemeriksaan(pemeriksaan_id, diagnos, keluhan, pasien_id, petugas_id, suhu, tanggal, tensi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->execute([
            $pemeriksaan->id,
            $pemeriksaan->diagnos,
            $pemeriksaan->keluhan,
            $pemeriksaan->pasienId,
            $pemeriksaan->petugasId,
            $pemeriksaan->suhu,
            $pemeriksaan->tanggal,
            $pemeriksaan->tensi,
        ]);
        return $pemeriksaan;
    }

    public function findById(int $pemeriksaanId): ?Pemeriksaan
    {
        $statement = $this->connection->prepare('SELECT pemeriksaan_id, diagnos, keluhan, pasien_id, petugas_id, suhu, tanggal, tensi FROM pemeriksaan WHERE pemeriksaan_id = ?');
        $statement->execute([$pemeriksaanId]);

        try {
            if ($row = $statement->fetch()) {
                $pemeriksaan = new Pemeriksaan;
                $pemeriksaan->id = $row['pemeriksaan_id'];
                $pemeriksaan->diagnos = $row['diagnos'];
                $pemeriksaan->keluhan = $row['keluhan'];
                $pemeriksaan->petugasId = $row['petugas_id'];
                $pemeriksaan->pasienId = $row['pasien_id'];
                $pemeriksaan->suhu = $row['suhu'];
                $pemeriksaan->tanggal = $row['tanggal'];
                $pemeriksaan->tensi = $row['tensi'];
                return $pemeriksaan;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function getPasienPeriksa(int $pasienId) : array | false
    {
        $statement = $this->connection->prepare('SELECT petugas.nama as petugas, pemeriksaan_id, diagnos, keluhan, suhu, tanggal, tensi FROM pemeriksaan JOIN petugas ON (petugas.petugas_id = pemeriksaan.petugas_id) WHERE pasien_id = ?');
        $statement->execute([$pasienId]);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteById(int $pemeriksaanId): void
    {
        $statement = $this->connection->prepare('DELETE FROM pemeriksaan WHERE pemeriksaan.pemeriksaan_id = ?');
        $statement->execute([$pemeriksaanId]);
    }

    public function countAll() : int
    {
        $statement = $this->connection->prepare('SELECT count(*) as count FROM pemeriksaan');
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $jumlah = $row['count'];

        return $jumlah;
    }
}
