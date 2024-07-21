<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Domain\Obat;
use UmamZ\UkppLubangsa\Model\ObatAddRequest;
use UmamZ\UkppLubangsa\Model\ObatAddResponse;
use UmamZ\UkppLubangsa\Model\ObatStockUpdateRequest;
use UmamZ\UkppLubangsa\Model\ObatStockUpdateResponse;

interface ObatService 
{
    public function addObat(ObatAddRequest $request) : ObatAddResponse;
    
    public function updateStock(ObatStockUpdateRequest $request): ObatStockUpdateResponse;

    public function delete(int $obatId) : Obat;

    public function dataObat(): array;

    public function findObat(int $obatId) : Obat;

    public function count(): int;
}
