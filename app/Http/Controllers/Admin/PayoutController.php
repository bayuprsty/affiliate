<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payout;

class PayoutController extends Controller
{
    public function index () {
        return view('admin.payout.index');
    }

    public function store (Request $request) {
        if ($request->ajax()) {
            $this->validate($request, [
                'minimum_payout' => 'required|integer'
            ]);

            $data = [
                'minimum_payout' => $request->minimum_payout
            ];
    
            Payout::create($data);
    
            return $this->sendResponse('Minimum Payout Created Successfully');
        }
    }

    public function edit (Request $request) {
        if (request()->ajax()) {
            $minimumPayout = Payout::findOrFail($request->id);
            return response()->json($minimumPayout);
        }
    }

    public function update (Request $request) {
        if ($request->ajax()) {
            $this->validate($request, [
                'minimum_payout' => 'required|integer'
            ]);
    
            $minimumPayout = Payout::findOrfail($request->idPayout);
    
            $updateSuccess = $minimumPayout->update([
                'minimum_payout' => $request->minimum_payout
            ]);

            if ($updateSuccess) {
                return $this->sendResponse('Minimum Payout Updated');
            }
        }
    }

    public function destroy (Request $request) {
        $minimumPayout = Payout::findOrfail($request->id);

        if ($minimumPayout->delete()) {
            return $this->sendResponse('Minimum Payout Deleted');
        }
    }
}
