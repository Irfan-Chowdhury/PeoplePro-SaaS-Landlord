<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Models\Landlord\FaqDetail;
use App\Services\FaqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaqController extends Controller
{
    private $faqService;
    private $languageId;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;

        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempSuperAdminLangId') ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }
    public function index()
    {
        $faq = $this->faqService->getLatestDataByLangId($this->languageId);
        return view('landlord.super-admin.pages.faqs.index',compact('faq'));
    }

    public function datatable()
    {
        return $this->faqService->yajraDataTable($this->languageId);
    }

    public function store(StoreFaqRequest $request)
    {
        $result = $this->faqService->save($request, $this->languageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit(FaqDetail $faqDetail)
    {
        return response()->json($faqDetail);
    }

    public function update(UpdateFaqRequest $request, $id)
    {
        $result = $this->faqService->updateInfo($request, $id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy($id)
    {
        $result = $this->faqService->remove($id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function sort(Request $request)
    {
        $result = $this->faqService->sortingDataTable($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
