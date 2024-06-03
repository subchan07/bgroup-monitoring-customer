<?php

namespace App\Http\Controllers\AnotherDatabase;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\DataAggregatorService;

class RahlunaController extends Controller
{
    private DataAggregatorService $dataAggregatorService;
    public function __construct(DataAggregatorService $dataAggregatorService)
    {
        $this->dataAggregatorService = $dataAggregatorService;
    }

    public function list(Request $request): JsonResponse
    {
        $queryParamQ = $request->get('q', null);
        $queryParamVal = $request->get('val', null);

        $author = 'Rahluna';
        $database = env('DB_DATABASE_RAHLUNA');
        $datas = $this->__stuctureTable();

        $result = $this->dataAggregatorService->getData($database, $datas, $queryParamQ, $queryParamVal);
        return response()->json(['data' => array_sum($result), 'data_original' => $result, 'author' => $author]);
    }

    private function __stuctureTable(): array
    {
        return [
            [
                'table_name' => 'tbl_produk_paket',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'inv_detail',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'new_invoice',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'new_oprasional',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'new_po',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'new_project',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'new_surat_jalan',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'oprasional_detail',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'po_detail',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'project_detail',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'surat_jalan_detail',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'tbl_customer',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'tbl_history_produk',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'tbl_produk',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'tbl_produk_paket',
                'column_name' => 'first_create',
            ],
            [
                'table_name' => 'tbl_satuan',
                'column_name' => 'first_create',
            ],
        ];
    }
}
