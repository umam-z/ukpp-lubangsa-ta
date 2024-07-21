<?php 

namespace UmamZ\UkppLubangsa\Service;

interface LaporanService 
{
    public function filterDate(string $dari, string $sampai): array;
}
