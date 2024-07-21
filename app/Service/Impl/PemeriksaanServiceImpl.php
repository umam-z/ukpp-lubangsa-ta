<?php 

namespace UmamZ\UkppLubangsa\Service\Impl;

use DateTime;
use DateTimeZone;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\Pemeriksaan;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\PemeriksaanAddRequest;
use UmamZ\UkppLubangsa\Model\PemeriksaanAddResponse;
use UmamZ\UkppLubangsa\Repository\PasienRepository;
use UmamZ\UkppLubangsa\Repository\PemeriksaanRepository;
use UmamZ\UkppLubangsa\Service\PemeriksaanService;

class PemeriksaanServiceImpl implements PemeriksaanService
{
    private PemeriksaanRepository $pemeriksaanRepository;
    private PasienRepository $pasienRepository;

    public function __construct(PemeriksaanRepository $pemeriksaanRepository, PasienRepository $pasienRepository)
    {
        $this->pemeriksaanRepository = $pemeriksaanRepository;
        $this->pasienRepository = $pasienRepository;
    }

    public function dataPemeriksaan(int $pasienId): array
    {
        $pasien = $this->pasienRepository->findById($pasienId);
        if ($pasien == null) {
            throw new ValidationException("Data pasien tidak ditemukan");
        }

        $pemeriksaan = $this->pemeriksaanRepository->getPasienPeriksa($pasien->getId());

        return $pemeriksaan;
    }

    public function addPemeriksaan(PemeriksaanAddRequest $request) : PemeriksaanAddResponse
    {
        ValidationUtil::validate($request);

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone("Asia/Jakarta"));
        $tanggal = $now->format("Y-m-d");

        $pemeriksaan = new Pemeriksaan(
            mt_rand(),
            $request->petugasId,
            $request->pasienId,
            $request->tensi,
            $request->suhu,
            $request->keluhan,
            $request->diagnos,
            $tanggal
        );
        
        try {
            Database::beginTransaction();
            $result = $this->pemeriksaanRepository->findById($pemeriksaan->getId());
            if ($result != null) {
                throw new ValidationException("Terjadi Kesalahan");
            }
            $this->pemeriksaanRepository->save($pemeriksaan);
            $response = new PemeriksaanAddResponse;
            $response->pemeriksaan = $pemeriksaan;
            Database::commitTransaction();
            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function delete(int $pemeriksaanId): ?Pemeriksaan
    {
        try {
            Database::beginTransaction();
            $pemeriksaan = $this->pemeriksaanRepository->findById($pemeriksaanId);
            if ($pemeriksaan == null) {
                throw new ValidationException("Terjadi Kesalahan");
            }
            $this->pemeriksaanRepository->deleteById($pemeriksaan->getId());
            Database::commitTransaction();
            return $pemeriksaan;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
    
    public function findPemeriksaan(int $pemeriksaanId): Pemeriksaan
    {
        $pemeriksaan = $this->pemeriksaanRepository->findById($pemeriksaanId);
        if ($pemeriksaan == null) {
            throw new ValidationException("Data tidak ditemukan");
        }
        return $pemeriksaan;
    }

    public function count() : int
    {
        return $this->pemeriksaanRepository->countAll();
    }
}
