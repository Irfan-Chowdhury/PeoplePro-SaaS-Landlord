<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use JoeDixon\Translation\Drivers\Translation;
use JoeDixon\Translation\Http\Requests\LanguageRequest;
use JoeDixon\Translation\Http\Requests\TranslationRequest;

class TranslationController extends Controller
{
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request, $language)
    {
        if ($request->has('language') && $request->get('language') !== $language) {
            return redirect()->route('languages.translations.index', ['language' => $request->get('language'), 'group' => $request->get('group'), 'filter' => $request->get('filter')]);
        }

        $languages = $this->translation->allLanguages();
        $groups = $this->translation->getGroupsFor(config('app.locale'))->merge('single');
        $translations = $this->translation->filterTranslationsFor($language, $request->get('filter'));

        if ($request->has('group') && $request->get('group')) {
            if ($request->get('group') === 'single') {
                $translations = $translations->get('single');
                $translations = new Collection(['single' => $translations]);
            } else {
                $translations = $translations->get('group')->filter(function ($values, $group) use ($request) {
                    return $group === $request->get('group');
                });
                $translations = new Collection(['group' => $translations]);
            }
        }

        return view('landlord.super-admin.pages.translations.index', compact('language', 'languages', 'groups', 'translations'));
    }

    public function create(Request $request, $language)
    {
        return view('landlord.super-admin.pages.translations.create', compact('language'));
    }

    public function store(TranslationRequest $request, $language)
    {
        if ($request->filled('group')) {
            $namespace = $request->has('namespace') && $request->get('namespace') ? "{$request->get('namespace')}::" : '';
            $this->translation->addGroupTranslation($language, "{$namespace}{$request->get('group')}", $request->get('key'), $request->get('value') ?: '');
        } else {
            $this->translation->addSingleTranslation($language, 'single', $request->get('key'), $request->get('value') ?: '');
        }

        session()->flash('message', 'Translation Successfully Added.');
        session()->flash('type', 'success');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $language = $request->language;

        if (!Str::contains($request->get('group'), 'single')) {
            $this->translation->addGroupTranslation($language, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        } else {
            $this->translation->addSingleTranslation($language, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        }

        return ['success' => true];
    }

    // public function create()
    // {
    //     return view('translation::languages.create');
    // }

    // public function store(LanguageRequest $request)
    // {
    //     if (!env('USER_VERIFIED')) {
    //         return redirect()->back()->with(['error' => 'This feature is disabled for demo!']);
    //     }

    //     $this->translation->addLanguage($request->locale, $request->name);

    //     return redirect()
    //         ->route('languages.index')
    //         ->with('success', __('translation::translation.language_added'));
    // }

    public function languageSwitch($locale)
    {
        setcookie('language', $locale, time() + (86400 * 365), '/');

        $language = Language::where('locale', $locale)->first();
        Session::put('TempSuperAdminLangId', $language->id);
        Session::put('DefaultSuperAdminLocale', $language->locale);
        Session::put('TempSuperAdminLocale', $language->locale);

        return back();
    }

    public function languageDelete(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            session()->flash('message', 'This feature is disabled for demo!');
            session()->flash('type', 'danger');
            return response()->json('error');
        }

        $path = base_path('resources/lang/' . $request->langVal);
        if (File::exists($path)) {
            File::deleteDirectory($path);
            session()->flash('message', 'Successfully Deleted.');
            session()->flash('type', 'success');
            return response()->json('success');
        }
    }


}
