<?php 

namespace UmamZ\UkppLubangsa\Domain;

class Pemeriksaan{
    public int $id;
    public int $petugasId;
    public int $pasienId;
    public int $tensi;
    public int $suhu;
    public string $keluhan;
    public string $diagnos;
    public string $tanggal;
}
