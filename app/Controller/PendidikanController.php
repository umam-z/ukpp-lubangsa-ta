<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\PendidikanAddRequest;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;
use UmamZ\UkppLubangsa\Service\PendidikanService;

class PendidikanController
{
    private PendidikanService $pendidikanService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $pendidikanRepository = new PendidikanRepository($connection);
        $this->pendidikanService = new PendidikanService($pendidikanRepository);
    }

    public function pendidikan() : void
    {
        View::render('/Pendidikan/show-pendidikan', [
            'title' => 'Pendidikan Pasien | UKPP',
            'data' => $this->pendidikanService->dataPendidikan()
        ]);
    }
    
    public function create() : void
    {
        $request = new PendidikanAddRequest;
        $request->staff = $_POST['staff'];
        $request->email = $_POST['email'];
        $request->lembaga = $_POST['lembaga'];
        
        try {
            $this->pendidikanService->addPetugas($request);
            View::redirect('/pendidikan');
        } catch (ValidationException $e) {
            View::render('/Pendidikan/show-pendidikan', [
                'title' => 'Pendidikan Pasien | UKPP',
                'error' => $e->getMessage(),
                'data' => $this->pendidikanService->dataPendidikan()
            ]);
        }
    }

    public function delete(string $pendidikanId) : void
    {
        $this->pendidikanService->deletePendidikan($pendidikanId);
        View::redirect('/pendidikan');
    }
}
