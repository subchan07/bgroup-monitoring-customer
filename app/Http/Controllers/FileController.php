<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function allFile(Request $request): JsonResponse
    {
        $directory = $request->query('directory');
        $files = Storage::disk('local')->allFiles($directory);

        $files = collect($files)->map(function ($file) {
            $lastModified = Storage::lastModified($file);
            return [
                'name' => basename($file),
                'original' => $file,
                'size' => Storage::size($file),
                'last_modified' => Carbon::createFromTimestamp($lastModified)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json(['success' => true, 'data' => $files]);
    }

    public function show(Request $request)
    {
        $pathFile = $request->query('path');

        if (!Storage::exists($pathFile)) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        $file = Storage::get($pathFile);
        $mimeType = Storage::mimeType($pathFile);
        return response($file)->header('Content-Type', $mimeType);
    }

    public function delete(Request $request)
    {
        $pathFile = $request->input('path');

        if (!Storage::exists($pathFile)) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        Storage::delete($pathFile);
        return response()->json(['success' => true, 'message' => 'File berhasil dihapus']);
    }

    public function download(Request $request)
    {
        $pathFile = $request->input('path');

        if (!Storage::exists($pathFile)) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        return Storage::download($pathFile);
    }
}
