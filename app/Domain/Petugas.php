<?php 

namespace UmamZ\UkppLubangsa\Domain;

class Petugas{
    public function __construct(
        private int $id,
        private string $nama,
        private string $kontak

    )
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->kontak = $kontak;
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

    public function setKontak(string $kontak) : void
    {
        $this->kontak = $kontak;
    }

    public function getKontak() : string
    {
        return $this->kontak;
    }

}
