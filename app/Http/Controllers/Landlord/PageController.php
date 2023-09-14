<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Models\Landlord\Page;
use App\Services\PageService;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    private $languageId;

    public function __construct(private PageService $pageService)
    {
        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempSuperAdminLangId') ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    public function index()
    {
        return view('landlord.super-admin.pages.pages.index');
    }

    public function datatable()
    {
        return $this->pageService->yajraDataTable($this->languageId);
    }

    public function store(StorePageRequest $request)
    {
        $result = $this->pageService->save($request, $this->languageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit(Page $page)
    {
        return response()->json($page);
    }

    public function update(UpdatePageRequest $request, $id)
    {
        $result = $this->pageService->updateInfo($request, $id, $this->languageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy($id)
    {
        $result = $this->pageService->remove($id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
