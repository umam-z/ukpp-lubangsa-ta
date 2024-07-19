<?php 

namespace UmamZ\UkppLubangsa\Domain;

class Obat{
    public function __construct(
        private int $id,
        private string $obat,
        private int $stock,
    )
    {
        $this->id = $id;
        $this->obat = $obat;
        $this->stock = $stock;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setObat(string $obat) : void
    {
        $this->obat = $obat;
    }

    public function getObat() : string
    {
        return $this->obat;
    }

    public function setStock(int $stock) : void
    {
        $this->stock = $stock;
    }

    public function getStock() : int
    {
        return $this->stock;
    }
}
