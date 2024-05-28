<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function show(Request $request): Response
    {
        $filename = $request->query('path');

        if (!Storage::exists($filename)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $file = Storage::get($filename);
        $mimeType = Storage::mimeType($filename);
        return response($file)->header('Content-Type', $mimeType);
    }
}
