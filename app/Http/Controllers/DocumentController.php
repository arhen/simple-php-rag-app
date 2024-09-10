<?php

namespace App\Http\Controllers;

use App\Services\RagService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Entities\DocumentEntity;

class DocumentController extends Controller
{
    private $ragService;

    public function __construct(RagService $ragService)
    {
        $this->ragService = $ragService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:10240',
        ]);

        $file = $request->file('document');
        $path = $file->store('documents');
        $fullPath = storage_path('app/' . $path);

        try {
            $this->ragService->addDocument($fullPath, $request->user());
        } catch (\Exception $e) {
            Log::error('Document upload failed: ' . $e->getMessage());

            return back()->withErrors(['document' => 'An error occurred while uploading the document.']);
        } finally {
            // Clean up the temporary file
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        return redirect()->back()->with('success', 'Document uploaded and embedded successfully');
    }
}
