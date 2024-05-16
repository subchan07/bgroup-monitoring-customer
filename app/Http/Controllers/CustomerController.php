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
    public function index(): CustomerCollection
    {
        $customers = Customer::with(['domainMaterial', 'hostingMaterial', 'sslMaterial'])->orderBy('due_date')->get();
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
            'domain_material_id' => 'nullable|exists:materials,id,material,domain',
            'hosting_material_id' => 'nullable|exists:materials,id,material,hosting',
            'ssl_material_id' => 'nullable|exists:materials,id,material,ssl',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $validator->validated();
        Customer::create($validated);

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
        $withMaterial= $request->query('withMaterial') ?? false;

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
            'domain_material_id' => 'nullable|exists:materials,id,material,domain',
            'hosting_material_id' => 'nullable|exists:materials,id,material,hosting',
            'ssl_material_id' => 'nullable|exists:materials,id,material,ssl',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $validator->validated();
        $customer->update($validated);

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
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dihapus.'
        ]);
    }

    public function bayar(Request $request): JsonResponse
    {
        $customer = $this->__checkIdExists($request->input('customer_id'));

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
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
        if ($validated['payment_amount'] != $customer->price) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => [
                    'payment_amount' => ['Nilai pembayaran harus sama dengan harga lama.']
                ]
            ], 400));
        }

        $validated['due_date'] = $customer->due_date;
        $validated['price'] = $customer->price;
        Payment::create($validated);

        $customer->update([
            'price' => $request->input('price'),
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

        if($withMaterial){
            $customer->with(['domainMaterial', 'sslMaterial', 'hostingMaterial']);
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
