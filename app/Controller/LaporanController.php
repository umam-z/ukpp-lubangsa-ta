<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;

class LaporanController
{
    public function laporan() : void
    {
        View::render('/Laporan/show-laporan', [
            'title'=> 'Laporan | UKPP'
        ]);
    } 
    
    public function postLaporan() : void
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}