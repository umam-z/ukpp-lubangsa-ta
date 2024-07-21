<?php

namespace UmamZ\UkppLubangsa\Repository;

use UmamZ\UkppLubangsa\Domain\Obat;

interface ObatRepository
{
    public function save(Obat $obat) : Obat;

    public function update(Obat $obat) : Obat;

    public function findById(int $obatId): ?Obat;

    public function deleteById(int $obatId) : void;

    public function getAll() : array;

    public function countAll() : int;
}
