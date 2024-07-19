<?php 

namespace UmamZ\UkppLubangsa\Domain;

class Pemeriksaan{
    public function __construct(
        private int $id,
        private int $petugasId,
        private int $pasienId,
        private int $tensi,
        private int $suhu,
        private string $keluhan,
        private string $diagnos,
        private string $tanggal
    )
    {
        $this->id = $id;
        $this->petugasId = $petugasId;
        $this->pasienId = $pasienId;
        $this->tensi = $tensi;
        $this->suhu = $suhu;
        $this->keluhan = $keluhan;
        $this->diagnos = $diagnos;
        $this->tanggal = $tanggal;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setPetugasId(int $petugasId) : void
    {
        $this->petugasId = $petugasId;
    }

    public function getPetugasId() : int
    {
        return $this->petugasId;
    }

    public function setPasienId(int $pasienId) : void
    {
        $this->pasienId = $pasienId;
    }

    public function getPasienId() : int
    {
        return $this->pasienId;
    }

    public function setTensi(int $tensi) : void
    {
        $this->tensi = $tensi;
    }

    public function getTensi() : int
    {
        return $this->tensi;
    }
    
    public function setSuhu(int $suhu) : void
    {
        $this->suhu = $suhu;
    }

    public function getSuhu() : int
    {
        return $this->suhu;
    }

    public function setKeluhan(string $keluhan) : void
    {
        $this->keluhan = $keluhan;
    }

    public function getKeluhan() : string
    {
        return $this->keluhan;
    }

    public function setDiagnos(string $diagnos) : void
    {
        $this->diagnos = $diagnos;
    }

    public function getDiagnos() : string
    {
        return $this->diagnos;
    }

    public function setTanggal(string $tanggal) : void
    {
        $this->tanggal = $tanggal;
    }

    public function getTanggal() : string
    {
        return $this->tanggal;
    }
}
