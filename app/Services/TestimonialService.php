<?php

namespace App\Services;

use App\Contracts\TestimonialContract;
use App\Facades\Alert;
use App\Facades\Utility;
use Exception;

class TestimonialService
{
    private $imagePath = 'landlord/images/testimonial/';

    public function __construct(public TestimonialContract $testimonialContract){}

    public function yajraDataTable()
    {
        if (request()->ajax()) {
            $features = $this->testimonialContract->getOrderByPosition();

            return datatables()->of($features)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->addColumn('image', function ($row) {
                    $url = url($this->imagePath.$row->image);
                    return '<img src="'.$url.'" height="50px" width="50px"/>';
                })
                ->addColumn('name', function ($row) {
                    return $row->name ?? '';
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

    public function save($request)
    {
        try {
            $maxPosition = $this->testimonialContract->getMaxPosition() + 1;

            $data = $this->requestHandle($request, $maxPosition);
            $imageName = Utility::imageFileHandle($request->image, $this->imagePath, false);
            if($imageName) {
                $data['image'] = $imageName;
            }
            $this->testimonialContract->create($data);

            return Alert::successMessage('Data Saved Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function showObject($id)
    {
        return $this->testimonialContract->getById($id);
    }

    public function updateInfo($request, $id)
    {
        try {
            $data = $this->requestHandle($request);

            $imageName = Utility::imageFileHandle($request->image, $this->imagePath, false);
            if($imageName) {
                $data['image'] = $imageName;
                $testimonial = $this->testimonialContract->getById($id);
                Utility::fileDelete($this->imagePath, $testimonial->image);
            }
            $this->testimonialContract->update($id, $data);

            return Alert::successMessage('Data Updated Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function remove($id)
    {
        try {
            $testimonial = $this->testimonialContract->getById($id);
            Utility::fileDelete($this->imagePath, $testimonial->image);

            $this->testimonialContract->delete($id);

            return Alert::successMessage('Data Deleted Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function sortingDataTable($request)
    {
        try {

            $allPositionData = $this->testimonialContract->getOrderByPosition();;
            foreach ($allPositionData as $item) {
                $item->timestamps = false; // To disable update_at field updation
                foreach ($request->order as $order) {
                    if ($order['id'] == $item->id) {
                        $data['position'] = $order['position'];
                        $this->testimonialContract->update($item->id, $data);
                    }
                }
            }

            return Alert::successMessage('Order changed successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    private function requestHandle($request, $maxPosition = null)
    {
        $data = [];
        $data['name'] = $request->name;
        $data['business_name'] = $request->business_name;
        $data['description'] = $request->description;
        if ($maxPosition) {
            $data['position'] = $maxPosition;
        }

        return $data;
    }
}


