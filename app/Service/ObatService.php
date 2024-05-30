<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\Obat;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\ObatAddRequest;
use UmamZ\UkppLubangsa\Model\ObatAddResponse;
use UmamZ\UkppLubangsa\Model\ObatStockUpdateRequest;
use UmamZ\UkppLubangsa\Model\ObatStockUpdateResponse;
use UmamZ\UkppLubangsa\Repository\ObatRepository;

class ObatService 
{
    private ObatRepository $obatRepository;

    public function __construct(ObatRepository $obatRepository)
    {
        $this->obatRepository = $obatRepository;
    }

    // tambah obat
    public function addObat(ObatAddRequest $request) : ObatAddResponse
    {
        ValidationUtil::validate($request);

        $obat = new Obat;
        $obat->id = mt_rand();
        $obat->obat = $request->obat;
        $obat->stock = $request->stock;

        try {
            Database::beginTransaction();
            $this->obatRepository->save($obat);
            $response = new ObatAddResponse;
            $response->obat = $obat;
            Database::commitTransaction();
            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    // update stock obat
    public function updateStock(ObatStockUpdateRequest $request): ObatStockUpdateResponse
    {
        ValidationUtil::validate($request);

        try {
            Database::beginTransaction();

            $obat = $this->obatRepository->findById($request->id);
            if ($obat == null) {
                throw new ValidationException("Obat is not found");
            }

            $obat->stock = $request->stock;
            $this->obatRepository->update($obat);

            $response = new ObatStockUpdateResponse();
            $response->obat = $obat;

            Database::commitTransaction();

            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    // delete obat
    public function delete(int $obatId) : Obat
    {
        try {
            Database::beginTransaction();
            $result = $this->obatRepository->findById($obatId);
            if ($result == null) {
                throw new ValidationException('DataNot Found');
            }

            $this->obatRepository->deleteById($obatId);
            Database::commitTransaction();
            return $result;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    // semua data obat
    public function dataObat(): array
    {
        return $this->obatRepository->getAll();
    }

    public function findObat(int $obatId) : Obat
    {
        $result = $this->obatRepository->findById($obatId);
        if ($result == null) {
            throw new ValidationException('Data Not Found');
        }
        return $result;
    }

    public function count(): int
    {
        return $this->obatRepository->countAll();
    }
}
