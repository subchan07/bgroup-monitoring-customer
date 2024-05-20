<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CustomerCollection;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): CustomerCollection
    {
        $limit = (int) $request->query('limit');

        $orderBy = $request->query('orderBy') ?? 'due_date';
        $orderByDirection = $request->query('direction') ?? 'asc';
        [$orderByColumn, $orderByDirection] = Customer::checkTableName($orderBy ?? 'due_date', $orderByDirection ?? 'asc');

        $customers = Customer::with(['domainMaterials', 'hostingMaterial', 'sslMaterial'])->orderBy($orderByColumn ?? 'due_date', $orderByDirection ?? 'asc');

        if ($limit) $customers->limit($limit);

        $customers = $customers->get();

        return new CustomerCollection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'domain' => 'required|string',
            'due_date' => 'required|date',
            'price' => 'required|decimal:0,2',
            'domain_material_ids' => 'nullable|array',
            'domain_material_ids.*' => 'exists:materials,id,material,domain',
            'hosting_material_id' => 'nullable|exists:materials,id,material,hosting',
            'ssl_material_id' => 'nullable|exists:materials,id,material,ssl',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $request->except(['domain_material_ids']);
        $customer = Customer::create($validated);

        $domainIds = $request->input('domain_material_ids');
        $customer->domainMaterials()->attach($domainIds);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil ditambah.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $customer): CustomerResource
    {
        $withMaterial = $request->query('withMaterial') ?? false;

        $result = $this->__checkIdExists($customer, $withMaterial);
        return new CustomerResource($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $customer): JsonResponse
    {
        $customer = $this->__checkIdExists($customer);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'domain' => 'required|string',
            'due_date' => 'required|date',
            'price' => 'required|decimal:0,2',
            'domain_material_ids' => 'nullable|array',
            'domain_material_ids.*' => 'exists:materials,id,material,domain',
            'hosting_material_id' => 'nullable|exists:materials,id,material,hosting',
            'ssl_material_id' => 'nullable|exists:materials,id,material,ssl',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $request->except('domain_material_ids');
        $customer->update($validated);

        $domainIds = $request->input('domain_material_ids');
        $customer->domainMaterials()->sync($domainIds);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $customer): JsonResponse
    {
        $customer = $this->__checkIdExists($customer);
        $customer->domainMaterials()->detach();
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dihapus.'
        ]);
    }

    public function pay(Request $request): JsonResponse
    {
        $customer = $this->__checkIdExists($request->input('customer_id'));

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'payment_amount' => 'required|decimal:0,2',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        // Payment Create
        $validated = $validator->validate();
        $validated['due_date'] = $customer->due_date;
        $validated['price'] = $customer->price;
        $validated['payment_amount'] = $customer->price;
        Payment::create($validated);

        // Customer update
        $customer->update([
            'price' => $request->input('payment_amount'),
            'due_date' => $request->input('due_date'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data bayar berhasil ditambah.'
        ]);
    }

    private function __checkIdExists(int $id, bool $withMaterial = false)
    {
        $customer = Customer::where('id', $id);

        if ($withMaterial) {
            $customer->with(['domainMaterials', 'sslMaterial', 'hostingMaterial']);
        }

        $customer = $customer->first();
        if (!$customer) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => [
                    'message' => ['Not found.']
                ]
            ], 404));
        }

        return $customer;
    }
}
