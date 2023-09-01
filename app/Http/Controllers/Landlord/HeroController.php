<?php

namespace App\Http\Controllers\Landlord;

use App\Facades\Alert;
use App\Facades\Utility;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hero\HeroManageRequest;
use App\Models\Landlord\Hero;
use App\Models\Landlord\Language;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HeroController extends Controller
{
    public $languageId;
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempSuperAdminLangId')==true ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    public function index()
    {
        $hero = Hero::where('language_id',$this->languageId)->latest()->first();
        return view('landlord.super-admin.pages.heroes.index',compact('hero'));
    }

    public function updateOrCreate(HeroManageRequest $request)
    {
        try {
            $data = [
                'heading' => $request->heading,
                'sub_heading' => $request->sub_heading,
                'button_text' => $request->button_text,
            ];

            $imageName = Utility::imageFileHandle($request->image, $path='landlord/images/hero/');
            if($imageName) {
                $data['image'] = $imageName;
            }

            Hero::updateOrCreate(['language_id' => $this->languageId,], $data);
            $result = Alert::successMessage('Data Submitted Successfully');
        }
        catch (Exception $exception) {
            $result = Alert::errorMessage($exception->getMessage());
        }

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
