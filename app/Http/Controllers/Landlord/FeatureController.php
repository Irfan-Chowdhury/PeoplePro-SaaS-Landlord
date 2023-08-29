<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\StoreRequest;
use App\Http\Requests\Feature\UpdateRequest;
use App\Models\Landlord\Module;
use App\Services\FeatureService;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    private $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    public function index()
    {
        return view('landlord.super-admin.pages.features.index');
    }

    public function datatable()
    {
        return $this->featureService->yajraDataTable();
    }

    public function store(StoreRequest $request)
    {
        $result = $this->featureService->save($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit($id)
    {
        $result = $this->featureService->showObject($id);

        return response()->json($result);
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->featureService->updateInfo($request, $id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy($id)
    {
        $result = $this->featureService->remove($id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function sort(Request $request)
    {
        $result = $this->featureService->sortingDataTable($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
