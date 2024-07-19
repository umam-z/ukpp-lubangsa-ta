<?php 

namespace UmamZ\UkppLubangsa\Domain;

class PemeriksaanObat{
    public function __construct(
        private int $pemeriksaanId,
        private int $obatId,
        private int $quantity,
    )
    {
        $this->pemeriksaanId = $pemeriksaanId;   
        $this->obatId = $obatId;   
        $this->quantity = $quantity;   
    }

    public function setPemeriksaanId(int $pemeriksaanId) : void
    {
        $this->pemeriksaanId = $pemeriksaanId;
    }

    public function getPemeriksaanId() : int
    {
        return $this->pemeriksaanId;
    }

    public function setObatId(int $obatId) : void
    {
        $this->obatId = $obatId;
    }

    public function getObatId() : int
    {
        return $this->obatId;
    }

    public function setQuantity(int $quantity) : void
    {
        $this->quantity = $quantity;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }
}
