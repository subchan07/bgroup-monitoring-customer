<?php

namespace App\Services;

interface DataAggregatorService
{
    public function getData(string $database, array $datas, ?string $q, ?string $val): array;
}
