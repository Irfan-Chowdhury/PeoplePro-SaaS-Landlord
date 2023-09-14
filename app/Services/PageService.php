<?php

namespace App\Services;

use App\Contracts\PageContract;
use App\Facades\Alert;
use App\Facades\Utility;
use Exception;

class PageService
{
    public function __construct(public PageContract $pageContract){}

    public function yajraDataTable($languageId)
    {
        if (request()->ajax()) {
            $pages = $this->pageContract->getAllByLanguageId($languageId);

            return datatables()->of($pages)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->addColumn('title', function ($row) {
                    return $row->title ?? '';
                })
                ->addColumn('action', function ($row) {
                    $button = '<button type="button" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

                    return $button;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }

    public function save($request, $languageId)
    {
        try {
            $data = $this->requestHandle($request, $languageId);
            $this->pageContract->create($data);

            return Alert::successMessage('Data Saved Successfully');
        }
        catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function updateInfo($request, $id, $languageId)
    {
        try {
            $data = $this->requestHandle($request, $languageId);
            $this->pageContract->update($id, $data);

            return Alert::successMessage('Data Updated Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }


    public function remove($id)
    {
        try {
            $this->pageContract->delete($id);
            return Alert::successMessage('Data Deleted Successfully');
        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    private function requestHandle($request, $languageId)
    {
        return [
            'language_id' => $languageId,
            'title' => $request->title,
            'slug' => Utility::slugGenerate($request->title),
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];
    }
}
