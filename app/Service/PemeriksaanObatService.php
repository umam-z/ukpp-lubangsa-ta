<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\PemeriksaanObat;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\PemeriksaanObatAddRequest;
use UmamZ\UkppLubangsa\Model\PemeriksaanObatAddResponse;
use UmamZ\UkppLubangsa\Repository\ObatRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanObatRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanRepository;

class PemeriksaanObatService 
{
    private PemeriksaanObatRepository $pemeriksaanObatRepository;
    private PemeriksaanRepository $pemeriksaanRepository;
    private ObatRepository $obatRepository;

    public function __construct(PemeriksaanObatRepository $pemeriksaanObatRepository, PemeriksaanRepository $pemeriksaanRepository, ObatRepository $obatRepository)
    {
        $this->pemeriksaanObatRepository = $pemeriksaanObatRepository;
        $this->pemeriksaanRepository = $pemeriksaanRepository;
        $this->obatRepository = $obatRepository;
    }

    public function addObatPemeriksaan(PemeriksaanObatAddRequest $request) : PemeriksaanObatAddResponse
    {
        ValidationUtil::validate($request);
        $pemeriksaanObat = new PemeriksaanObat;
        $pemeriksaanObat->obatId = $request->obatId;
        $pemeriksaanObat->pemeriksaanId = $request->pemeriksaanId;
        $pemeriksaanObat->quantity = $request->qty;

        try {
            Database::beginTransaction();
            $obat = $this->obatRepository->findById($pemeriksaanObat->obatId);

            if ($obat == null) {
                throw new ValidationException("Terjadi kesalahan");
            }

            if ($obat->obat == 0) {
                throw new ValidationException("Stock obat tidak mencukupi");
            }

            if ($obat->stock < $pemeriksaanObat->quantity) {
                throw new ValidationException("Stock obat tidak mencukupi");
            }

            $result = $this->pemeriksaanObatRepository->findByDuplicate($pemeriksaanObat->pemeriksaanId, $pemeriksaanObat->obatId);
            if ($result != null) {
                throw new ValidationException("Obat telah digunakan");
            }

            $obat->stock = $obat->stock - $pemeriksaanObat->quantity;

            $this->obatRepository->update($obat);

            $this->pemeriksaanObatRepository->save($pemeriksaanObat);

            $response = new PemeriksaanObatAddResponse;
            $response->pemeriksaanObat = $pemeriksaanObat;
            Database::commitTransaction();

            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function dataObatPeriksa(int $pemeriksaanId) : array
    {
        $pemeriksaan = $this->pemeriksaanRepository->findById($pemeriksaanId);
        if ($pemeriksaan == null) {
            throw new ValidationException("Data wajib diisi");
        }
        $pemeriksaanObat = $this->pemeriksaanObatRepository->getPeriksaObat($pemeriksaan->id);
        return $pemeriksaanObat;
    }

    public function delete(int $pemeriksaanId, int $obatId): void
    {
        $result = $this->pemeriksaanObatRepository->findByDuplicate($pemeriksaanId, $obatId);
        if ($result == null) {
           throw new ValidationException('terjadi kesalahan');
        }
        $this->pemeriksaanObatRepository->delete($pemeriksaanId, $obatId);
    
    }

    public function deleteByPemeriksaanId(int $pemeriksaanId): void
    {
        $this->pemeriksaanObatRepository->deleteByPemeriksaanId($pemeriksaanId);
    }
}
