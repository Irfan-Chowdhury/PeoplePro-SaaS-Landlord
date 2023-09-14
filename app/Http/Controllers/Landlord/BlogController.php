<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Models\Landlord\Blog;
use App\Services\BlogService;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    private $languageId;

    public function __construct(private BlogService $blogService)
    {
        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempSuperAdminLangId') ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    public function index()
    {
        return view('landlord.super-admin.pages.blogs.index');
    }

    public function datatable()
    {
        return $this->blogService->yajraDataTable($this->languageId);
    }

    public function store(StoreBlogRequest $request)
    {
        $result = $this->blogService->save($request, $this->languageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit(Blog $blog)
    {
        return response()->json($blog);
    }

    public function update(UpdateBlogRequest $request, $id)
    {
        $result = $this->blogService->updateInfo($request, $id, $this->languageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy($id)
    {
        $result = $this->blogService->remove($id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
