<?php

namespace UmamZ\UkppLubangsa\Repository\Impl;

use UmamZ\UkppLubangsa\Repository\LaporanRepository;

class LaporanRepositoryImpl implements LaporanRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getDateFilter(string $dari, string $sampai): array
    {
        $statement = $this->connection->prepare("
            SELECT pasien.nama, diagnos, keluhan, suhu, tensi, alamat.blok, alamat.no
            FROM pasien 
            JOIN pemeriksaan ON (pasien.pasien_id = pemeriksaan.pasien_id)
            JOIN alamat ON (alamat.pasien_id = pasien.pasien_id)
            WHERE date(tanggal) > ? and date(tanggal) < ?
        ");
        $statement->execute([$dari, $sampai]);
        
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}
