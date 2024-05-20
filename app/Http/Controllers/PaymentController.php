<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentCollection;
use Illuminate\Http\Exceptions\HttpResponseException;

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

        if ($limit) $payments->limit($limit);
        if ($year) $payments->whereYear('date', $year);

        $payments = $payments->orderBy('date')->get();

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

    public function getAnnualPaymentSummary(Request $request): JsonResponse
    {
        $currentYear = date('Y');
        $year = $request->query('year') ?? $currentYear;

        $years = array_unique(array_merge(
            Material::selectRaw('YEAR(due_date) as year')->distinct()->pluck('year')->toArray(),
            Customer::selectRaw('YEAR(due_date) as year')->distinct()->pluck('year')->toArray()
        ));
        sort($years);

        // Ambil summary berdasarkan bulan dari database
        $summaryMaterial = Material::selectRaw('DATE_FORMAT(due_date, "%Y-%m") as month, SUM(price) as total_price')->whereYear('due_date', $year)->groupBy('month')->pluck('total_price', 'month');
        $summaryCustomer = Customer::selectRaw('DATE_FORMAT(due_date, "%Y-%m") as month, SUM(price) as total_price')->whereYear('due_date', $year)->groupBy('month')->pluck('total_price', 'month');

        // Buat array kosong untuk menyimpan summary per bulan
        $monthlySummary = [];

        // Buat array untuk mewakili 12 bulan dari Januari sampai Desember
        $months = Carbon::parse("$year-01-01")->startOfMonth();

        for ($i = 0; $i < 12; $i++) {
            $monthKey = $months->format('Y-m');

            $material = $summaryMaterial[$monthKey] ?? 0;
            $customer = $summaryCustomer[$monthKey] ?? 0;

            $monthlySummary[$monthKey] =  $material + $customer;
            $months->addMonth();
        }

        $sumMaterialCurrentYear = Material::whereYear('due_date', $currentYear)->sum('price');
        $sumCustomerCurrentYear = Customer::whereYear('due_date', $currentYear)->sum('price');
        $totalSummaryCurrentYear = $sumMaterialCurrentYear + $sumCustomerCurrentYear;

        // calculate the total profit fot the current year form payments
        $paymentsSummary = Payment::selectRaw('
            SUM(CASE WHEN material_id IS NOT NULL THEN payment_amount ELSE 0 END) AS total_price_material,
            SUM(CASE WHEN customer_id IS NOT NULL THEN payment_amount ELSE 0 END) AS total_price_customer,
            SUM(payment_amount) AS total_price
        ')->whereYear('date', $currentYear)->first();

        return response()->json([
            'data' => [
                'years' => $years,
                'monthly_customer_summary' => $monthlySummary,
                'material_summary_current_year' => $sumMaterialCurrentYear,
                'customer_summary_current_year' => $sumCustomerCurrentYear,
                'total_summary_current_year' => $totalSummaryCurrentYear,
                'paymentSummary' => [
                    'total_price_material' => $paymentsSummary->total_price_material,
                    'total_price_customer' => $paymentsSummary->total_price_customer,
                    'total_price' => $paymentsSummary->total_price
                ]
            ],
            'success' => true,
        ]);
    }
}
