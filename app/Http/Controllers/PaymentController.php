<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): PaymentCollection
    {
        $limit = (int) $request->query('limit');
        $year = (int) $request->query('year');

        $payments = Payment::query()->with(['material', 'customer' => function ($query) {
            $query->with(['domainMaterial', 'hostingMaterial', 'sslMaterial']);
        }]);

        if ($limit) $payments = $payments->limit($limit);
        if ($year) $payments = $payments->whereYear('date', $year);

        $payments= $payments->orderBy('date')->get();

        return new PaymentCollection($payments);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $payment): PaymentResource
    {
        $result = $this->__checkIdExists($payment);
        return new PaymentResource($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }

    private function __checkIdExists(int $id)
    {
        $payment = Payment::where('id', $id)->first();
        if (!$payment) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => ['Not found.']
                ]
            ], 404));
        }

        return $payment;
    }
}
