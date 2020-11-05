<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

use App\User;
use App\Gender;

class UserController extends Controller
{
    public function index() {
        return view('admin.user.index');
    }

    public function detailProfile() {
        $user = User::findOrfail(Auth::id());

        return view('admin.user.detail', compact('user'));
    }

    public function detailUser($id) {
        $user = User::findOrfail($id);

        return view('admin.user.detail', compact('user'));
    }

    public function editProfile() {
        $user = User::findOrfail(Auth::id());
        $user->join_date = $this->convertDateView($user->join_date);
        $gender = Gender::all();

        return view('admin.user._edit_profile', compact('user', 'gender'));
    }

    public function editUser($id) {
        $user = User::findOrfail($id);
        $user->join_date = $this->convertDateView($user->join_date);
        $gender = Gender::all();

        return view('admin.user._edit_profile', compact('user', 'gender'));
    }

    public function updateProfile(Request $request) {
        if ($request->ajax()) {
            $this->validate($request, [
                'username' => 'required|string',
                'email' => 'required|string',
                'avatar' => 'sometimes|image|mimes:jpg,jpeg,png,svg|max:100'
            ]);

            $user = User::findOrfail($request->idUser);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = $user->username.'.'.$avatar->getClientOriginalExtension();

                if (file_exists(public_path('/uploads/avatar/'.$filename))) {
                    unlink(public_path('uploads/avatar/'.$filename));
                }

                Image::make($avatar)->resize(300, 300)->save( public_path('uploads/avatar/'.$filename) );
            } else {
                $filename = $user->avatar;
            }

            $data = [
                'username' => $request->username,
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'no_telepon' => $request->no_telepon,
                'email' => $request->email,
                'gender_id' => $request->gender_id,
                'jalan' => $request->jalan,
                'provinsi' => $request->provinsi,
                'kabupaten_kota' => $request->kabupaten_kota,
                'kecamatan' => $request->kecamatan,
                'kodepos' => $request->kodepos,
                'ktp' => $request->ktp,
                'nama_bank' => $request->nama_bank,
                'nomor_rekening' => $request->nomor_rekening,
                'atasnama_bank' => $request->atasnama_bank,
                'avatar' => $filename,
            ];

            $success = $user->update($data);

            if ($success) {
                return $this->sendResponse('Profile Updated Successfully', $user->id);
            }
        }
    }

    public function destroy(Request $request) {
        if ($request->ajax()) {
            $user = User::findOrfail($request->id);

            $result = User::checkUserRelation($user->id);

            if ($result) {
                $user->delete();

                return $this->sendResponse('User Affiliate Deleted');
            }
        }
    }
}