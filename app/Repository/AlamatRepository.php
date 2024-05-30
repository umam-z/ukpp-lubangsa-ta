<?php

namespace UmamZ\UkppLubangsa\Repository;

use PDO;
use UmamZ\UkppLubangsa\Domain\Alamat;

class AlamatRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Alamat $alamat) : Alamat
    {
        $statement = $this->connection->prepare('INSERT INTO alamat (alamat_id, kabupaten, kecamatan, desa, blok, no, pasien_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $statement->execute([
            $alamat->id,
            $alamat->kabupaten, 
            $alamat->kecamatan,
            $alamat->desa,
            $alamat->blok,
            $alamat->no,
            $alamat->pasienId
        ]);
        
        return $alamat;
    }

    public function findById(int $pasienId): ?Alamat
    {
        $statement = $this->connection->prepare('SELECT alamat_id, kabupaten, kecamatan, desa, blok, no, pasien_id FROM alamat WHERE alamat_id = ?');
        $statement->execute([$pasienId]);

        try {
            if ($row = $statement->fetch()) {
                $alamat = new Alamat;
                $alamat->id = $row['alamat_id'];
                $alamat->kabupaten = $row['kabupaten'];
                $alamat->kecamatan = $row['kecamatan'];
                $alamat->desa = $row['desa'];
                $alamat->blok = $row['blok'];
                $alamat->no = $row['no'];
                $alamat->pasienId = $row['pasien_id'];
                
                return $alamat;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByPasienId(int $pasienId): ?Alamat
    {
        $statement = $this->connection->prepare('SELECT alamat_id, kabupaten, kecamatan, desa, blok, no, pasien_id FROM alamat WHERE pasien_id = ?');
        $statement->execute([$pasienId]);

        try {
            if ($row = $statement->fetch()) {
                $alamat = new Alamat;
                $alamat->id = $row['alamat_id'];
                $alamat->kabupaten = $row['kabupaten'];
                $alamat->kecamatan = $row['kecamatan'];
                $alamat->desa = $row['desa'];
                $alamat->blok = $row['blok'];
                $alamat->no = $row['no'];
                $alamat->pasienId = $row['pasien_id'];
                
                return $alamat;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(int $pasienId) : void
    {
        $statement = $this->connection->prepare('DELETE FROM alamat WHERE alamat_id = ?');
        $statement->execute([$pasienId]);
    }

    // Join Table Alamat dan pasien
    public function getAlamatPasien() : array | false
    {
        $statement = $this->connection->prepare('SELECT pasien.pasien_id, kabupaten, kecamatan, desa, blok, no, nama, nis FROM pasien join alamat on (alamat.pasien_id = pasien.pasien_id);');
        $statement->execute();
        
        // $result = [];
        
        // foreach ($statement as $row) {
            
            //     $pasien = new Pasien();
            //     $pasien->id = $row['pasien_id'];
            //     $pasien->nama = $row['nama'];
            //     $pasien->nis = $row['nis'];
            
            //     $alamat = new Alamat;
            //     $alamat->kabupaten = $row['kabupaten'];
            //     $alamat->kecamatan = $row['kecamatan'];
            //     $alamat->desa = $row['desa'];
            //     $alamat->blok = $row['blok'];
            //     $alamat->no = $row['no'];
            
            //     $result['pasien'] = $pasien;
            //     $result['alamat'] = $alamat;
            // }
            // return $result;
        
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        
    }

    // data surat
    public function findPasienAlamat(int $pasienId): array
    {
        $statement = $this->connection->prepare('SELECT kabupaten, kecamatan, desa, blok, no, pasien.nama as pasien, pasien.pendidikan_id FROM ukpp.alamat join pasien on (alamat.pasien_id = pasien.pasien_id) where pasien.pasien_id = ?;');
        $statement->execute([$pasienId]);
        $pasienAlamat = $statement->fetch(PDO::FETCH_ASSOC);
        return $pasienAlamat;
    }
}
