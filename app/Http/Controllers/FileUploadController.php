<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FileUploadController extends Controller
{
    public function view(): View
    {
        return view('admin.fileUpload');
    }

    public function upload(Request $request): JsonResponse
    {
        $fileName = time() . '.' . $request->file('file')->getClientOriginalExtension();
        $request->file('file')->move(public_path('files'), $fileName);
        return response()->json(['success' => true, 'message' => 'File uploaded successfully']);
    }
}
