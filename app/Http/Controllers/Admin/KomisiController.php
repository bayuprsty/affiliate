<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $this->validate($request, [
                'vendor_id' => 'required',
                'title' => 'required|string',
                'commission_type_id' => 'required',
                'commission_value' => 'required|string'
            ]);
    
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
            $this->validate($request, [
                'vendor_id' => 'required',
                'title' => 'required|string',
                'commission_type_id' => 'required',
                'commission_value' => 'required|string'
            ]);
    
            $serviceCommission = ServiceCommission::findOrfail($request->idCommission);
    
            $updateSuccess = $serviceCommission->update([
                'vendor_id' => $request->vendor_id,
                'title' => $request->title,
                'description' => $request->description,
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
