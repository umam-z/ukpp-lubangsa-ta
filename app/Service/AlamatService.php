<?php 

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\Alamat;
use UmamZ\UkppLubangsa\Domain\Pasien;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\AlamatPasienAddRequest;
use UmamZ\UkppLubangsa\Model\AlamatPasienAddResponse;
use UmamZ\UkppLubangsa\Repository\AlamatRepository;
use UmamZ\UkppLubangsa\Repository\PasienRepository;

class AlamatService 
{
    private AlamatRepository $alamatRepository;
    private PasienRepository $pasienRepository;

    public function __construct(AlamatRepository $alamatRepository, PasienRepository $pasienRepository)
    {
        $this->alamatRepository = $alamatRepository;
        $this->pasienRepository = $pasienRepository;
    }

    public function addAlamatPasien(AlamatPasienAddRequest $request) : AlamatPasienAddResponse
    {
        ValidationUtil::validate($request);
        $alamat = new Alamat;
        $alamat->id = mt_rand();
        $alamat->blok = $request->blok;
        $alamat->no = $request->no;
        $alamat->kabupaten = $request->kabupaten;
        $alamat->kecamatan = $request->kecamatan;
        $alamat->desa = $request->desa;
        $alamat->pasienId = $request->pasienId;

        try {
            Database::beginTransaction();
            $result = $this->pasienRepository->findById($alamat->pasienId);
            if ($result == null) {
                throw new ValidationException("Terjadi Kesalahan");
            }

            $result = $this->alamatRepository->findById($alamat->id);
            if ($result != null) {
                throw new ValidationException("Terjadi Kesalahan");
            }

            $this->alamatRepository->save($alamat);

            $response = new AlamatPasienAddResponse;
            $response->alamat = $alamat;
            Database::commitTransaction();

            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
    
    public function dataAlamatPasien() : array
    {
        return $this->alamatRepository->getAlamatPasien();
    }

    public function delete(int $pasienId) : Pasien
    {
        try {
            Database::beginTransaction();
            $pasien = $this->pasienRepository->findById($pasienId);
            if ($pasien == null) {
                throw new ValidationException('Terjadi Kesalahan');
            }
            
            $alamat = $this->alamatRepository->findByPasienId($pasien->id);
            if ($alamat == null) {
                throw new ValidationException('Terjadi Kesalahan');
            }

            $this->alamatRepository->deleteById($alamat->id);
            Database::commitTransaction();
            return $pasien;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function dataSurat(int $pasienId): array
    {
        return $this->alamatRepository->findPasienAlamat($pasienId); 
    }
}
