<?php

namespace App\Services\Impl;

use App\Services\DataAggregatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DataAggregatorServiceImpl implements DataAggregatorService
{
    public function getData(string $database, array $datas, ?string $q, ?string $val): array
    {
        $results = [];
        $connection = DB::connection($database);

        foreach ($datas as $data) {
            $query = $connection->table($data['table_name']);

            if ($q && $val) {
                $conditions = $this->__buildConditions($data['column_name'], $q, $val);
                $query->where($conditions);
            }

            $results[] = $query->count();
        }

        return $results;
    }

    private function __buildConditions(string $column, string $q, string $val): array
    {
        $conditions = [];
        switch ($q) {
            case 'date':
                $conditions[] = [DB::Raw("DATE($column)"), '=', $val];
                break;
            case 'year':
                $conditions[] = [DB::Raw("YEAR($column)"), '=', $val];
                break;
            case 'month':
                [$year, $month] = explode('-', $val);
                $conditions[] = [DB::Raw("MONTH($column)"), '=', $month];
                $conditions[] = [DB::Raw("YEAR($column)"), '=', $year];
                break;
        }
        return $conditions;
    }
}
