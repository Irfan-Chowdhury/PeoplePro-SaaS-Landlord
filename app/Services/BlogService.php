<?php

namespace App\Services;

use App\Contracts\BlogContract;
use App\Facades\Alert;
use App\Facades\Utility;
use Exception;

class BlogService
{

    private $imagePath = 'landlord/images/blog/';
    private $ogImagePath = 'landlord/images/blog/og_image/';

    public function __construct(public BlogContract $blogContract){}

    public function yajraDataTable($languageId)
    {
        if (request()->ajax()) {
            $blogs = $this->blogContract->getAllByLanguageId($languageId);

            return datatables()->of($blogs)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->addColumn('image', function ($row) {
                    $url = url($this->imagePath.$row->image);
                    return '<img src="'.$url.'" height="50px" width="50px"/>';
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
            $imageName = Utility::imageFileStore($request->image, $this->imagePath, 600, 400);
            $ogImageName = Utility::imageFileStore($request->image, $this->ogImagePath, 300, 200);
            if($imageName && $ogImageName) {
                $data['image'] = $imageName;
                $data['og_image'] = $imageName;
            }
            $this->blogContract->create($data);

            return Alert::successMessage('Data Saved Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function updateInfo($request, $id, $languageId)
    {
        try {
            $data = $this->requestHandle($request, $languageId);
            if($request->image) {
                $blog = $this->blogContract->getById($id);
                Utility::fileDelete($this->imagePath, $blog->image);
                Utility::fileDelete($this->ogImagePath, $blog->og_image);
                $data['image'] = Utility::imageFileStore($request->image, $this->imagePath, 600, 400);
                $data['og_image'] = Utility::imageFileStore($request->image, $this->ogImagePath, 300, 200);
            }
            $this->blogContract->update($id, $data);

            return Alert::successMessage('Data Updated Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }


    public function remove($id)
    {
        try {
            $blog = $this->blogContract->getById($id);
            Utility::fileDelete($this->imagePath, $blog->image);
            Utility::fileDelete($this->ogImagePath, $blog->og_image);

            $this->blogContract->delete($id);

            return Alert::successMessage('Data Deleted Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    private function requestHandle($request, $languageId)
    {
        $data = [
            'language_id' => $languageId,
            'title' => $request->title,
            'slug' => Utility::slugGenerate($request->title),
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
        ];

        return $data;
    }
}
