<?php 

namespace UmamZ\UkppLubangsa\Domain;

class Pasien{ 
    public function __construct(
        private int $id,
        private string $nama,
        private string $nis,
        private int $pendidikanId,

    )
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->nis = $nis;
        $this->pendidikanId = $pendidikanId;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setNama(string $nama) : void
    {
        $this->nama = $nama;
    }

    public function getNama() : string
    {
        return $this->nama;
    }

    public function setNis(int $nis) : void
    {
        $this->nis = $nis;
    }

    public function getNis() : int
    {
        return $this->nis;
    }

    public function setPendidikanId(int $pendidikanId) : void
    {
        $this->pendidikanId = $pendidikanId;
    }

    public function getPendidikanId() : int
    {
        return $this->pendidikanId;
    }
}
