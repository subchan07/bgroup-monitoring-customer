<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AnotherDatabase\JpController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\DataAggregatorService;
use App\Http\Controllers\AnotherDatabase\MbaController;
use App\Http\Controllers\AnotherDatabase\NugrohoController;
use App\Http\Controllers\AnotherDatabase\PilarController;
use App\Http\Controllers\AnotherDatabase\RahlunaController;
use App\Http\Controllers\AnotherDatabase\ZeleaController;

class DashboardController extends Controller
{
    private DataAggregatorService $dataAggregatorService;
    public function __construct(DataAggregatorService $dataAggregatorService)
    {
        $this->dataAggregatorService = $dataAggregatorService;
    }
    public function index()
    {
        $user = Auth::user();
        return view('pages.dashboard');
    }

    public function getAllStatistik(Request $request)
    {
        $controllers = [
            'jp' => new JpController($this->dataAggregatorService),
            'mba' => new MbaController($this->dataAggregatorService),
            'nugroho' => new NugrohoController($this->dataAggregatorService),
            'pilar' => new PilarController($this->dataAggregatorService),
            'rahluna' => new RahlunaController($this->dataAggregatorService),
            'zelea' => new ZeleaController($this->dataAggregatorService),
        ];

        $result = collect($controllers)->map(function ($controller) use ($request) {
            return $controller->list($request)->getData(true);
        });
        return response()->json($result);
    }
}
