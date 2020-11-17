<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vendor;
use App\Models\Lead;

use DataTables;

class VendorController extends Controller
{
    public function index () {
        // $vendor = Vendor::orderBy('created_at', 'DESC')->get();

        return view('admin.vendor.index');
    }

    public function create () {
        return view('admin.vendor._create');
    }

    public function store (Request $request) {
        if ($request->ajax()) {
            $this->validate($request, [
                'email' => 'required|string|max:191',
            ]);

            $data = [
                'name' => $request->name,
                'link' => $request->link,
                'link_embed' => $request->link_embed,
                'marketing_text' => $request->marketing_text,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'jalan' => $request->jalan,
                'provinsi' => $request->provinsi,
                'kabupaten_kota' => $request->kabupaten_kota,
                'kecamatan' => $request->kecamatan,
                'kodepos' => $request->kodepos,
                'nomor_rekening' => $request->nomor_rekening
            ];
     
            Vendor::create($data);
            
            return $this->sendResponse('Vendor Created Succesfully');
        }
    }

    public function edit ($id) {
        $vendor = Vendor::find($id);

        return view('admin.vendor._edit', compact('vendor'));
    }

    public function update (Request $request) {
        if ($request->ajax()) {
            $this->validate($request, [
                'email' => 'required|string|max:191',
            ]);
    
            $vendor = Vendor::find($request->idVendor);
    
            $updateSuccess = $vendor->update([
                'name' => $request->name,
                'link' => $request->link,
                'link_embed' => $request->link_embed,
                'marketing_text' => $request->marketing_text,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'jalan' => $request->jalan,
                'provinsi' => $request->provinsi,
                'kabupaten_kota' => $request->kabupaten_kota,
                'kecamatan' => $request->kecamatan,
                'kodepos' => $request->kodepos,
                'nomor_rekening' => $request->nomor_rekening
            ]);

            if ($updateSuccess) {
                return $this->sendResponse('Vendor Updated Successfully');
            }
        }
    }

    public function destroy (Request $request) {
        if ($request->ajax()) {
            if (Lead::where('vendor_id', $request->id)) {
                return $this->sendResponse('Vendor used in another features', '', 221);
            } else {
                $isDeleted = Vendor::find($id)->delete();
    
                if ($isDeleted) {
                    return $this->sendResponse('Vendor Deleted Successfully');
                }
            }
        }
    }
}
