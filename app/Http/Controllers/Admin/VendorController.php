<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Vendor;
use App\Models\Lead;

use DataTables;

class VendorController extends Controller
{
    public function index () {
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
                'nomor_rekening' => $request->nomor_rekening,
                'secret_id' => Str::random(30)
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
            $isUpdated = Vendor::findOrfail($request->id)->update(['active' => false]);

            if ($isUpdated) {
                return $this->sendResponse('Vendor Deactivated Successfully');
            }
        }
    }

    public function activate (Request $request) {
        if ($request->ajax()) {
            $isUpdated = Vendor::findOrfail($request->id)->update(['active' => true]);

            if ($isUpdated) {
                return $this->sendResponse('Vendor Activated Successfully');
            }
        }
    }
}
