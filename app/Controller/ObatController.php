<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\ObatAddRequest;
use UmamZ\UkppLubangsa\Model\ObatStockUpdateRequest;
use UmamZ\UkppLubangsa\Repository\Impl\ObatRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\ObatServiceImpl;
use UmamZ\UkppLubangsa\Service\ObatService;

class ObatController
{
    private ObatService $obatService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $obatRepository = new ObatRepositoryImpl($connection);
        $this->obatService = new ObatServiceImpl($obatRepository);
    }

    public function obat(): void
    {
        View::render('/Obat/show-obat', [
            'title' => 'Obat | UKPP',
            'data' => $this->obatService->dataObat()
        ]);
    }
    
    public function create(): void
    {
        $request = new ObatAddRequest;
        $request->obat = htmlspecialchars($_POST['obat']);
        $request->stock = (int) htmlspecialchars($_POST['stock']);
        try {
            $this->obatService->addObat($request);
            View::redirect('/obat');
        } catch (ValidationException $e) {
            View::render('/Obat/show-obat', [
                'title' => 'Obat | UKPP',
                'error' => $e->getMessage(),
                'data' => $this->obatService->dataObat()
            ]);
        }
    }

    public  function delete(string $obatId) : void
    {
        try {
            $this->obatService->delete($obatId);
            View::redirect('/obat');
        } catch (ValidationException $e) {
            View::render('/Obat/show-obat', [
                'title' => 'Obat | UKPP',
                'error' => $e->getMessage(),
                'data' => $this->obatService->dataObat()
            ]);
        }
    }

    public function updateStock(string $obatId) : void
    {
        try {
            $obat = $this->obatService->findObat($obatId); 
            view::render('/Obat/edit-stock',[
                'title' => 'Stock Obat | UKPP',
                'data' => $obat
            ]);
        } catch (ValidationException $e) {
            view::render('/Obat/edit-stock',[
                'title' => 'Stock Obat | UKPP',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function postUpdateStock (string $obatId) : void
    {
        $request = new ObatStockUpdateRequest;
        $request->id = (int) htmlspecialchars($obatId);
        $request->stock = (int) htmlspecialchars($_POST['stock']);

        try {
            $this->obatService->updateStock($request);
            View::redirect('/obat');
        } catch (ValidationException $e) {
            view::render('/Obat/edit-stock',[
                'title' => 'Stock Obat | UKPP',
                'error' => $e->getMessage()
            ]);   
        }
    }
}
