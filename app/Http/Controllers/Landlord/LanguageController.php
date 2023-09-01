<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Language\StoreRequest;
use App\Http\Requests\Language\UpdateRequest;
use App\Models\Landlord\Language;
use App\Services\LanguageService;

class LanguageController extends Controller
{
    private $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index()
    {
        return view('landlord.super-admin.pages.languages.index');
    }

    public function datatable()
    {
        return $this->languageService->yajraDataTable();
    }

    public function store(StoreRequest $request)
    {
        $result = $this->languageService->storeLanguage($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit(Language $language)
    {
        return response()->json($language);
    }

    public function update(UpdateRequest $request, Language $language)
    {
        $result = $this->languageService->updateLanguage($request, $language);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy(Language $language)
    {
        $result = $this->languageService->deleteLanguage($language);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
