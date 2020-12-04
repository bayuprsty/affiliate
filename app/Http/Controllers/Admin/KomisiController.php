<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;

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
                'commission_type_id.required' => 'Tipe Komisi tidak boleh kosong',
                'commission_value.required' => 'Commission Value tidak boleh kosong'
            ];

            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required',
                'title' => 'required|string',
                'service_link' => 'required|string',
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
    
            $saveSuccess = ServiceCommission::create($request->except('idCommission'));
            
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
                'commission_type_id.required' => 'Tipe Komisi tidak boleh kosong',
                'commission_value.required' => 'Commission Value tidak boleh kosong'
            ];

            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required',
                'title' => 'required|string',
                'service_link' => 'required|string',
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
    
            $updateSuccess = $serviceCommission->update([
                'vendor_id' => $request->vendor_id,
                'title' => $request->title,
                'description' => $request->description,
                'service_link' => $request->service_link,
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
