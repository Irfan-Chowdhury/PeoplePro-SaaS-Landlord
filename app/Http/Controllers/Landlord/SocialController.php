<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Social\StoreRequest;
use App\Http\Requests\Social\UpdateRequest;
use App\Models\Landlord\Social;
use App\Services\SocialService;
use Exception;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index(SocialService $socialService)
    {
        $socials = $socialService->getAll();

        if (request()->ajax()) {
            return datatables()->of($socials)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->addColumn('icon', function ($row) {
                    return '<i class="'.$row->icon.' text-primary"></i>&nbsp;'.$row->icon;
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
                ->rawColumns(['icon', 'action'])
                ->make(true);
        }

        return view('landlord.super-admin.pages.socials.index');
    }

    public function store(StoreRequest $request)
    {
        try {
            $maxPosition = Social::max('position') + 1;
            Social::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'link' => $request->link,
                'position' => $maxPosition,
            ]);

            return response()->json(['success' => 'Data Saved Successfully']);
        } catch (Exception $exception) {
            return response()->json(['errorMsg' => $exception->getMessage()], 422);
        }
    }

    public function edit(Social $social)
    {
        return response()->json($social);
    }

    public function update(UpdateRequest $request, Social $social)
    {
        try {
            $social->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'link' => $request->link, //This process not work
            ]);

            return response()->json(['success' => 'Data Updated Successfully']);
        } catch (Exception $exception) {
            return response()->json(['errorMsg' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Social $social)
    {
        try {
            $social->delete();

            return response()->json(['success' => 'Data Deleted Successfully']);
        } catch (Exception $exception) {
            return response()->json(['errorMsg' => $exception->getMessage()], 422);
        }
    }

    public function sort(Request $request)
    {
        $socials = Social::all();
        foreach ($socials as $social) {
            $social->timestamps = false; // To disable update_at field updation
            foreach ($request->order as $order) {
                if ($order['id'] == $social->id) {
                    $social->update(['position' => $order['position']]);
                }
            }
        }

        return response()->json(['success' => 'Order changed successfully']);
    }
}
