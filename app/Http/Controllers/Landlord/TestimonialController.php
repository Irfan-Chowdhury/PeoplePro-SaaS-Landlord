<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Testimonial\StoreTestimonialRequest;
use App\Http\Requests\Testimonial\UpdateTestimonialRequest;
use App\Models\Landlord\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TestimonialController extends Controller
{
    // private $testimonialService;
    private $languageId;
    public function __construct(public TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;

        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempSuperAdminLangId') ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }
    public function index()
    {
        return view('landlord.super-admin.pages.testimonials.index');
    }

    public function datatable()
    {
        return $this->testimonialService->yajraDataTable();
    }

    public function store(StoreTestimonialRequest $request)
    {
        $result = $this->testimonialService->save($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit(Testimonial $testimonial)
    {
        return response()->json($testimonial);
    }

    public function update(UpdateTestimonialRequest $request, $id)
    {
        $result = $this->testimonialService->updateInfo($request, $id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy($id)
    {
        $result = $this->testimonialService->remove($id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function sort(Request $request)
    {
        $result = $this->testimonialService->sortingDataTable($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
