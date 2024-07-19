<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\PemeriksaanObat;

class PemeriksaanObatRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(PemeriksaanObat $pemeriksaanObat) : PemeriksaanObat
    {
        $statement = $this->connection->prepare('INSERT INTO pemeriksaan_obat (obat_id, pemeriksaan_id, qty) VALUES (?, ?, ?)');
        $statement->execute([
            $pemeriksaanObat->getObatId(),
            $pemeriksaanObat->getPemeriksaanId(), 
            $pemeriksaanObat->getQuantity()
        ]);
        
        return $pemeriksaanObat;
    }

    public function getPeriksaObat(int $pemeriksaanId) : array | false
    {
        $statement = $this->connection->prepare('SELECT obat.obat, qty, pemeriksaan_obat.obat_id, pemeriksaan_obat.pemeriksaan_id from pemeriksaan_obat join obat on(pemeriksaan_obat.obat_id = obat.obat_id) where pemeriksaan_id = ?');
        $statement->execute([$pemeriksaanId]);

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function findByDuplicate(int $pemeriksaanId, int $obatId): ? PemeriksaanObat
    {
        $statement = $this->connection->prepare('SELECT pemeriksaan_id, obat_id, qty FROM ukpp.pemeriksaan_obat WHERE pemeriksaan_id = ? AND obat_id = ?');
        $statement->execute([$pemeriksaanId, $obatId]);

        try {
            if ($row = $statement->fetch()) {
                $pemeriksaanObat = new PemeriksaanObat(
                    $row['pemeriksaan_id'],
                    $row['obat_id'],
                    $row['qty']
                );
                return $pemeriksaanObat;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }   
    }

    public function delete(int $pemeriksaanId, int $obatId):  void
    {
        $statement = $this->connection->prepare('DELETE FROM ukpp.pemeriksaan_obat WHERE pemeriksaan_id = ? AND obat_id = ?');
        $statement->execute([$pemeriksaanId, $obatId]);
    }

    public function findByPemeriksaanId(int $pemeriksaanId): ?PemeriksaanObat
    {
        $statement = $this->connection->prepare('SELECT pemeriksaan_id, obat_id, qty FROM ukpp.pemeriksaan_obat WHERE pemeriksaan_id = ?');
        $statement->execute([$pemeriksaanId]);
        try {
            if ($row = $statement->fetch()) {
                $pemeriksaanObat = new PemeriksaanObat(
                    $row['pemeriksaan_id'],
                    $row['obat_id'],
                    $row['qty']
                );
                
                return $pemeriksaanObat;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        } 
    }
    
    public function deleteByPemeriksaanId(int $pemeriksaanId)
    {
        $statement = $this->connection->prepare('DELETE FROM ukpp.pemeriksaan_obat WHERE pemeriksaan_id = ?');
        $statement->execute([$pemeriksaanId]);
    }
}
