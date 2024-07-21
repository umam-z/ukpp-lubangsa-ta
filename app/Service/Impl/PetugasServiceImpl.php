<?php 

namespace UmamZ\UkppLubangsa\Service\Impl;

use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\Petugas;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\PetugasAddRequest;
use UmamZ\UkppLubangsa\Model\PetugasAddResponse;
use UmamZ\UkppLubangsa\Repository\PetugasRepository;
use UmamZ\UkppLubangsa\Service\PetugasService;

class PetugasServiceImpl implements PetugasService
{
    private PetugasRepository $petugasRepository;

    public function __construct(PetugasRepository $petugasRepository)
    {
        $this->petugasRepository = $petugasRepository;
    }

    // semua data petugas
    public function dataPetugas(): array
    {
        return $this->petugasRepository->getAll();
    }

    // tambah petugas
    public function addPetugas(PetugasAddRequest $request) : PetugasAddResponse
    {
        ValidationUtil::validate($request);

        $petugas = new Petugas(
            mt_rand(),
            $request->nama,
            $request->kontak
        );

        try {
            Database::beginTransaction();

            $result =$this->petugasRepository->findByNama($petugas->getNama());
            if ($result != null) {
                throw new ValidationException("Nama Sudah Terpakai");
            }

            $this->petugasRepository->save($petugas);

            $response = new PetugasAddResponse;
            $response->petugas = $petugas;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    // hapus Petugas
    public function deletePetugas(int $petugasId) : void
    {
        try {
            Database::beginTransaction();
            $result = $this->petugasRepository->findById($petugasId);
            if ($result == null) {
                throw new ValidationException("Data not found");
            }
            $this->petugasRepository->deleteById($petugasId);
            Database::commitTransaction();
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function count() : int
    {
        return $this->petugasRepository->countAll();
    }
}
