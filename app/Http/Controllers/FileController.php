<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $file = $request->file('file');
        $filename = time() . '-' . $file->getClientOriginalName();
        $folder = 'profile_pics';
        $filePath = $request->file('file')->storeAs($folder, $filename, 'public');

        return response()->json(['message' => 'file upload', 'path' => $filePath ]);
    }
}
