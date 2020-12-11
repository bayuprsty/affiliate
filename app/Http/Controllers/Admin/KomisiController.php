<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Image;
use File;

use App\Models\ServiceCommission;
use App\Models\CommissionType;
use App\Models\Vendor;
use App\Models\Transaction;

class KomisiController extends Controller
{
    public function index () {
        $commissionType = CommissionType::orderBy('id')->get();
        $vendor = Vendor::orderBy('id')->get();

        return view('admin.komisi.index', compact('commissionType', 'vendor'));
    }

    public function store (Request $request) {
        if ($request->ajax()) {
            $message = [
                'vendor_id.required' => 'Vendor tidak boleh kosong',
                'title.required' => 'Title tidak boleh kosong',
                'service_link.required' => 'Service Link tidak boleh kosong',
                'marketing_text.required' => 'Marketing Text tidak boleh kosong',
                'commission_type_id.required' => 'Tipe Komisi tidak boleh kosong',
                'commission_value.required' => 'Commission Value tidak boleh kosong'
            ];

            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required',
                'title' => 'required|string',
                'service_link' => 'required|string',
                'marketing_text' => 'required|string',
                'commission_type_id' => 'required',
                'commission_value' => 'required|string'
            ], $message);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    $error[] = $value[0];
                }
    
                $stringError = implode(', ', $error);;
    
                return $this->sendResponse($stringError, '', 422);
            }

            $vendor = Vendor::findOrfail($request->vendor_id);

            if ($request->file('image_upload')) {
                $path = public_path('uploads/'.$vendor->name);
                
                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }

                $img = $request->file('image_upload');
                $filename = time().'.'.$img->getClientOriginalExtension();

                Image::make($img)->save( $path.'/'.$filename );
            }

            $data = [
                'vendor_id' => $request->vendor_id,
                'title' => $request->title,
                'description' => $request->description,
                'service_link' => $request->service_link,
                'marketing_text' => $request->marketing_text,
                'img_upload' => $filename,
                'commission_type_id' => $request->commission_type_id,
                'commission_value' => $request->commission_value
            ];
    
            $saveSuccess = ServiceCommission::create($data);
            
            if ($saveSuccess) {
                return $this->sendResponse('Komisi Berhasil ditambahkan');
            }
        }
    }

    public function edit (Request $request) {
        if (request()->ajax()) {
            $serviceCommission = ServiceCommission::findOrFail($request->id);
            return response()->json($serviceCommission);
        }
    }

    public function update (Request $request) {
        if ($request->ajax()) {
            $message = [
                'vendor_id.required' => 'Vendor tidak boleh kosong',
                'title.required' => 'Title tidak boleh kosong',
                'service_link.required' => 'Service Link tidak boleh kosong',
                'marketing_text.required' => 'Marketing Text tidak boleh kosong',
                'commission_type_id.required' => 'Tipe Komisi tidak boleh kosong',
                'commission_value.required' => 'Commission Value tidak boleh kosong'
            ];

            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required',
                'title' => 'required|string',
                'service_link' => 'required|string',
                'marketing_text' => 'required|string',
                'commission_type_id' => 'required',
                'commission_value' => 'required|string'
            ], $message);

            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    $error[] = $value[0];
                }
    
                $stringError = implode(', ', $error);;
    
                return $this->sendResponse($stringError, '', 422);
            }
    
            $serviceCommission = ServiceCommission::findOrfail($request->idCommission);
            $vendor = Vendor::findOrfail($serviceCommission->vendor_id);

            if ($request->file('image_upload')) {
                $img = $request->file('image_upload');
                $oldFilename = $serviceCommission->img_upload;
                
                $path = public_path('uploads/'.$vendor->name);

                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }
                
                if (!is_null($oldFilename) && file_exists($path.'/'.$oldFilename)) {
                    unlink($path.'/'.$oldFilename);
                }
                
                $filename = time().'.'.$img->getClientOriginalExtension();
                Image::make($img)->save( $path.'/'.$filename );
            } else {
                $filename = !is_null($serviceCommission->img_upload) ? $serviceCommission->img_upload : NULL;
            }
    
            $updateSuccess = $serviceCommission->update([
                'vendor_id' => $request->vendor_id,
                'title' => $request->title,
                'description' => $request->description,
                'service_link' => $request->service_link,
                'marketing_text' => $request->marketing_text,
                'img_upload' => $filename,
                'commission_type_id' => $request->commission_type_id,
                'commission_value' => $request->commission_value,
            ]);

            if ($updateSuccess) {
                return $this->sendResponse('Komisi Berhasil diupdate');
            }
        }
    }

    public function destroy (Request $request) {
        if ($request->ajax()) {
            $isData = Transaction::where('service_commission_id', $request->id)->get();
            if (count($isData) > 0) {
                return $this->sendResponse('Commission used in another features', '', 221);
            } else {
                $isDeleted = ServiceCommission::findOrfail($request->id)->delete();

                if ($isDeleted) {
                    return $this->sendResponse('Commission Deleted');
                }
            }
        }
    }
}
