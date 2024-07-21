<?php

namespace UmamZ\UkppLubangsa\Repository;

interface LaporanRepository
{
   public function getDateFilter(string $dari, string $sampai) : array;
}