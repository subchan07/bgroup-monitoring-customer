<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MaterialResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MaterialCollection;
use Illuminate\Http\Exceptions\HttpResponseException;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): MaterialCollection
    {
        $materials = Material::orderBy('due_date');

        $filterMaterial = $request->query('material');
        $unusedByCustomers = $request->query('unused_by_customers');
        $limit = (int) $request->query('limit');

        if ($filterMaterial && $filterMaterial !== 'all') {
            $materials->where('material', $filterMaterial);
        }

        if ($unusedByCustomers) {
            $materials->where(function ($query) {
                $query->whereNotExists(function ($subQuery) {
                    $subQuery->select(DB::raw(1))
                        ->from('customer_domains')
                        ->whereRaw('customer_domains.material_id = materials.id');
                })->whereNotExists(function ($subQuery) {
                    $subQuery->select(DB::raw(1))
                        ->from('customers')
                        ->whereRaw('customers.ssl_material_id = materials.id');
                })->orWhere('is_multiple', true);
            });
        }

        if ($limit) $materials->limit($limit);

        $materials = $materials->get();

        return new MaterialCollection($materials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'item' => 'required|string',
            'price' => 'required|decimal:0,2',
            'billing_cycle' => 'required|string',
            'due_date' => 'required|date',
            'material' => 'required|in:domain,hosting,ssl',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $validator->validated();
        $validated['is_multiple']  = $request->input('material') == 'domain' && $request->input('is_multiple') ?? false;
        Material::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Material berhasil ditambah.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $material): MaterialResource
    {
        $material = $this->__checkIdExists($material);
        return new MaterialResource($material);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $material): JsonResponse
    {
        $material = $this->__checkIdExists($material);

        $validator = Validator::make($request->all(), [
            'item' => 'required|string',
            'price' => 'required|decimal:0,2',
            'billing_cycle' => 'required|string',
            'due_date' => 'required|date',
            'material' => 'required|in:domain,hosting,ssl',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $validator->validated();
        $validated['is_multiple']  = $request->input('material') == 'domain' && $request->input('is_multiple') ?? false;
        $material->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Material berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $material): JsonResponse
    {
        $material = $this->__checkIdExists($material);
        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Material berhasil dihapus.'
        ]);
    }

    public function bayar(Request $request): JsonResponse
    {
        $material = $this->__checkIdExists($request->input('material_id'));

        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materials,id',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'price' => 'required|decimal:0,2',
            'payment_amount' => 'required|decimal:0,2',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $validator->validate();
        if ($validated['payment_amount'] != $material->price) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => [
                    'payment_amount' => ['Nilai pembayaran harus sama dengan harga lama.']
                ]
            ], 400));
        }

        $validated['due_date'] = $material->due_date;
        $validated['price'] = $material->price;
        Payment::create($validated);

        $material->update([
            'price' => $request->input('price'),
            'due_date' => $request->input('due_date'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data bayar berhasil ditambah.'
        ]);
    }

    private function __checkIdExists(int $id)
    {
        $material = Material::where('id', $id)->first();
        if (!$material) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => [
                    'message' => ['Not found.']
                ]
            ], 404));
        }

        return $material;
    }
}
