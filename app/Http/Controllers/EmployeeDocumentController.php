<?php

namespace App\Http\Controllers;

use App\Facades\Utility;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeDocumentController extends Controller
{
    public function show(Employee $employee)
    {
        $logged_user = auth()->user();
        $employee_id = $employee->id;

        if ($logged_user->can('view-details-employee') || $logged_user->id == $employee_id) {
            if (request()->ajax()) {
                return datatables()->of(EmployeeDocument::with('DocumentType')->where('employee_id', $employee->id)->get())
                    ->setRowId(function ($document) {
                        return $document->id;
                    })
                    ->addColumn('document', function ($row) {
                        return $row->DocumentType->document_type;
                    })
                    ->addColumn('expiry_date', function ($row) {
                        return $row->expiry_date;
                    })
                    ->addColumn('title', function ($row) {
                        if ($row->document_file) {
                            return $row->document_title.'<br><h6><a href="'.route('documents_document.download', $row->id).'">'.trans('file.File').'</a></h6>';
                        } else {
                            return $row->document_title;
                        }
                    })
                    ->addColumn('action', function ($data) use ($logged_user, $employee_id) {
                        if ($logged_user->can('modify-details-employee') || $logged_user->id == $employee_id) {
                            $button = '<button type="button" name="edit" id="'.$data->id.'" class="document_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                            $button .= '&nbsp;&nbsp;';
                            $button .= '<button type="button" name="delete" id="'.$data->id.'" class="document_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

                            return $button;
                        } else {
                            return '';
                        }
                    })
                    ->rawColumns(['action', 'title'])
                    ->make(true);
            }
        }

    }

    public function store(Request $request, $employee)
    {
        $logged_user = auth()->user();
        if ($logged_user->can('store-details-employee') || $logged_user->id == $employee) {
            $validator = Validator::make($request->only('document_title', 'document_type_id', 'expiry_date',
                'description', 'document_file', 'is_notify'),
                [
                    'document_title' => 'required',
                    'document_type_id' => 'required',
                    'expiry_date' => 'required',
                    'document_file' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
                ]
                //				,
                //				[
                //					'document_title.required' => 'Document Title can not be empty',
                //					'expiry_date.required' => 'Expiry Date can not be empty',
                //					'document_type_id.required' => 'Please select document Type',
                //					'notification_email.email' => 'please enter a valid email',
                //					'document_file.file'=>'File is not valid',
                //					'document_file.max'=>'File must be less than 10 mb',
                //					'document_file.mimes'=>'File must be of (jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf) type',
                //				]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];

            $data['document_title'] = $request->document_title;
            $data['employee_id'] = $employee;
            $data['document_type_id'] = $request->document_type_id;
            $data['expiry_date'] = $request->expiry_date;
            $data['description'] = $request->description;
            $data['is_notify'] = $request->is_notify;

            $data['document_file'] = Utility::fileUploadHandle($request->document_file, tenantPath().'/uploads/employee_documents', $request->document_title);

            EmployeeDocument::create($data);

            return response()->json(['success' => __('Data Added successfully.')]);
        }

        return response()->json(['success' => __('You are not authorized')]);

    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = EmployeeDocument::findOrFail($id);

            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->hidden_id;
        $logged_user = auth()->user();
        if ($logged_user->can('modify-details-employee') || $logged_user->id == $id) {
            $validator = Validator::make($request->only('document_title', 'document_type_id', 'expiry_date',
                'description', 'document_file', 'is_notify'),
                [
                    'document_title' => 'required',
                    'document_type_id' => 'required',
                    'expiry_date' => 'required',
                    'document_file' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
                ]
                //				,
                //				[
                //					'document_title.required' => 'Document Title can not be empty',
                //					'expiry_date.required' => 'Expiry Date can not be empty',
                //					'document_type_id.required' => 'Please select document Type',
                //					'notification_email.email' => 'please enter a valid email',
                //					'document_file.file'=>'File is not valid',
                //					'document_file.max'=>'File must be less than 10 mb',
                //					'document_file.mimes'=>'File must be of (jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf) type',
                //				]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['document_title'] = $request->document_title;
            $data['document_type_id'] = $request->document_type_id;
            $data['expiry_date'] = $request->expiry_date;
            $data['description'] = $request->description;
            $data['is_notify'] = $request->is_notify;

            $employeeDocument = EmployeeDocument::find($id);
            $file = $request->document_file;

            if (isset($file)) {
                $directory = tenantPath().'/uploads/employee_documents/';
                Utility::fileDelete($directory, $employeeDocument->document_file);
                $data['document_file'] = Utility::fileUploadHandle($request->document_file, $directory, $request->document_title);
            }

            $employeeDocument->update($data);

            return response()->json(['success' => __('Data is successfully updated')]);
        } else {

            return response()->json(['success' => __('You are not authorized')]);
        }
    }

    public function destroy($id)
    {
        $logged_user = auth()->user();
        if ($logged_user->can('modify-details-employee') || $logged_user->id == $id) {
            $employeeDocument = EmployeeDocument::find($id);
            Utility::fileDelete(tenantPath().'/uploads/employee_documents/', $employeeDocument->document_file);
            $employeeDocument->delete();

            return response()->json(['success' => __('Data is successfully deleted')]);
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function download($id)
    {
        $file = EmployeeDocument::findOrFail($id);

        $file_path = $file->document_file;

        $download_path = public_path(tenantPath().'/uploads/employee_documents/'.$file_path);

        if (file_exists($download_path)) {
            $response = response()->download($download_path);

            return $response;
        } else {
            return abort('404', __('File not Found'));
        }
    }
}
