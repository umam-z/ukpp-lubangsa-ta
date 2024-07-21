<?php 

namespace UmamZ\UkppLubangsa\Service\Impl;

use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\Pendidikan;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\PendidikanAddRequest;
use UmamZ\UkppLubangsa\Model\PendidikanAddResponse;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;
use UmamZ\UkppLubangsa\Service\PendidikanService;

class PendidikanServiceImpl implements PendidikanService
{
    private PendidikanRepository $pendidikanRepository;

    public function __construct(PendidikanRepository $pendidikanRepository)
    {
        $this->pendidikanRepository = $pendidikanRepository;
    }

    // semua data pendidikan
    public function dataPendidikan(): array
    {
        return $this->pendidikanRepository->getAll();
    }

    // tambah pendidikan
    public function addPetugas(PendidikanAddRequest $request) : PendidikanAddResponse
    {
        ValidationUtil::validate($request);

        $pendidikan = new Pendidikan(
            mt_rand(),
            $request->lembaga,
            $request->email,
            $request->staff
        );
        try {
            Database::beginTransaction();

            $this->pendidikanRepository->save($pendidikan);

            $response = new PendidikanAddResponse;
            $response->pendidikan = $pendidikan;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    // hapus Pendidikan
    public function deletePendidikan(int $pendidikanId) : Pendidikan
    {
        try {
            Database::beginTransaction();
            $result = $this->pendidikanRepository->findById($pendidikanId);

            if ($result == null) {
                throw new ValidationException("Data not found");
            }

            $this->pendidikanRepository->deleteById($pendidikanId);
            Database::commitTransaction();
            return $result;
        } catch (\Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
}
