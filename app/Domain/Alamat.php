<?php 

namespace UmamZ\UkppLubangsa\Domain;

class Alamat{
    public function __construct(
        private int $id,
        private string $kabupaten,
        private string $kecamatan,
        private string $desa,
        private string $blok,
        private int $no,
        private int $pasienId
    )
    {
        $this->id = $id;
        $this->kabupaten = $kabupaten;
        $this->kecamatan = $kecamatan;
        $this->desa = $desa;
        $this->blok = $blok;
        $this->no = $no;
        $this->pasienId = $pasienId;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }
    
    public function setKabupaten(string $kabupaten) : void
    {
        $this->kabupaten = $kabupaten;
    }

    public function getKabupaten() : string
    {
        return $this->kabupaten;
    }

    public function setKecamatan(string $kecamatan) : void
    {
        $this->kecamatan = $kecamatan;
    }

    public function getKecamatan() : string
    {
        return $this->kecamatan;
    }

    public function setDesa(string $desa) : void
    {
        $this->desa = $desa;
    }

    public function getDesa() : string
    {
        return $this->desa;
    }

    public function setBlok(string $blok) : void
    {
        $this->blok = $blok;
    }

    public function getBlok() : string
    {
        return $this->blok;
    }

    public function setNo(int $no) : void
    {
        $this->no = $no;
    }

    public function getNo() : int
    {
        return $this->no;
    }

    public function setPasienId(int $pasienId) : void
    {
        $this->pasienId = $pasienId;
    }

    public function getPasienId() : int
    {
        return $this->pasienId;
    }
}
