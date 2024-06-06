<?php

namespace App\Http\Controllers;

use App\Http\Resources\OprasionalCollection;
use App\Http\Resources\OprasionalResource;
use App\Models\Oprasional;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OprasionalController extends Controller
{
    public function index(): OprasionalCollection
    {
        $oprasionals = Oprasional::get();
        return new OprasionalCollection($oprasionals);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'needs' => 'required|string',
            'detail' => 'required|string',
            'price' => 'required|decimal:0,2',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $validator->validate();
        Oprasional::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Oprasional berhasil ditambahkan'
        ], 201);
    }

    public function show(int $oprasional): OprasionalResource
    {
        $oprasional = $this->__checkIdExists($oprasional);
        return new OprasionalResource($oprasional);
    }

    public function update(Request $request, int $oprasional): JsonResponse
    {
        $oprasional = $this->__checkIdExists($oprasional);

        $validator = Validator::make($request->all(), [
            'detail' => 'required',
            'price' => 'required|decimal:0,2',
            'date' => 'required|date',
            'needs' => 'required|string',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400));
        }

        $validated = $validator->validate();
        $oprasional->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Oprasional berhasil diubah'
        ]);
    }

    public function destroy(int $oprasional): JsonResponse
    {
        $oprasional = $this->__checkIdExists($oprasional);

        $oprasional->delete();

        return response()->json([
            'success' => true,
            'message' => 'Oprasional berhasil dihapus'
        ]);
    }

    private function __checkIdExists(int $id)
    {
        $oprasional = Oprasional::where('id', $id)->first();
        if (!$oprasional) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => [
                    'message' => ['Not found.']
                ]
            ], 404));
        }

        return $oprasional;
    }
}
