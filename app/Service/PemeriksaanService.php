<?php 

namespace UmamZ\UkppLubangsa\Service;

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

class PemeriksaanService 
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

        $pemeriksaan = $this->pemeriksaanRepository->getPasienPeriksa($pasien->id);

        return $pemeriksaan;
    }

    public function addPemeriksaan(PemeriksaanAddRequest $request) : PemeriksaanAddResponse
    {
        ValidationUtil::validate($request);

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone("Asia/Jakarta"));

        $pemeriksaan = new Pemeriksaan;
        $pemeriksaan->id = mt_rand();
        $pemeriksaan->diagnos = $request->diagnos;
        $pemeriksaan->keluhan = $request->keluhan;
        $pemeriksaan->pasienId = $request->pasienId;
        $pemeriksaan->petugasId = $request->petugasId;
        $pemeriksaan->suhu = $request->suhu;
        $pemeriksaan->tanggal = $now->format("Y-m-d");
        $pemeriksaan->tensi = $request->tensi;
        try {
            Database::beginTransaction();
            $result = $this->pemeriksaanRepository->findById($pemeriksaan->id);
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
            $this->pemeriksaanRepository->deleteById($pemeriksaan->id);
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
