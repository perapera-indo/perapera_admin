<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ContentTranslationRepository;

class FileDownloadController extends Controller
{
    protected $repository;
    public function __construct()
    {
        $this->repository = new ContentTranslationRepository();
    }

    public function downloadXlf($id)
    {
        $filePath = $this->repository->generateFileOutputXlf($id);
        return response()->download($filePath);
    }
}
